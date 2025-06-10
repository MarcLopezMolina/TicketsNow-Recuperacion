<?php
class UserController
{
    private $conn;

    public function __construct()
    {
        try 
        {
            // Conectar sin base de datos primero
            $pdo = new PDO("mysql:host=localhost", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear la base de datos si no existe
            $pdo->exec("CREATE DATABASE IF NOT EXISTS ticketsnow");

            // Ahora conectar a la base de datos
            $this->conn = new PDO("mysql:host=localhost;dbname=ticketsnow", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear tabla users si no existe
            $this->conn->exec("
                CREATE TABLE IF NOT EXISTS users (
                    id_user INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    name VARCHAR(100),
                    surname VARCHAR(100),
                    city VARCHAR(100) NOT NULL,
                    id_role INT,
                    profile_photo VARCHAR(255)
                )
            ");
        } catch (PDOException $e) 
        {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // ✅ NUEVO CAMPO DE CIUDAD ✅
    public function login() 
    {
        if (empty($_POST['email']) || empty($_POST['password'])) 
        {
            return "Todos los campos son obligatorios";
        }

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        try 
        {
            $pdo = new PDO("mysql:host=localhost;dbname=ticketsnow;charset=utf8", "root", "");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) 
            {
                // Iniciar sesión
                $_SESSION['logged_in'] = true;
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['id_role'] = $user['id_role'];

                header('Location: profile.php');
                exit();
            } else {
                return "Correo o contraseña incorrectos.";
            }
        } 
        catch (PDOException $e) 
        {
            return "Error de conexión: " . $e->getMessage();
        }
    }

    public function emailExists($email): bool
    {
        $stmt = $this->conn->prepare("SELECT id_user FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    public function updatePassword($email, $newPassword): void
    {
        $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$hashed, $email]);
    }

    public function logout(): void {}

    public function registerUser($data)
    {
        return $this->register($data, 1);
    }

    public function registerArtist($data)
    {
        return $this->register($data, 2);
    }

    public function registerAdmin($data)
    {
        return $this->register($data, 3);
    }

    // ✅ NUEVO CAMPO DE CIUDAD + VALIDACIÓN DE EMAIL + REGEX EN LA CONTRASEÑA ✅
    private function register($data, $role_id)
    {
        if (empty($data['email']) || empty($data['password']) || empty($data['nombre']) || empty($data['apellido']) || empty($data['ciudad'])) 
        {
            return "Todos los campos son obligatorios.";
        }

        $email = $data['email'];
        $rawPassword = $data['password'];

        // ✅ Validación de contraseña: exactamente 6 caracteres y al menos un número
        if (!preg_match('/^(?=.*\d)[A-Za-z\d]{6}$/', $rawPassword)) 
        {
            return "La contraseña debe tener exactamente 6 caracteres y al menos un número.";
        }

        $password = password_hash($rawPassword, PASSWORD_DEFAULT);
        $name = $data['nombre'];
        $surname = $data['apellido'];
        $city = $data['ciudad'];
        $profilePhoto = '';

        try 
        {
            $check = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $check->execute([$email]);

            if ($check->fetchColumn() > 0) {
                return "El correo electrónico ya está registrado.";
            }

            $stmt = $this->conn->prepare("
                INSERT INTO users (email, password, name, surname, city, id_role, profile_photo)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$email, $password, $name, $surname, $city, $role_id, $profilePhoto]);

            header("Location: login.php");
            exit;
        } 
        catch (PDOException $e) 
        {
            return "Error al registrar: " . $e->getMessage();
        }
    }

    public function deleteUser($id_user)
    {
        try {
            // Obtener la foto actual del usuario
            $stmt = $this->conn->prepare("SELECT profile_photo FROM users WHERE id_user = ?");
            $stmt->execute([$id_user]);
            $photo = $stmt->fetchColumn();

            // Eliminar usuario
            $stmt = $this->conn->prepare("DELETE FROM users WHERE id_user = ?");
            $stmt->execute([$id_user]);

            // Eliminar foto si no es la predeterminada
            $defaultPhoto = '../../media/img/Interfaces/user_icon.png';
            if ($photo && $photo !== $defaultPhoto) {
                $filePath = __DIR__ . '/../../' . str_replace('../', '', $photo);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Destruir sesión
            session_start();
            session_destroy();

            header("Location: login.php");
            exit();
        } catch (PDOException $e) {
            die("Error al eliminar el usuario: " . $e->getMessage());
        }
    }
}