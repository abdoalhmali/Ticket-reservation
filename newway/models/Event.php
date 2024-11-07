<?php
// models/Event.php

class Event {
    private $conn;
    private $table_name = "events";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllEvents() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY event_date DESC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error fetching events: " . $e->getMessage();
            return false;
        }
    }

    public function getEventById($event_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE event_id = :event_id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":event_id", $event_id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error fetching event: " . $e->getMessage();
            return false;
        }
    }
}