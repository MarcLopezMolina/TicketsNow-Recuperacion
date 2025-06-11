<?php

class User
{
    private $name;
    private $surname;
    private $dni;
    private $email;
    private $password;

    public function __construct($name, $surname, $dni, $email, $password)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->dni = $dni;
        $this->email = $email;
        $this->password = $password;
    }

    // Getters and Setters
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
}