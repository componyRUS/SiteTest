<?php
require_once 'admin_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $categoryId = $_POST['categoryId'];
    $width = isset($_POST['width']) ? $_POST['width'] : null;
    $height = isset($_POST['height']) ? $_POST['height'] : null;
    $length = isset($_POST['length']) ? $_POST['length'] : null;

    // Обработка загрузки изображения (аналогично add_product_handler.php)
    $img1 = null;
    if (isset($_FILES['img1']) && $_FILES['img1']['error'] == 0) {
        $targetDir = "../uploads/img/";
        $targetFile = $targetDir . basename($_FILES["img1"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["img1"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "Ошибка: Загруженный файл не является изображением.";
            $uploadOk = 0;
        }

        if ($_FILES["img1"]["size"] > 5000000) {
            echo "Ошибка: Размер файла слишком большой.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Ошибка: Разрешены только файлы JPG, JPEG, PNG и GIF.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Ошибка: Файл не был загружен.";
        } else {
            if (move_uploaded_file($_FILES["img1"]["tmp_name"], $targetFile)) {
                $img1 = basename( $_FILES["img1"]["name"]);
            } else {
                echo "Ошибка: Произошла ошибка при загрузке файла.";
            }
        }
    }
      if (editProduct($productId, $productName, $price, $description, $categoryId, $width, $height, $length, $img1)) {
         header("Location: products.php");
         exit();
     } else {
         echo "Ошибка: Не удалось обновить товар.";
     }
}
?>