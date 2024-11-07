<?php
// models/Ticket.php

class Ticket {
    private $conn;
    private $table_name = "tickets";

    public function __construct($db) {
        $this->conn = $db;
    }

    // إنشاء تذكرة جديدة
    public function createTicket($event_id, $client_id, $seatNumber) {
        $query = "INSERT INTO " . $this->table_name . "
                (event_id, client_id, seat_number, status)
                VALUES (:event_id, :client_id, :seat_number, 'PENDING')";

        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":event_id", $event_id);
            $stmt->bindParam(":client_id", $client_id);
            $stmt->bindParam(":seat_number", $seatNumber);

            if($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch(PDOException $e) {
            echo "Error creating ticket: " . $e->getMessage();
            return false;
        }
    }

    // تحديث حالة التذكرة
    public function updateStatus($ticket_id, $status) {
        $query = "UPDATE " . $this->table_name . "
                    SET status = :status
                    WHERE ticket_id = :ticket_id";

        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":ticket_id", $ticket_id);

            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error updating ticket: " . $e->getMessage();
            return false;
        }
    }

    // تأكيد الحجز
    public function confirmBooking($ticket_id) {
        return $this->updateStatus($ticket_id, 'CONFIRMED');
    }

    // تعديل بيانات التذكرة (مثل تغيير رقم المقعد)
    public function modifyTicket($ticket_id, $newSeatNumber) {
        $query = "UPDATE " . $this->table_name . "
                    SET seat_number = :seat_number
                    WHERE ticket_id = :ticket_id";

        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":seat_number", $newSeatNumber);
            $stmt->bindParam(":ticket_id", $ticket_id);

            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error modifying ticket: " . $e->getMessage();
            return false;
        }
    }

    // إلغاء التذكرة
    public function cancelTicket($ticket_id) {
        return $this->updateStatus($ticket_id, 'CANCELLED');
    }

    // استرداد التذكرة
    public function refundTicket($ticket_id) {
        return $this->updateStatus($ticket_id, 'REFUNDED');
    }
}

