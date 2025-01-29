<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
  $action = isset($_POST['action']) ? $_POST['action'] : '';


  if ($productId > 0 && isset($_SESSION['cart'][$productId])){

     if ($action == 'increase') {
         $_SESSION['cart'][$productId]['quantity'] += 1;
     } else if ($action == 'decrease') {
      if($_SESSION['cart'][$productId]['quantity'] > 1){
           $_SESSION['cart'][$productId]['quantity'] -= 1;
       }

      }else if($action == 'remove'){
           unset($_SESSION['cart'][$productId]);
      }
   }
}
 header("location:cart.php");
?>