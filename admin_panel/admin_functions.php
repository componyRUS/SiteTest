<?php
require_once '../include/db_connect.php'; // Подключение к базе данных
function getAllProducts() {
    global $conn;
    $sql = "SELECT * FROM Products";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("Ошибка при получении всех товаров: " . $conn->error); // Запись ошибки в лог
        return false; // Возвращаем false в случае ошибки
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProductById($id) {
    global $conn;
    $sql = "SELECT ProductId, CategoryId, ProductName, Price, Description, Width, Height, Length, img1 FROM Products WHERE ProductId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
function addProduct($name, $price, $description, $category_id, $width = null, $height = null, $length = null, $img1 = null) {
    global $conn;
    $sql = "INSERT INTO Products (ProductName, Price, Description, CategoryId, Width, Height, Length, img1) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Ошибка при подготовке запроса addProduct: " . $conn->error);
        return false;
    }
    $stmt->bind_param("sdsiddss", $name, $price, $description, $category_id, $width, $height, $length, $img1);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Ошибка при выполнении запроса addProduct: " . $conn->error);
        return false;
    }
}
function editProduct($id, $name, $price, $description, $category_id, $width, $height, $length, $img1 = null) {
    global $conn;
    $sql = "UPDATE Products SET ProductName = ?, Price = ?, Description = ?, CategoryId = ?, Width = ?, Height = ?, Length = ?";

    if($img1){
        $sql .= ", img1 = ?";
    }
    $sql .= " WHERE ProductId = ?";
    $stmt = $conn->prepare($sql);

    if($img1){
        $stmt->bind_param("sdsiddssi", $name, $price, $description, $category_id, $width, $height, $length, $img1, $id);
    }else{
        $stmt->bind_param("sdsiddi", $name, $price, $description, $category_id, $width, $height, $length, $id);
    }


    if ($stmt->execute()) {
        return true;
    }
    else{
        return false;
    }
}


function deleteProduct($id) {
    global $conn;
    $sql = "DELETE FROM Products WHERE ProductId = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Ошибка при подготовке запроса deleteProduct: " . $conn->error);
        return false;
    }
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Ошибка при выполнении запроса deleteProduct: " . $conn->error);
        return false;
    }
}

function getAllCategories() {
    global $conn;
    $sql = "SELECT CategoryId, CategoryName FROM Categories";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("Ошибка при получении всех категорий: " . $conn->error);
        return false;
    }
    $categories = []; // Используйте более современный синтаксис
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    return $categories;
}

function getCategoryById($id) {
    global $conn;
    $sql = "SELECT * FROM Categories WHERE CategoryId = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Ошибка при подготовке запроса getCategoryById: " . $conn->error);
        return false;
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        error_log("Ошибка при выполнении запроса getCategoryById: " . $conn->error);
        return false;
    }
    $result = $stmt->get_result();
    if ($result === false) {
        error_log("Ошибка при получении результата getCategoryById: " . $conn->error);
        return false;
    }
    return $result->fetch_assoc();
}

function addCategory($name) {
    global $conn;
    $sql = "INSERT INTO Categories (CategoryName) VALUES (?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Ошибка при подготовке запроса addCategory: " . $conn->error);
        return false;
    }
    $stmt->bind_param("s", $name);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Ошибка при выполнении запроса addCategory: " . $conn->error);
        return false;
    }
}

function editCategory($id, $name) {
    global $conn;
    $sql = "UPDATE Categories SET CategoryName = ? WHERE CategoryId = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Ошибка при подготовке запроса editCategory: " . $conn->error);
        return false;
    }
    $stmt->bind_param("si", $name, $id);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Ошибка при выполнении запроса editCategory: " . $conn->error);
        return false;
    }
}

function deleteCategory($id) {
    global $conn;
    $sql = "DELETE FROM Categories WHERE CategoryId = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Ошибка при подготовке запроса deleteCategory: " . $conn->error);
        return false;
    }
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return true;
    } else {
        error_log("Ошибка при выполнении запроса deleteCategory: " . $conn->error);
        return false;
    }
}
?>