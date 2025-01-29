<?php
session_start();

//Подключаем header.php и product.php
require_once 'include/header.php';
require_once 'include/functions.php';
require_once 'include/db_connect.php';

// Получаем ID товара из POST-параметра, если форма отправлена
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];
   
    $product = null;
    foreach(getProducts() as $p){
        if($p['ProductId'] == $productId){
            $product = $p;
             break;
        }
    }

   if($product != null){
        if (!isset($_SESSION['cart'])) {
             $_SESSION['cart'] = [];
        }
        if(isset($_SESSION['cart'][$productId]))
        {
             $_SESSION['cart'][$productId]['quantity'] += 1;
        }
        else {
             $_SESSION['cart'][$productId] = [
                'name' => $product['ProductName'],
                'price' => $product['Price'],
                'quantity' => 1
            ];
        }

      }
}


?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Корзина</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Название товара</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Сумма</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $totalPrice = 0;
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
            foreach ($_SESSION['cart'] as $productId => $item) {
                $itemTotal = $item['price'] * $item['quantity'];
                $totalPrice += $itemTotal;
                echo '<tr>';
                echo '<td>' . htmlspecialchars($item['name']) . '</td>';
                echo '<td>' . htmlspecialchars(number_format($item['price'], 2)) . ' руб.</td>';
                echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                echo '<td>' . htmlspecialchars(number_format($itemTotal, 2)) . ' руб.</td>';
                echo '<td>
                        <form method="POST" action="update_cart.php" class="d-inline">
                            <input type="hidden" name="product_id" value="' . htmlspecialchars($productId) . '">
                            <button type="submit" name="action" value="decrease" class="btn btn-sm btn-warning">-</button>
                            <button type="submit" name="action" value="increase" class="btn btn-sm btn-success">+</button>
                        </form>
                        <form method="POST" action="update_cart.php" class="d-inline">
                            <input type="hidden" name="product_id" value="' . htmlspecialchars($productId) . '">
                            <button type="submit" name="action" value="remove" class="btn btn-sm btn-danger">Удалить</button>
                        </form>
                     </td>';
                echo '</tr>';
            }
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="3" class="text-right">Итого:</th>
            <th colspan="2"><?= htmlspecialchars(number_format($totalPrice, 2)) ?> руб.</th>
        </tr>
        </tfoot>
    </table>
    <div class="text-center">
        <a href="checkout.php" class="btn btn-primary">Перейти к оформлению</a>
        <a href="index.php" class="btn btn-secondary">Продолжить покупки</a>
    </div>
</div>
<?php require_once 'include/footer.php'; $conn->close() ?>