<?php

class Admin extends Person {
    
    private $role;

    public function __construct($db) {
        parent::__construct($db);
    }

    // إنشاء فعالية جديدة
    public function createEvent($title, $description, $event_date, $location, $capacity, $price, $category, $image_url) {
        $query = "INSERT INTO events (title, description, event_date, location, capacity, price, category, image_url, created_by)
                VALUES (:title, :description, :event_date, :location, :capacity, :price, :category, :image_url, :created_by)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":event_date", $event_date);
            $stmt->bindParam(":location", $location);
            $stmt->bindParam(":capacity", $capacity);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":category", $category);
            $stmt->bindParam(":image_url", $image_url);
            $stmt->bindParam(":created_by", $this->person_id);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error creating event: " . $e->getMessage();
            return false;
        }
    }

    // تعديل فعالية
    public function editEvent($event_id, $title, $description, $event_date, $location, $capacity, $price, $category, $image_url) {
        $query = "UPDATE events SET title = :title, description = :description, event_date = :event_date,
                    location = :location, capacity = :capacity, price = :price, category = :category, image_url = :image_url
                    WHERE event_id = :event_id";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":event_date", $event_date);
            $stmt->bindParam(":location", $location);
            $stmt->bindParam(":capacity", $capacity);
            $stmt->bindParam(":price", $price);
            $stmt->bindParam(":category", $category);
            $stmt->bindParam(":image_url", $image_url);
            $stmt->bindParam(":event_id", $event_id);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error updating event: " . $e->getMessage();
            return false;
        }
    }

    // حذف فعالية
    public function deleteEvent($event_id) {
        $query = "DELETE FROM events WHERE event_id = :event_id";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":event_id", $event_id);
            return $stmt->execute();
        } catch(PDOException $e) {
            echo "Error deleting event: " . $e->getMessage();
            return false;
        }
    }

    // الحصول على إحصائيات الفعاليات
    public function getEventStats() {
        $query = "SELECT e.event_id, e.title, COUNT(t.ticket_id) as total_bookings,
                    SUM(t.quantity) as total_tickets, e.capacity - SUM(COALESCE(t.quantity, 0)) as remaining_capacity
                    FROM events e
                    LEFT JOIN tickets t ON e.event_id = t.event_id
                    GROUP BY e.event_id";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Error fetching stats: " . $e->getMessage();
            return false;
        }
    }
}
