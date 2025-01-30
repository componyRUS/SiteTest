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
$userAddress = isset($_POST['userAddress']) ? htmlspecialchars($_POST['userAddress']) : "";


// Получаем товары из корзины
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Добавление записей в таблицу Transactions
foreach ($cart as $productId => $item) {
    $sql = "INSERT INTO Transactions (ProductId) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);

      if ($stmt->execute() === false) {
        error_log("Ошибка при добавлении транзакции: " . $stmt->error);
        echo "Ошибка при оформлении заказа. Пожалуйста, попробуйте позже";
        exit;
       }
      $stmt->close();
}


// Выводим сообщение об успехе
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
// Очищаем корзину
unset($_SESSION['cart']);
require_once 'include/footer.php';
$conn->close();
?>