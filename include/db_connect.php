<?php

$servername = "localhost"; // Имя сервера базы данных
$username = "admin"; // Имя пользователя базы данных
$password = "admin"; // Пароль пользователя базы данных
$dbname = "shop_db"; // Имя базы данных

// Создаем соединение с базой данных
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем соединение
if ($conn->connect_error) {
  die("Ошибка подключения к базе данных: " . $conn->connect_error);
}
// echo "Подключение к базе данных успешно!"; // Раскомментируйте для проверки

// Устанавливаем кодировку для корректного отображения кириллицы
$conn->set_charset("utf8");

?>

