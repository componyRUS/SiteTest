<?php
session_start();

// проверка авторизации
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
require_once 'admin_functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление товарами</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'include/admin_header.php';?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'include/admin_sidebar.php';?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Управление товарами</h2>
               <a href="add_product.php" class="btn btn-primary mb-3">Добавить товар</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $products = getAllProducts();
                       if($products){
                            foreach ($products as $product) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($product['ProductId']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['ProductName']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['Price']) . "</td>";
                            echo "<td>";
                            echo "<a href='edit_product.php?id=" . htmlspecialchars($product['ProductId']) . "' class='btn btn-sm btn-secondary'>Редактировать</a> ";
                            echo "<a href='delete_product.php?id=" . htmlspecialchars($product['ProductId']) . "' class='btn btn-sm btn-danger'>Удалить</a>";
                            echo "</td>";
                            echo "</tr>";
                            }
                         }
                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
     <?php include 'include/admin_footer.php';?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>