<?php
require_once 'admin_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productName'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $categoryId = $_POST['categoryId'];
    $width = isset($_POST['width']) ? $_POST['width'] : null;
    $height = isset($_POST['height']) ? $_POST['height'] : null;
    $length = isset($_POST['length']) ? $_POST['length'] : null;

    //Обработка загрузки изображения
    $img1 = null;
    if (isset($_FILES['img1']) && $_FILES['img1']['error'] == 0) {
        $targetDir = "../uploads/img/"; // Укажите директорию для загрузки
        $targetFile = $targetDir . basename($_FILES["img1"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["img1"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }


        // Check file size
        if ($_FILES["img1"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["img1"]["tmp_name"], $targetFile)) {
                $img1 = basename( $_FILES["img1"]["name"]);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }


    if (addProduct($productName, $price, $description, $categoryId, $width, $height, $length, $img1)) {
        header("Location: products.php");
        exit();
    } else {
        echo "Ошибка добавления товара.";
    }
}
?>