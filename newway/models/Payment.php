<?php
// models/Payment.php

class Payment {
    private $conn;
    private $table_name = "payments";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function processPayment($ticket_id, $amount, $payment_method) {
        $query = "INSERT INTO " . $this->table_name . "
                 (ticket_id, amount, payment_method, payment_status, transaction_id)
                 VALUES (:ticket_id, :amount, :payment_method, 'PENDING', :transaction_id)";

        try {
            $stmt = $this->conn->prepare($query);

            $transaction_id = 'TXN' . time() . rand(1000, 9999);

            $stmt->bindParam(":ticket_id", $ticket_id);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":payment_method", $payment_method);
            $stmt->bindParam(":transaction_id", $transaction_id);

            if($stmt->execute()) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch(PDOException $e) {
            echo "Error processing payment: " . $e->getMessage();
            return false;
        }
    }

    public function updatePaymentStatus($payment_id, $status) {
        $query = "UPDATE " . $this->table_name . "
                 SET payment_status = :status
                 WHERE payment_id = :payment_id";

        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":payment_id", $payment_id);

            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error updating payment: " . $e->getMessage();
            return false;
        }
    }
}