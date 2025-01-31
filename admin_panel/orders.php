<?php
require_once 'admin_functions.php';

// Проверяем, авторизован ли пользователь и является ли он администратором
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

 // Функция для перевода статусов
function translateStatus($status) {
  switch ($status) {
      case 'Pending':   return 'Ожидает';
      case 'Shipped':   return 'Отправлен';
      case 'Delivered': return 'Доставлен';
      case 'Canceled':  return 'Отменен';
      default:            return $status;
  }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление заказами</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'include/admin_header.php';?>
    <div class="container-fluid">
        <div class="row">
           <?php include 'include/admin_sidebar.php';?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Управление заказами</h2>
                  <?php
                    if (isset($_GET['delete']) && $_GET['delete'] == 'success') {
                         echo "<div class='alert alert-success' role='alert'>Заказ успешно удален!</div>";
                    }
                    if (isset($_GET['edit']) && $_GET['edit'] == 'success') {
                      echo "<div class='alert alert-success' role='alert'>Статус заказа успешно обновлен!</div>";
                    }
                   ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Дата</th>
                            <th>Сумма</th>
                            <th>Метод оплаты</th>
                            <th>Номер телефона</th>
                            <th>Статус</th>
                            <th>Продукты</th>
                            <th>ФИО</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $orders = getAllOrders();
                         if($orders){
                            foreach ($orders as $order) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($order['order_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($order['order_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($order['total_amount']) . "</td>";
                                echo "<td>" . htmlspecialchars($order['payment_method']) . "</td>";
                                echo "<td>" . htmlspecialchars($order['ContactNumber']) . "</td>";
                                echo "<td>" . htmlspecialchars(translateStatus($order['status'])) . "</td>";
                                echo "<td>" . htmlspecialchars($order['product_names']) . "</td>";
                                echo "<td>" . htmlspecialchars($order['FIO']) . "</td>";
                                echo "<td>";
                                echo "<a href='edit_order.php?id=" . htmlspecialchars($order['order_id']) . "' class='btn btn-sm btn-secondary'>Редактировать</a> ";
                                echo "<a href='delete_order.php?id=" . htmlspecialchars($order['order_id']) . "' class='btn btn-sm btn-danger'>Удалить</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                         } else {
                            echo "<tr><td colspan='9'>Нет заказов</td></tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </main>
        </div>
    </div>
    <?php include 'include/admin_footer.php';?>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>