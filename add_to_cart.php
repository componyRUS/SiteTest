<?php
session_start();
require_once 'include/functions.php';

// Получаем ID товара из POST-параметра
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $productIdPost = (int)$_POST['product_id'];

    $product = null;
    foreach(getProducts() as $p){
        if($p['ProductId'] == $productIdPost){
            $product = $p;
            break;
        }
    }

   if($product != null){
        if (!isset($_SESSION['cart'])) {
             $_SESSION['cart'] = [];
        }
        if(isset($_SESSION['cart'][$productIdPost]))
        {
             $_SESSION['cart'][$productIdPost]['quantity'] += 1;
        }
        else {
             $_SESSION['cart'][$productIdPost] = [
                'name' => $product['ProductName'],
                'price' => $product['Price'],
                'quantity' => 1
            ];
        }
    }
}

$cartCount = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartCount += $item['quantity'];
    }
}

header('Content-Type: application/json');
echo json_encode(['cartCount' => $cartCount]);
?>