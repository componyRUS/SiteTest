<?php
session_start();
require_once 'admin_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = authenticateUser($email, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['UserId'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Неверный email или пароль.";
        header("Location: login.php");
        exit();
    }
}
?>