<?php
require_once 'admin_functions.php';

// Проверяем, авторизован ли пользователь и является ли он администратором
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$order = getOrderById($orderId);

if (!$order) {
    echo "Заказ не найден.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать заказ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'include/admin_header.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <?php include 'include/admin_sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <h2>Редактировать заказ</h2>
                <form method="post" action="edit_order_handler.php?id=<?= $orderId ?>">
                    <div class="mb-3">
                        <label for="status" class="form-label">Статус</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Pending" <?= ($order['status'] == 'Pending') ? 'selected' : '' ?>>Ожидает</option>
                            <option value="Shipped" <?= ($order['status'] == 'Shipped') ? 'selected' : '' ?>>Отправлен</option>
                            <option value="Delivered" <?= ($order['status'] == 'Delivered') ? 'selected' : '' ?>>Доставлен</option>
                            <option value="Canceled" <?= ($order['status'] == 'Canceled') ? 'selected' : '' ?>>Отменен</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID заказа:</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order['order_id']) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Номер телефона:</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order['ContactNumber']) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Дата:</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order['order_date']) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Сумма:</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order['total_amount']) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Метод оплаты:</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order['payment_method']) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Автор:</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order['FIO']) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Заметки:</label>
                        <textarea class="form-control" readonly><?= htmlspecialchars($order['notes']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </main>
        </div>
    </div>
    <?php include 'include/admin_footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>