<?php
require_once 'include/functions.php';
require_once 'include/header.php';


$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$categoryFilter = isset($_GET['category']) ? (int)$_GET['category'] : 0;

?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Результаты поиска</h2>
    <?php if (!empty($search) || $categoryFilter > 0): ?>
         <?php if (!empty($search)) : ?>
            <p class="text-center">Вы искали: <?php echo htmlspecialchars($search); ?></p>
          <?php endif; ?>
          <?php if($categoryFilter > 0 && empty($search)) : ?>
             <p class="text-center">Товары категории: <?php echo htmlspecialchars(getCategoryName($categoryFilter)); ?></p>
           <?php endif; ?>
        <!-- Фильтры и сортировка -->
        <div class="mb-3 d-flex align-items-center">
           <div class="me-2">
            <label for="sort" class="form-label">Сортировать по:</label>
             <select class="form-select" id="sort" name="sort">
                   <option value="">Без сортировки</option>
                 <option value="price_asc" <?php if ($sort == 'price_asc') echo 'selected'; ?>>По цене (возрастание)</option>
                    <option value="price_desc" <?php if ($sort == 'price_desc') echo 'selected'; ?>>По цене (убывание)</option>
                  <option value="name_asc" <?php if ($sort == 'name_asc') echo 'selected'; ?>>По имени (А-Я)</option>
                   <option value="name_desc" <?php if ($sort == 'name_desc') echo 'selected'; ?>>По имени (Я-А)</option>
            </select>
            </div>
             <div class="me-2">
               <label for="category" class="form-label">Фильтр по категории:</label>
                <select class="form-select" id="category" name="category">
                     <option value="">Все категории</option>
                     <?php
                     foreach(getCategories() as $category){
                      echo '<option value="' . htmlspecialchars($category['CategoryId']) . '"';
                     if($categoryFilter == $category['CategoryId']){
                         echo 'selected';
                      }
                       echo '>' . htmlspecialchars($category['CategoryName']) . '</option>';
                     }
                    ?>
                </select>
             </div>
             <button class="btn btn-primary" onclick="applyFilter()">Применить фильтр</button>
        </div>
        <div class="row" id="product-grid">
            <?php
            $products = getProducts($search, $sort, $categoryFilter);
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
                    echo '<h5 class="card-title text-center">' . htmlspecialchars($product['ProductName']) . '</h5>';
                    echo '<p class="card-text text-center">Цена: ' . htmlspecialchars($product['Price']) . ' руб.</p>';
                    echo '</div>'; ?>
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
    <?php else: ?>
         <div class="row" id="product-grid">
             <?php
             $products = getProducts();
             if (empty($products)) {
                 echo '<div class="col-12"><p class="text-center">Товары не найдены.</p></div>';
             } else {
                ?> <div class="mb-3 d-flex align-items-center">
                <div class="me-2">
                 <label for="sort" class="form-label">Сортировать по:</label>
                  <select class="form-select" id="sort" name="sort">
                        <option value="">Без сортировки</option>
                      <option value="price_asc" <?php if ($sort == 'price_asc') echo 'selected'; ?>>По цене (возрастание)</option>
                         <option value="price_desc" <?php if ($sort == 'price_desc') echo 'selected'; ?>>По цене (убывание)</option>
                       <option value="name_asc" <?php if ($sort == 'name_asc') echo 'selected'; ?>>По имени (А-Я)</option>
                        <option value="name_desc" <?php if ($sort == 'name_desc') echo 'selected'; ?>>По имени (Я-А)</option>
                 </select>
                 </div>
                  <div class="me-2">
                    <label for="category" class="form-label">Фильтр по категории:</label>
                     <select class="form-select" id="category" name="category">
                          <option value="">Все категории</option>
                          <?php
                          foreach(getCategories() as $category){
                           echo '<option value="' . htmlspecialchars($category['CategoryId']) . '"';
                          if($categoryFilter == $category['CategoryId']){
                              echo 'selected';
                           }
                            echo '>' . htmlspecialchars($category['CategoryName']) . '</option>';
                          }
                         ?>
                     </select>
                  </div>
                  <button class="btn btn-primary" onclick="applyFilter()">Применить фильтр</button>
             </div>
             <div class="row" id="product-grid"><?php
                 foreach ($products as $product) {
                     $categoryName = getCategoryName($product['CategoryId']);
                     echo '<div class="col-md-4 mb-4 product-item" data-price="' . htmlspecialchars($product['Price']) . '">';
                     echo '<div class="card h-100">';
                     echo '<a href="product.php?id=' . htmlspecialchars($product['ProductId']) . '">';
                     echo '<img src="" class="card-img-top" alt="' . htmlspecialchars($product['ProductName']) . '" style="height: 200px; object-fit: cover;">';
                     echo '</a>';
                     echo '<div class="card-body">';
                     echo '<h5 class="card-title text-center">' . htmlspecialchars($product['ProductName']) . '</h5>';
                     echo '<p class="card-text text-center">Цена: ' . htmlspecialchars($product['Price']) . ' руб.</p>';
                     echo '</div>'; ?>
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
    <?php endif; ?>
</div>
 <script>
   function applyFilter() {
     const sort = document.getElementById('sort').value;
     const category = document.getElementById('category').value;
    const params = new URLSearchParams(window.location.search);
     params.set('sort', sort);
       params.set('category',category)
    window.location.href = 'search.php?' + params.toString();
  }
</script>
<?php
require_once 'include/footer.php';
?>