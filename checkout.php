<?php
session_start();

require_once 'include/header.php';

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['FIO'])) {
    // Если не авторизован, перенаправляем на главную страницу с сообщением об ошибке
    ?>
        <p class="text-center">Вы не авторизовались. Чтобы перейти к оплате <a href="#" data-bs-toggle="modal" data-bs-target="#logModal">авторизуйтесь!</a></p>
    <?php
    header("Location: index.php");
    exit();
}

// Если пользователь авторизован, то отображаем страницу оформления заказа
?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Оформление заказа</h2>

        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4 class="card-title">Товары в вашем заказе</h4>
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
                                    foreach ($_SESSION['cart'] as $productId => $item) {
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $totalPrice += $itemTotal;
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($item['name']) . '</td>';
                                        echo '<td>' . htmlspecialchars(number_format($item['price'], 2)) . ' руб.</td>';
                                        echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                                        echo '<td>' . htmlspecialchars(number_format($itemTotal, 2)) . ' руб.</td>';
                                        echo '</tr>';
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
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Контактная информация</h4>
                             <form method="POST" action="process_order.php" id="checkoutForm">
                                <div class="mb-3">
                                    <label for="userName" class="form-label">ФИО:</label>
                                    <input type="text" class="form-control" id="userName" name="userName" value="<?php echo htmlspecialchars($_SESSION['FIO']) ?>" required>
                                </div>
                                <div class="mb-3">
                                  <label for="userEmail" class="form-label">Email:</label>
                                  <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($_SESSION['Email']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="userPhone" class="form-label">Контактный:</label>
                                    <input type="text" class="form-control" id="userPhone" name="userPhone" required>
                                </div>
                                 <div class="mb-3">
                                 <label for="notes" class="form-label">Примечание:</label>
                                 <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                                 <div class="mb-3">
                                    <label for="payment_method" class="form-label">Метод оплаты:</label>
                                    <select class="form-control" id="payment_method" name="payment_method" >
                                        <option value="upon_receipt">При получении</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Подтвердить заказ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center">Ваша корзина пуста. <a href="index.php">Продолжить покупки</a></p>
        <?php endif; ?>
    </div>
<?php require_once 'include/footer.php'; ?>