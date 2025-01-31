<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'include/db_connect.php';


// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['userid'])) {
    $_SESSION['login_err_msg'] = "Для просмотра списка заказов необходимо авторизоваться.";
    header("Location: index.php");
    exit();
}


require_once 'include/header.php';

// Функция для перевода статуса на русский
function translateStatus($status) {
    switch ($status) {
        case 'Pending':
            return 'В ожидании';
        case 'Shipped':
            return 'Отправлен';
        case 'Delivered':
            return 'Доставлен';
        case 'Canceled':
            return 'Отменен';
        default:
            return $status; // Возвращаем исходный статус, если нет перевода
    }
}

$userId = $_SESSION['userid'];

// Запрос на получение заказов текущего пользователя
$sql = "SELECT o.order_id, o.order_date, o.total_amount, o.payment_method, o.notes, o.status, o.ContactNumber,
            GROUP_CONCAT(CONCAT(oi.product_name, ' (', oi.quantity, ')') SEPARATOR ', ') AS product_names
        FROM orders o
        LEFT JOIN order_items oi ON o.order_id = oi.order_id
        WHERE o.user_id = ?
        GROUP BY o.order_id
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Список ваших заказов</h2>

    <?php if (!empty($orders)): ?>
        <table class="table">
                        <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['product_names']) ?></td>
                        <td><?= htmlspecialchars(number_format($order['total_amount'], 2)) ?> руб.</td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td><?= htmlspecialchars($order['ContactNumber']) ?></td>
                         <td>
                            <?php
                                 $paymentMethod = $order['payment_method'];
                                if($paymentMethod === 'upon_receipt'){
                                    echo 'При получении';
                                } else {
                                    echo htmlspecialchars($paymentMethod);
                                }
                                 ?>
                           </td>
                        <td><?= htmlspecialchars($order['notes']) ?></td>
                        <td><?= htmlspecialchars(translateStatus($order['status'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">У вас пока нет заказов.</p>
    <?php endif; ?>
</div>

<?php
require_once 'include/footer.php';
$conn->close();
?>