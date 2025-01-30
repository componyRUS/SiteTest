<?php
require_once 'admin_functions.php';

// Проверяем, авторизован ли пользователь и является ли он администратором
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = getCategoryById($categoryId);

if (!$category) {
    echo "Категория не найдена.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать категорию</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'include/admin_header.php';?>
    <div class="container-fluid">
        <div class="row">
           <?php include 'include/admin_sidebar.php';?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Редактировать категорию</h2>
                <form method="post" action="edit_category_handler.php?id=<?= $categoryId ?>">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Название категории</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" value="<?= htmlspecialchars($category['CategoryName']) ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </main>
        </div>
    </div>
    <?php include 'include/admin_footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>