<?php
// login.php

session_start();
require_once 'config/database.php';
require_once 'models/Person.php';

class User extends Person {
    // Extending Person in case you want to add specific functionalities for the User in future
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user_data = $user->login($email, $password);
    if ($email === 'abdoalhmali092@gmail.com' && $password === 'abdullah') {
        header("Location: admin_dashboard.php");
        $_SESSION['user_id'] = $user_data['person_id'];
        $_SESSION['name'] = $user_data['name'];
        exit();
    // تحقق من تسجيل الدخول
    if ($user_data) {
        // تحقق مما إذا كان المستخدم هو 'abdullah' وكلمة المرور 'abdullah'
            // توجيه مباشرة إلى صفحة لوحة تحكم الأدمن
            // توجيه إلى صفحة أخرى للمستخدمين العاديين إذا أردت
            $_SESSION['user_id'] = $user_data['person_id'];
            $_SESSION['name'] = $user_data['name'];
            header("Location: user_dashboard.php"); // صفحة أخرى، يمكن تعديلها حسب الحاجة
            exit();
        }
    } else {
        $message = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Login</h2>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST" action="#">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>
