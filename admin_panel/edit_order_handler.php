<?php
require_once 'admin_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $newStatus = $_POST['status'];

    error_log("order_id={$orderId}, status={$newStatus}");

    if (updateOrderStatus($orderId, $newStatus)) {
        header("Location: orders.php?edit=success");
        exit();
    } else {
        echo "Ошибка при обновлении статуса заказа.";
        error_log("Ошибка при обновлении статуса заказа order_id={$orderId}, status={$newStatus}");
    }
}
?>