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
function authenticateUser($email, $password) {
    global $conn;

    $sql = "SELECT UserId, Email, role, Password FROM users WHERE Email = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            return $user;
        }
    }
    return false;
}
function getAllProductComments() {
    global $conn;
    $sql = "SELECT pc.CommentId, pc.ProductId, pc.UserId, pc.CommentText, pc.CommentDate,
                   p.ProductName, u.FIO
            FROM ProductComments pc
            INNER JOIN Products p ON pc.ProductId = p.ProductId
            INNER JOIN users u ON pc.UserId = u.UserId
            ORDER BY pc.CommentId DESC";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("Ошибка при получении комментариев: " . $conn->error);
        return false;
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function deleteProductComment($commentId) {
    global $conn;
    $sql = "DELETE FROM ProductComments WHERE CommentId = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Ошибка при подготовке запроса deleteProductComment: " . $conn->error);
        return false;
    }
    $stmt->bind_param("i", $commentId);
    if (!$stmt->execute()) {
        error_log("Ошибка при выполнении запроса deleteProductComment: " . $conn->error);
        return false;
    }
    return $stmt->affected_rows > 0;
}
function getAllOrders() {
    global $conn;
    $sql = "SELECT o.order_id, o.order_date, o.total_amount, o.payment_method, o.notes, o.status, o.ContactNumber,
                   GROUP_CONCAT(CONCAT(oi.product_name, ' (', oi.quantity, ')') SEPARATOR ', ') AS product_names,
                    u.FIO
            FROM orders o
            LEFT JOIN order_items oi ON o.order_id = oi.order_id
            LEFT JOIN users u ON o.user_id = u.UserId
            GROUP BY o.order_id
            ORDER BY o.order_date DESC";
    $result = $conn->query($sql);
    if ($result === false) {
        error_log("Ошибка при получении всех заказов: " . $conn->error);
        return false;
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getOrderById($orderId) {
    global $conn;
    $sql = "SELECT o.order_id, o.order_date, o.total_amount, o.payment_method, o.notes, o.status, o.ContactNumber,
                    u.FIO
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.UserId
            WHERE o.order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Ошибка при подготовке запроса getOrderById: " . $conn->error);
        return false;
    }
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
         error_log("Ошибка при получении заказа по ID: " . $conn->error);
         return false;
     }
    return $result->fetch_assoc();
}
function updateOrderStatus($orderId, $newStatus) {
    global $conn;
    $sql = "UPDATE orders SET status = ? WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
     if (!$stmt) {
        error_log("Ошибка при подготовке запроса updateOrderStatus: " . $conn->error);
        return false;
    }
    $stmt->bind_param("si", $newStatus, $orderId);
    if (!$stmt->execute()) {
       error_log("Ошибка при выполнении запроса updateOrderStatus: " . $stmt->error);
        return false;
    }
    return $stmt->affected_rows > 0;
}

function deleteOrder($orderId) {
    global $conn;
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
         error_log("Ошибка при подготовке запроса deleteOrder: " . $conn->error);
         return false;
     }
    $stmt->bind_param("i", $orderId);
    if (!$stmt->execute()) {
         error_log("Ошибка при выполнении запроса deleteOrder: " . $conn->error);
         return false;
     }
    return $stmt->affected_rows > 0;
}
?>