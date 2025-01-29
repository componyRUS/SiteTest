<?php
session_start();
require_once 'include/header.php';
require_once 'include/functions.php';
require_once 'include/db_connect.php';

// Получаем ID товара из GET-параметра
$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Получаем ID товара из POST-параметра, если форма отправлена (для добавления в корзину)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $productIdPost = (int)$_POST['product_id'];

    $product = null;
    foreach (getProducts() as $p) {
        if ($p['ProductId'] == $productIdPost) {
            $product = $p;
            break;
        }
    }

    if ($product != null) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$productIdPost])) {
            $_SESSION['cart'][$productIdPost]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$productIdPost] = [
                'name' => $product['ProductName'],
                'price' => $product['Price'],
                'quantity' => 1
            ];
        }
    }
}

// Обработка отправки комментария
$commentAdded = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_text']) && isset($_SESSION['userid'])) {
    $commentText = htmlspecialchars($_POST['comment_text']);
    $userId = $_SESSION['userid']; // Используем userid из сессии

    if (!empty($commentText)) {
        $sql = "INSERT INTO ProductComments (ProductId, UserId, CommentText, CommentDate) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $productId, $userId, $commentText);

        if ($stmt->execute()) {
            $commentAdded = true;
        } else {
            echo "Ошибка при добавлении комментария: " . $stmt->error;
        }
        $stmt->close();
    }
}

if ($productId <= 0) {
    echo '<div class="container"><p class="text-center">Неверный ID товара.</p></div>';
} else {
    $product = null;
    foreach (getProducts() as $p) {
        if ($p['ProductId'] == $productId) {
            $product = $p;
            break;
        }
    }

    if ($product == null) {
        echo '<div class="container"><p class="text-center">Товар не найден.</p></div>';
    } else {
        $categoryName = getCategoryName($product['CategoryId']);
?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="" class="img-fluid"
                        alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                </div>
                <div class="col-md-6">
                    <h2><?php echo htmlspecialchars($product['ProductName']); ?></h2>
                    <p class="text-muted">Категория: <?php echo htmlspecialchars($categoryName); ?></p>
                    <p><strong>Цена:</strong> <?php echo htmlspecialchars(number_format($product['Price'], 2)); ?> руб.</p>
                    <p><strong>Описание:</strong> <?php echo htmlspecialchars($product['Description']); ?></p>
                    <form method="POST" class="add-to-cart">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['ProductId']); ?>">
                        <button type="submit" class="btn btn-primary">Купить</button>
                    </form>
                </div>
            </div>
            <div class="mt-4">
                <h3>Комментарии</h3>
                <?php if ($commentAdded) : ?>
                    <p class="text-center">Комментарий успешно добавлен</p>
                <?php endif; ?>
                <?php
                // Вывод существующих комментариев
                $sql = "SELECT ProductComments.CommentId, users.FIO, ProductComments.CommentText, ProductComments.CommentDate
                        FROM ProductComments
                        INNER JOIN users ON ProductComments.UserId = users.UserId
                        WHERE ProductId = ?
                        ORDER BY CommentDate DESC";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $productId);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="card mb-3">';
                        echo '<div class="card-body">';
                        echo '<h6 class="card-title">' . htmlspecialchars($row['FIO']) . ' <span class="text-muted small"> ' . htmlspecialchars($row['CommentDate']) . '</span></h6>';
                        echo '<p class="card-text">' . htmlspecialchars($row['CommentText']) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Нет комментариев.</p>';
                }

                $stmt->close();
                ?>

                <?php if (isset($_SESSION['userid'])) : ?>
                    <!-- Форма для добавления комментария -->
                    <form method="POST" action="product.php?id=<?php echo htmlspecialchars($productId); ?>">
                        <div class="mb-3">
                            <label for="comment_text" class="form-label">Оставить комментарий:</label>
                            <textarea class="form-control" id="comment_text" name="comment_text" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                <?php else : ?>
                    <p>Чтобы оставить комментарий, пожалуйста, <a href="#" data-bs-toggle="modal" data-bs-target="#logModal">войдите</a> или <a href="#" data-bs-toggle="modal" data-bs-target="#regModal">зарегистрируйтесь</a>.</p>
                <?php endif; ?>
            </div>
        </div>
<?php
    }
}

require_once 'include/footer.php';
$conn->close();
?>