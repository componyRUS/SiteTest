<?php
session_start();
require_once 'include/db_connect.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['FIO'])) {
  $_SESSION['login_err_msg'] = "Для оформления заказа необходимо авторизоваться.";
  $_SESSION['email'] = "";
  header("Location: index.php");
    exit();
}

// Получаем данные из формы
$userName = isset($_POST['userName']) ? htmlspecialchars($_POST['userName']) : "";
$userEmail = isset($_POST['userEmail']) ? htmlspecialchars($_POST['userEmail']) : "";
$userPhone = isset($_POST['userPhone']) ? htmlspecialchars($_POST['userPhone']) : "";
$notes = isset($_POST['notes']) ? htmlspecialchars($_POST['notes']) : "";
$userId = $_SESSION['userid'] ?? null;

// Получаем товары из корзины
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$totalAmount = 0;
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $totalAmount += $item['price'] * $item['quantity'];
    }
} else {
    echo "Ошибка при подсчёте. Пожалуйста, попробуйте позже";
     exit();
}

// Добавление записей в таблицу orders
$sql_order = "INSERT INTO orders (user_id, total_amount, notes, ContactNumber) VALUES (?, ?, ?, ?)";
$stmt_order = $conn->prepare($sql_order);
$stmt_order->bind_param("idss", $userId, $totalAmount, $notes, $userPhone);
if ($stmt_order->execute() === false) {
    error_log("Ошибка при выполнении запроса INSERT INTO orders: " . $stmt_order->error);
    echo "Ошибка при оформлении заказа. Пожалуйста, попробуйте позже";
    exit();
}
// Получаем order_id
$orderId = $conn->insert_id;
    if(!$orderId){
        error_log("Ошибка: Не удалось получить id нового заказа");
            header("Location: index.php?error=order_fail");
        exit();
    }
$stmt_order->close();

// Добавление записей в таблицу order_items
foreach ($_SESSION['cart'] as $productId => $item) {
    $sql_items = "INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt_items = $conn->prepare($sql_items);

    if (!$stmt_items) {
        error_log("Ошибка подготовки запроса INSERT INTO order_items: " . $conn->error);
        echo "Ошибка при оформлении order_items";
        exit();
    }
    $stmt_items->bind_param("isid", $orderId, $item['name'], $item['quantity'], $item['price']);

    if (!$stmt_items->execute()) {
        error_log("Ошибка выполнения запроса INSERT INTO order_items: " . $stmt_items->error);
        echo "Ошибка при оформлении order_items 2";
        exit();
    }
 $stmt_items->close();
}


?>
<?php require_once 'include/header.php'; ?>
<div class="container mt-5">
  <div class="alert alert-success" role="alert">
    <h2>Спасибо за ваш заказ, <?php echo htmlspecialchars($userName) ?>!</h2>
      <p>Ваш заказ принят. Информация о заказе:</p>
      <table class="table">
        <thead>
          <tr>
            <th>Название товара</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
          </tr>
        </thead>
          <tbody>
        <?php
        $totalPrice = 0;
        if (isset($cart) && !empty($cart)) {
            foreach ($cart as $productId => $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $totalPrice += $itemTotal;
                echo '<tr>';
                echo '<td>' . htmlspecialchars($item['name']) . '</td>';
                echo '<td>' . htmlspecialchars(number_format($item['price'], 2)) . ' руб.</td>';
                echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                echo '<td>' . htmlspecialchars(number_format($itemTotal, 2)) . ' руб.</td>';
                echo '</tr>';
           }
        }
        ?>
        </tbody>
         <tfoot>
           <tr>
              <th colspan="3" class="text-right">Итого:</th>
              <th><?= htmlspecialchars(number_format($totalPrice, 2)) ?> руб.</th>
           </tr>
        </tfoot>
      </table>
       <p>В ближайшее время с вами свяжется наш менеджер для уточнения деталей.</p>
       <p>Адрес доставки: <?php echo htmlspecialchars($userAddress); ?></p>
       <a href="index.php" class="btn btn-primary">Вернуться на главную</a>
       </div>
</div>
<?php
// Очищение корзины
unset($_SESSION['cart']);
require_once 'include/footer.php';
$conn->close();
?>