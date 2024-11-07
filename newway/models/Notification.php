<?php
// models/Notification.php

class Notification {
    private $conn;
    private $table_name = "notifications";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function createNotification($person_id, $title, $message) {
        $query = "INSERT INTO " . $this->table_name . "
                 (person_id, title, message)
                 VALUES (:person_id, :title, :message)";

        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":person_id", $person_id);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":message", $message);

            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error creating notification: " . $e->getMessage();
            return false;
        }
    }

    public function getUserNotifications($person_id) {
        $query = "SELECT * FROM " . $this->table_name . "
                 WHERE person_id = :person_id
                 ORDER BY created_at DESC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":person_id", $person_id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error fetching notifications: " . $e->getMessage();
            return false;
        }
    }
}