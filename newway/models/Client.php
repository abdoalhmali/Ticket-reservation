<?php
// models/Client.php

class Client extends Person {
    private $is_premium;
    private $points;

    public function __construct($db) {
        parent::__construct($db);
    }

    public function register($name, $email, $phone, $password) {
        $person_id = parent::register($name, $email, $phone, $password);

        if($person_id) {
            $query = "INSERT INTO clients (client_id, is_premium, points)
                     VALUES (:client_id, false, 0)";

            try {
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":client_id", $person_id);

                if($stmt->execute()) {
                    return true;
                }
                return false;
            } catch(PDOException $e) {
                echo "Client Registration Error: " . $e->getMessage();
                return false;
            }
        }
        return false;
    }

    public function bookTicket($event_id, $quantity) {
        $query = "INSERT INTO tickets (event_id, client_id, quantity)
                VALUES (:event_id, :client_id, :quantity)";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":event_id", $event_id);
            $stmt->bindParam(":client_id", $this->person_id);
            $stmt->bindParam(":quantity", $quantity);

            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Booking Error: " . $e->getMessage();
            return false;
        }
    }

    public function getBookings() {
        $query = "SELECT t.*, e.title, e.event_date, e.location
                FROM tickets t
                JOIN events e ON t.event_id = e.event_id
                WHERE t.client_id = :client_id";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":client_id", $this->person_id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error fetching bookings: " . $e->getMessage();
            return false;
        }
    }
}