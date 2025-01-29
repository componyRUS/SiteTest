<?php
require_once 'admin_functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление категориями</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
     <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'include/admin_header.php';?>
    <div class="container-fluid">
        <div class="row">
           <?php include 'include/admin_sidebar.php';?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Управление категориями</h2>
                <a href="add_category.php" class="btn btn-primary mb-3">Добавить категорию</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $categories = getAllCategories();
                        if($categories){
                            foreach ($categories as $category) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($category['CategoryId']) . "</td>";
                            echo "<td>" . htmlspecialchars($category['CategoryName']) . "</td>";
                            echo "<td>";
                            echo "<a href='edit_category.php?id=" . htmlspecialchars($category['CategoryId']) . "' class='btn btn-sm btn-secondary'>Редактировать</a> ";
                            echo "<a href='delete_category.php?id=" . htmlspecialchars($category['CategoryId']) . "' class='btn btn-sm btn-danger'>Удалить</a>";
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