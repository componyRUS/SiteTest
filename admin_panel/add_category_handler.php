<?php
require_once 'admin_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST['categoryName'];

   if (addCategory($categoryName)) {
        header("Location: categories.php?add=success");
        exit();
    } else {
        echo "Ошибка добавления категории.";
    }
}
?>