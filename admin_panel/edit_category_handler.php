<?php
require_once 'admin_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $categoryName = $_POST['categoryName'];

    if (editCategory($categoryId, $categoryName)) {
        header("Location: categories.php?edit=success");
        exit();
    } else {
         echo "Ошибка при обновлении категории.";
    }
}
?>