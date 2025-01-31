<?php
require_once 'admin_functions.php';

// проверка авторизации
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление комментариями</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'include/admin_header.php';?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'include/admin_sidebar.php';?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Управление комментариями</h2>
                <?php
                // Выводим сообщение об успешном удалении, если оно есть в URL
                if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
                    echo "<div class='alert alert-success' role='alert'>Комментарий успешно удален!</div>";
                }
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Продукт</th>
                            <th>Автор</th>
                            <th>Комментарий</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Получаем список всех комментариев
                    $comments = getAllProductComments();

                    // Если комментарии есть, выводим их в таблице
                    if ($comments) {
                        foreach ($comments as $comment) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($comment['CommentId']) . "</td>";
                             echo "<td>" . htmlspecialchars($comment['ProductName']) . "</td>";
                            echo "<td>" . htmlspecialchars($comment['FIO']) . "</td>";
                            echo "<td>" . htmlspecialchars($comment['CommentText']) . "</td>";
                            echo "<td>" . htmlspecialchars($comment['CommentDate']) . "</td>";
                            echo "<td>";
                            echo "<a href='delete_comment.php?id=" . htmlspecialchars($comment['CommentId']) . "' class='btn btn-sm btn-danger'>Удалить</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        // Выводим сообщение, если нет комментариев
                        echo "<tr><td colspan='6'>Нет комментариев</td></tr>";
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