<?php
require_once 'admin_functions.php';

$errors = []; // Массив для хранения ошибок

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $categoryId = $_POST['categoryId'];
    $width = isset($_POST['width']) ? $_POST['width'] : null;
    $height = isset($_POST['height']) ? $_POST['height'] : null;
    $length = isset($_POST['length']) ? $_POST['length'] : null;

    // Валидация данных
    if (empty($productName)) $errors[] = "Название продукта не может быть пустым";
    if (!is_numeric($price) || $price <= 0) $errors[] = "Цена должна быть числом больше 0";
    if (empty($categoryId)) $errors[] = "Выберите категорию";


    // Обработка загрузки изображения
    $img1 = null;
    if (isset($_FILES['img1']) && $_FILES['img1']['error'] == 0) {
        $targetDir = "../uploads/img/";
        $targetFile = $targetDir . basename($_FILES["img1"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        // Проверка типа файла
        $check = getimagesize($_FILES["img1"]["tmp_name"]);
        if($check === false) {
            $errors[] = "Загруженный файл не является изображением";
        }

        // Проверка размера файла
        if ($_FILES["img1"]["size"] > 5000000) {
            $errors[] = "Размер файла слишком большой";
        }

        // Разрешенные типы файлов
        if(!in_array($imageFileType, ["jpg", "png", "jpeg"])) {
            $errors[] = "Разрешены только файлы JPG, JPEG и PNG";
        }

        if (empty($errors)) { // Загрузка изображения только если нет ошибок валидации
            if (move_uploaded_file($_FILES["img1"]["tmp_name"], $targetFile)) {
                $img1 = basename( $_FILES["img1"]["name"]);
            } else {
                $errors[] = "Произошла ошибка при загрузке файла";
            }
        }
    }

    // Добавление товара
    if (empty($errors)) {
        try {
            if (addProduct($productName, $price, $description, $categoryId, $width, $height, $length, $img1)) {
                header("Location: products.php");
                exit();
            } else {
                $errors[] = "Ошибка добавления товара";
            }
        } catch (Exception $e) {
            $errors[] = "Ошибка базы данных: " . $e->getMessage();
            error_log("Database error: " . $e->getMessage());
        }
    }
    // Вывод ошибок валидации
    if (!empty($errors)) {
       foreach ($errors as $error) {
           echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>