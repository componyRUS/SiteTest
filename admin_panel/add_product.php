<?php
require_once 'admin_functions.php';
// проверка авторизации
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
$categories = getAllCategories();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'include/admin_header.php';?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'include/admin_sidebar.php';?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Добавить товар</h2>
                <form method="post" action="add_product_handler.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="productName" class="form-label">Название</label>
                        <input type="text" class="form-control" id="productName" name="productName" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Цена</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="width" class="form-label">Ширина</label>
                        <input type="number" class="form-control" id="width" name="width" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="height" class="form-label">Высота</label>
                        <input type="number" class="form-control" id="height" name="height" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="length" class="form-label">Длина</label>
                        <input type="number" class="form-control" id="length" name="length" step="0.01">
                    </div>
                    <div class="mb-3">
                        <label for="img1" class="form-label">Изображение 1</label>
                        <input type="file" class="form-control" id="img1" name="img1">
                    </div>
                    <div class="mb-3">
                        <label for="categoryId" class="form-label">Категория</label>
                        <select class="form-select" id="categoryId" name="categoryId" required>
                            <?php
                            if ($categories) {
                                foreach ($categories as $category) {
                                    echo "<option value='" . htmlspecialchars($category['CategoryId']) . "'>" . htmlspecialchars($category['CategoryName']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </main>
        </div>
    </div>
    <?php include 'include/admin_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>