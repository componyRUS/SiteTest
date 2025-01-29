<?php
require_once 'admin_functions.php';

var_dump($_POST);
var_dump($_FILES);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $categoryId = $_POST['categoryId'];
    $width = isset($_POST['width']) ? $_POST['width'] : null;
    $height = isset($_POST['height']) ? $_POST['height'] : null;
    $length = isset($_POST['length']) ? $_POST['length'] : null;

    // Обработка загрузки изображения
    $img1 = null;
    $uploadError = false; // Флаг для отслеживания ошибок загрузки

    if (isset($_FILES['img1']) && $_FILES['img1']['error'] == 0) {
        $targetDir = "../uploads/img/";
        $targetFile = $targetDir . basename($_FILES["img1"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        // Проверка типа файла
        $check = getimagesize($_FILES["img1"]["tmp_name"]);
        if($check === false) {
            echo "Ошибка: Загруженный файл не является изображением.<br>";
            $uploadError = true;
        }

        // Проверка размера файла
        if ($_FILES["img1"]["size"] > 5000000) {
            echo "Ошибка: Размер файла слишком большой.<br>";
            $uploadError = true;
        }

        // Разрешенные типы файлов
        if(!in_array($imageFileType, ["jpg", "png", "jpeg", "gif"])) {
            echo "Ошибка: Разрешены только файлы JPG, JPEG, PNG и GIF.<br>";
            $uploadError = true;
        }


        if (!$uploadError) {
            if (move_uploaded_file($_FILES["img1"]["tmp_name"], $targetFile)) {
                $img1 = basename( $_FILES["img1"]["name"]);
            } else {
                echo "Ошибка: Произошла ошибка при загрузке файла.<br>";
                $uploadError = true;
            }
        }
    }

    // Добавление товара ТОЛЬКО если не было ошибок загрузки
    if (!$uploadError) {
        if (addProduct($productName, $price, $description, $categoryId, $width, $height, $length, $img1)) {
            header("Location: products.php");
            exit();
        } else {
            echo "Ошибка добавления товара.<br>";
        }
    }
}
?>