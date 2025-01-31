<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin_functions.php';

// Проверка, есть ли параметр id в запросе
if (isset($_GET['id'])) {
    $orderId = (int)$_GET['id']; // Преобразование в целое число

    // Проверка на корректность ID
    if ($orderId > 0) {
        // Удаление заказа
        if (deleteOrder($orderId)) {
            header("Location: orders.php?delete=success");
            exit();
        } else {
            echo "<p style='color:red;'>Ошибка: Не удалось удалить заказ.</p>";
        }
    } else {
        echo "<p style='color:red;'>Некорректный ID заказа.</p>";
    }
} else {
    echo "<p style='color:red;'>ID заказа не указан.</p>";
}
?>