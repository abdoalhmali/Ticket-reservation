<?php
// admin_dashboard.php

session_start();
require_once 'config/database.php';
require_once 'models/Person.php';
require_once 'models/Admin.php';

// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

$database = new Database();
$db = $database->getConnection();
$admin = new Admin($db);
$message = '';

// إنشاء فعالية جديدة
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'create') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];

    $result = $admin->createEvent($title, $description, $event_date, $location, $capacity, $price, $category, $image_url);
    $message = $result ? "Event created successfully!" : "Failed to create event.";
}

// تعديل فعالية
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $event_id = $_POST['event_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_url = $_POST['image_url'];

    $result = $admin->editEvent($event_id, $title, $description, $event_date, $location, $capacity, $price, $category, $image_url);
    $message = $result ? "Event updated successfully!" : "Failed to update event.";
}

// حذف فعالية
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $event_id = $_POST['event_id'];
    $result = $admin->deleteEvent($event_id);
    $message = $result ? "Event deleted successfully!" : "Failed to delete event.";
}

$eventStats = $admin->getEventStats();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Admin Dashboard</h1>

    <?php if ($message): ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- استمارة إنشاء فعالية جديدة -->
    <div class="card mt-4">
        <div class="card-header">Create New Event</div>
        <div class="card-body">
            <form method="POST" action="admin_dashboard.php">
                <input type="hidden" name="action" value="create">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <input type="text" class="form-control" id="category" name="category" required>
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label">Image URL</label>
                    <input type="text" class="form-control" id="image_url" name="image_url">
                </div>
                <button type="submit" class="btn btn-primary">Create Event</button>
            </form>
        </div>
    </div>

    <!-- جدول إحصائيات الفعاليات -->
    <div class="card mt-4">
        <div class="card-header">Event Statistics</div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>Title</th>
                        <th>Total Bookings</th>
                        <th>Total Tickets</th>
                        <th>Remaining Capacity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($eventStats as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['event_id']); ?></td>
                            <td><?php echo htmlspecialchars($event['title']); ?></td>
                            <td><?php echo htmlspecialchars($event['total_bookings']); ?></td>
                            <td><?php echo htmlspecialchars($event['total_tickets']); ?></td>
                            <td><?php echo htmlspecialchars($event['remaining_capacity']); ?></td>
                            <td>
                                <!-- زر التعديل -->
                                <button class="btn btn-warning btn-sm" onclick="openEditModal(<?php echo $event['event_id']; ?>)">Edit</button>

                                <!-- زر الحذف -->
                                <form method="POST" action="admin_dashboard.php" style="display:inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="event_id" value="<?php echo $event['event_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// JavaScript to handle opening the edit modal and populating it with data
function openEditModal(event_id) {
    // Code to open modal and populate with event data goes here
}
</script>

</body>
</html>
