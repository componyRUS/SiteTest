<?php session_start();
$email = $login_err_msg = "";
if (isset($_SESSION['login_err_msg']) && ($_SESSION['login_err_msg'] != "")) {
    $login_err_msg = $_SESSION['login_err_msg'];
    $email = $_SESSION['email'];
    $_SESSION['login_err_msg'] = "";
    $_SESSION['email'] = "";
    $_SESSION['register_err_msg'] = "";
}
?>

<?php include_once 'include/header.php'?>
    <!-- баннер -->
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="uploads/img/600x400@2x.png" class="d-block w-100" alt="Slide 1">
            </div>
            <div class="carousel-item">
                <img src="uploads/img/600x400@2x.png" class="d-block w-100" alt="Slide 2">
            </div>
            <div class="carousel-item">
                <img src="uploads/img/600x400@2x.png" class="d-block w-100" alt="Slide 3">
            </div>
        </div>
    </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Предыдущий</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-script>
                <span class="visually-hidden">следующий</span>
        </button>
        <!-- Вывод товаров -->
        <div class="container mt-5">
        <h2 class="text-center mb-4">Наши товары</h2>
        <div class="row" id="product-grid">
            <?php
            require_once 'include/functions.php';
            $products = getProducts();
            if (empty($products)) {
                echo '<div class="col-12"><p class="text-center">Товары не найдены.</p></div>';
            } else {
                foreach ($products as $product) {
                    $categoryName = getCategoryName($product['CategoryId']);
                    echo '<div class="col-md-4 mb-4 product-item" data-price="' . htmlspecialchars($product['Price']) . '">';
                    echo '<div class="card h-100">';
                     echo '<a href="product.php?id=' . htmlspecialchars($product['ProductId']) . '">';
                    echo '<img src="" class="card-img-top" alt="' . htmlspecialchars($product['ProductName']) . '" style="height: 200px; object-fit: cover;">';
                     echo '</a>';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . htmlspecialchars($product['ProductName']) . '</h5>';
                    echo '<p class="card-text">Цена: ' . htmlspecialchars($product['Price']) . ' руб.</p>';
                    echo '</div>';?>
                    <form class="text-center" method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['ProductId']); ?>">
                    <button type="submit" class="btn btn-primary">Купить</button>
                     </form>
                     <?php
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>

<?php include_once 'include/footer.php'?>
        
