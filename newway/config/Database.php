<?php
// config/Database.php

class Database {
    private $host = "localhost";
    private $db_name = "event_management_system";
    private $username = "root";
    private $password = "";
    private $conn;

    // Function to get a database connection
    public function getConnection() {
        // Initialize connection as null
        $this->conn = null;

        try {
            // Create a new PDO instance
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Set PDO error mode to exception for easier debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            echo "Database connected successfully.";

        } catch (PDOException $e) {
            // Catch any errors and display an error message
            echo "Connection Error: " . $e->getMessage();
        }

        return $this->conn;
    }
}

// Testing the connection (You can remove this in production)
$database = new Database();
$database->getConnection();
