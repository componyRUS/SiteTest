<?php
session_start();
require 'include/db_connect.php';

$fio = $_POST['registerFullName'];
$email = $_POST['registerEmail'];
$password = $_POST['registerPassword'];
$confirmPassword = $_POST['registerConfirmPassword'];

if ($password != $confirmPassword) {
    echo "Пароли не совпадают";
    exit;
}
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Проверяем наличие пользователя с таким Email
$sql_check = "SELECT Email FROM users WHERE Email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "Пользователь с таким email уже зарегистрирован.";
    $stmt_check->close();
    exit;
}
$stmt_check->close();

$sql = "INSERT INTO users (FIO, Email, Password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $fio, $email, $hashed_password);


if ($stmt->execute()) {
    $sql = "SELECT Userid FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userid'] = $row['Userid'];
         $_SESSION['FIO'] = $fio;
    }
    header('Location: index.php');
    exit();

} else {
    echo "Ошибка при регистрации: " . $conn->error;
}

$stmt->close();
$conn->close();
?>