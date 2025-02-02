<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin_functions.php';
// проверка авторизации
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Проверка, есть ли параметр id в запросе
if (isset($_GET['id'])) {
    $categoryId = (int)$_GET['id']; // Преобразование в целое число

    // Проверка на корректность ID
    if ($categoryId > 0) {
        // Удаление категории
        if (deleteCategory($categoryId)) {
            header("Location: categories.php?delete=success");
            exit();
        } else {
            echo "<p style='color:red;'>Ошибка: Не удалось удалить категорию.</p>";
        }
    } else {
        echo "<p style='color:red;'>Некорректный ID категории.</p>";
    }
} else {
    echo "<p style='color:red;'>ID категории не указан.</p>";
}
?>