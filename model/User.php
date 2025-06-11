<?php

class User
{
    private $name;
    private $surname;
    private $dni;
    private $telefono; //<!--🆕 NUEVO CAMPO DE TELEFONO 🆕-->
    private $email;
    private $password;

    public function __construct($name, $surname, $dni, $telefono, $email, $password) //<!--🆕 NUEVO CAMPO DE TELEFONO 🆕-->
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->dni = $dni;
        $this->telefono = $telefono;
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

    //<!--🆕 NUEVO CAMPO DE TELEFONO 🆕-->
    public function getTelefono()
    {
        return $this->telefono;
    }

    //<!--🆕 NUEVO CAMPO DE TELEFONO 🆕-->
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
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