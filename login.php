<?php
session_start();
require 'include/db_connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['Password'])) {
        // Успешная авторизация
        $_SESSION['FIO'] = $row['FIO']; // Сохраняем имя пользователя
        $_SESSION['userid'] = $row['Userid']; //Сохраняем id пользователя
        echo "успешно"; // Важно: Выводим просто текст
    } else {
        echo "Неправильный пароль"; // Важно: Выводим просто текст
    }
} else {
    echo "Пользователь с таким email не найден."; // Важно: Выводим просто текст
}
$stmt->close();
$conn->close();
?>