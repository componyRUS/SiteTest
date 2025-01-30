<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin_functions.php';


$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);



if ($productId <= 0) {
    echo "Некорректный ID продукта.";
    exit;
}


if (deleteProduct($productId)) {
    header("Location: products.php?delete=success");
    exit();
} else {
    echo "Ошибка: Не удалось удалить товар.";
}
?>