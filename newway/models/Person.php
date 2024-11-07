<?php
// models/Person.php

abstract class Person {
    protected $conn;
    protected $person_id;
    protected $name;
    protected $email;
    protected $phone;
    protected $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register($name, $email, $phone, $password) {
        $query = "INSERT INTO persons (name, email, phone, password)
                 VALUES (:name, :email, :phone, :password)";

        try {
            $stmt = $this->conn->prepare($query);

            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":password", $password_hash);

            if($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch(PDOException $e) {
            echo "Registration Error: " . $e->getMessage();
            return false;
        }
    }

    public function login($email, $password) {
        $query = "SELECT * FROM persons WHERE email = :email";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if(password_verify($password, $row['password'])) {
                    return $row;
                }
            }
            return false;
        } catch(PDOException $e) {
            echo "Login Error: " . $e->getMessage();
            return false;
        }
    }

    // Getters and Setters
    public function getPersonId() {
        return $this->person_id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }
}