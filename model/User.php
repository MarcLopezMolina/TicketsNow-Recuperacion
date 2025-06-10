<?php

class User
{
    private $name;
    private $surname;
    private $city;
    private $phone;
    private $email;
    private $password;

    public function __construct($name, $surname, $city, $phone, $email, $password){
        $this->name = $name;
        $this->surname = $surname;
        $this->city = $city;
        $this->phone = $phone;
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

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
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