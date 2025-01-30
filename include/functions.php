<?php
require_once 'db_connect.php';

function getProducts($search = '', $sort = '', $categoryFilter = 0) {
    global $conn;
    $sql = "SELECT ProductId, ProductName, Price, Description, CategoryId, img1 FROM Products WHERE 1=1";

    if (!empty($search)) {
        $sql .= " AND ProductName LIKE ?";
    }
     if($categoryFilter > 0){
        $sql .= " AND CategoryId = ?";
    }

    if ($sort == 'price_asc') {
        $sql .= " ORDER BY Price ASC";
    } elseif ($sort == 'price_desc') {
        $sql .= " ORDER BY Price DESC";
    }
     elseif ($sort == 'name_asc') {
        $sql .= " ORDER BY ProductName ASC";
    }
    elseif ($sort == 'name_desc') {
        $sql .= " ORDER BY ProductName DESC";
    }
     else {
        $sql .= " ORDER BY ProductName";
    }

    $stmt = $conn->prepare($sql);

   if (!empty($search) && $categoryFilter > 0) {
        $searchParam = "%" . $search . "%";
        $stmt->bind_param("si", $searchParam, $categoryFilter);
    }
   elseif (!empty($search)) {
       $searchParam = "%" . $search . "%";
       $stmt->bind_param("s", $searchParam);
    }
       elseif ($categoryFilter > 0) {
        $stmt->bind_param("i", $categoryFilter);
       }


    if(!$stmt->execute()){
       error_log("Ошибка при выполнении запроса getProducts: " . $stmt->error);
       return [];
    }
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
    return $products;
}

function getCategoryName($categoryId) {
    global $conn;
    $sql = "SELECT CategoryName FROM Categories WHERE CategoryId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    if(!$stmt->execute()){
        error_log("Ошибка при выполнении запроса getCategoryName: " . $stmt->error);
         return 'Неизвестная категория';
    }
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $categoryName = $row['CategoryName'];
    } else {
        $categoryName = 'Неизвестная категория';
    }
   $stmt->close();
    return $categoryName;
}

function getCategories() {
    global $conn;
    $sql = "SELECT CategoryId, CategoryName FROM Categories";
     $stmt = $conn->prepare($sql);
     if(!$stmt->execute()){
        error_log("Ошибка при выполнении запроса getCategories: " . $stmt->error);
          return [];
    }
    $result = $stmt->get_result();
    $categories = [];
     while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
   $stmt->close();
    return $categories;
}
?>