<?php
session_start();

require_once 'admin_panel/admin_functions.php';
require_once 'include/db_connect.php';

// Проверка авторизации и наличия корзины
if (!isset($_SESSION['FIO']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: index.php?error=order_error");
    exit();
}

// Получение данных из формы
$userName = $_POST['userName'] ?? '';
$userEmail = $_POST['userEmail'] ?? '';
$userPhone = $_POST['userPhone'] ?? '';
$userAddress = $_POST['userAddress'] ?? '';
$userId = $_SESSION['id'] ?? null;

// Генерация уникального номера заказа
$orderNumber = 'ORDER-' . uniqid();

$totalAmount = 0;
    foreach ($_SESSION['cart'] as $item) {
       $totalAmount += $item['price'] * $item['quantity'];
   }


// Сохранение заказа в БД
$sql_order = "INSERT INTO orders (order_number, user_id, total_amount, shipping_address) VALUES (?, ?, ?, ?)";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("sids", $orderNumber, $userId, $totalAmount, $userAddress);

if ($stmt_order->execute()) {
   $orderId = $conn->insert_id;

   // Сохранение товаров заказа в БД
   $sql_items = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
       $stmt_items = $conn->prepare($sql_items);
       foreach ($_SESSION['cart'] as $productId => $item) {
           $stmt_items->bind_param("iiid", $orderId, $productId, $item['quantity'], $item['price']);
           $stmt_items->execute();
       }
    // Очистка корзины после оформления заказа
    unset($_SESSION['cart']);
    header("Location: index.php?success=order_placed");
    exit();

} else {
    error_log("Ошибка при добавлении заказа: " . $conn->error);
    header("Location: index.php?error=order_fail");
    exit();
}
?>