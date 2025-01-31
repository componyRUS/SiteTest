<!doctype html>
<html lang="ru_RU" onload="setTheme()" id="htmlPage" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Главная</title>
</head>

<body>
    <!-- верхнее нав -->
    <nav class="bg-body-secondary border-bottom">
        <div class="container d-flex flex-wrap">
            <ul class="nav me-auto">
                <li class="nav-item"><a href="index.php" class="nav-link link-body-emphasis px-2 active" aria-current="page">Главная</a></li>
                <li class="nav-item"><a href="about.php" class="nav-link link-body-emphasis px-2">О нас</a></li>
                <li class="nav-item"><a href="delivery.php" class="nav-link link-body-emphasis px-2">Доставка</a></li>
            </ul>
            <ul class="nav">
                <?php if (isset($_SESSION['FIO'])) {  ?>
                    <li class="nav-item"><a href="order_list.php" class="nav-link link-body-emphasis px-2">Заказы</a></li>
                    <li class="nav-item"><a href="profile.php" class="nav-link link-body-emphasis px-2">Добро пожаловать, <?php echo $_SESSION['FIO']; ?></a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link link-body-emphasis px-2">Выйти</a></li>
                <?php } else { ?>
                    <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2" data-bs-toggle="modal" data-bs-target="#logModal">Войти</a></li>
                    <li class="nav-item"><a href="#" class="nav-link link-body-emphasis px-2" data-bs-toggle="modal" data-bs-target="#regModal">Регистрация</a></li>
                <?php } ?>
            </ul>
            <div class="d-flex align-items-center justify-content-center">Смена темы:</div>
            <div class="form-check form-switch d-flex align-items-center justify-content-center">            
                <input class="form-check-input" type="checkbox" role="switch" id="theme-switcher" checked>
            </div>
        </div>
    </nav>
    <!-- окно авторизации -->
    <div class="modal fade" id="logModal" tabindex="-1" aria-labelledby="logModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logModalLabel">Авторизация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form class="form-1" id="loginForm" method="post">
                        <div class="mb-3">
                            <label for="LoginEmail" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="LoginEmail" aria-describedby="emailHelp" name="email" placeholder="Введите Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="LoginPassword" class="form-label">Пароль:</label>
                            <input type="password" class="form-control" id="LoginPassword" name="password" placeholder="Введите Пароль" required>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit" name="submit">Войти</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- окно рег -->
    <div class="modal fade" id="regModal" tabindex="-1" aria-labelledby="regModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="regModalLabel">Регистрация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <!-- Форма регистрации -->
                    <form class="form-1" id="registerForm" method="post">
                        <div class="mb-3">
                            <label for="registerFullName" class="form-label">ФИО:</label>
                            <input type="text" class="form-control" id="registerFullName" name="registerFullName">
                        </div>
                        <div class="mb-3">
                            <label for="registerEmail" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="registerEmail" aria-describedby="emailHelp" name="registerEmail">
                        </div>
                        <div class="mb-3">
                            <label for="registerPassword" class="form-label">Пароль:</label>
                            <input type="password" class="form-control" id="registerPassword" name="registerPassword">
                        </div>
                        <div class="mb-3">
                            <label for="registerConfirmPassword" class="form-label">Повторите пароль:</label>
                            <input type="password" class="form-control" id="registerConfirmPassword" name="registerConfirmPassword">
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit" name="submit">Зарегистрироваться</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- лого назв поиск -->
    <header class="py-3 border-bottom">
        <div class="container d-flex flex-wrap justify-content-center align-items-center">
            <a href="index.php"
                class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="32" fill="currentColor" class="bi bi-shop"
                    viewBox="0 0 16 16">
                    <path
                        d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.37 2.37 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0M1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5M4 15h3v-5H4zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1zm3 0h-2v3h2z" />
                </svg>
                <div>
                    <span class="fs-4 "> Плюшевый</span>
                    <span class="fs-6"> - Интернет-магазин детских игрушек</span>
                </div>
            </a>
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-3" role="search" action="search.php" method="GET">
                <input type="search" class="form-control" placeholder="Поиск товара..." aria-label="Search" name="search">
            </form>
            <!-- Корзина -->
            <a href="cart.php" class="nav-link link-body-emphasis px-2 position-relative">
                  <i class="bi bi-cart"></i>
                 <?php
                    $cartCount = 0;
                  if (isset($_SESSION['cart'])) {
                      foreach ($_SESSION['cart'] as $item) {
                         $cartCount += $item['quantity'];
                    }
                 }

                   if ($cartCount > 0) : ?>
                       <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                           <?php echo $cartCount; ?>
                           <span class="visually-hidden">товаров в корзине</span>
                         </span>
                   <?php endif; ?>
                </a>
        </div>
    </header>
    <!-- нижний нав -->
    <nav class="py-2 border-bottom bg-body-tertiary">
        <div class="container d-flex flex-wrap justify-content-left">
            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php" class="nav-link px-2 link-dark">Все товары</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link px-2 link-dark dropdown-toggle" href="#" id="categoriesDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Категории
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                         <?php
                          require_once 'include/functions.php';
                            foreach(getCategories() as $category){
                              echo '<li><a class="dropdown-item" href="search.php?category=' . htmlspecialchars($category['CategoryId']) . '">' . htmlspecialchars($category['CategoryName']) . '</a></li>';
                           }
                         ?>
                     </ul>
                </li>
            </ul>
        </div>
    </nav>
<!-- смена темы скрипт -->
<script>
            const checkbox = document.getElementById('theme-switcher');
            const html = document.getElementById("htmlPage");

            function setTheme(theme) {
                html.setAttribute("data-bs-theme", theme);
                if (theme === "light") {
                    checkbox.checked = true;
                } else {
                    checkbox.checked = false;
                }
                localStorage.setItem('theme', theme);
            }


            const savedTheme = localStorage.getItem('theme');

            if (savedTheme) {
                setTheme(savedTheme);
            }

            checkbox.addEventListener('change', function() {
                if (checkbox.checked) {
                    setTheme("light");
                } else {
                    setTheme("dark");
                }
            });

            const loginForm = document.getElementById('loginForm');
            loginForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(loginForm);
                fetch('login.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data.includes("успешно")) {
                            const modal = loginForm.closest('.modal');
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            bsModal.hide();
                            window.location.href = 'index.php';
                        } else {
                            const modalBody = loginForm.closest('.modal-body');
                            modalBody.innerHTML = `<p class="err-msg">${data}</p>` + modalBody.innerHTML;
                        }
                    });
            });

            const registerForm = document.getElementById('registerForm');
            registerForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(registerForm);
                fetch('register.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data.includes("успешно")) {
                            const modal = registerForm.closest('.modal');
                            const bsModal = bootstrap.Modal.getInstance(modal);
                            bsModal.hide();
                            window.location.href = 'index.php';
                        } else {
                            const modalBody = registerForm.closest('.modal-body');
                            modalBody.innerHTML = `<p class="err-msg">${data}</p>` + modalBody.innerHTML;
                        }
                    });
            });
        </script>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sortButtons = document.querySelectorAll('.sort-button');
        const productGrid = document.getElementById('product-grid');
        const productItems = document.querySelectorAll('.product-item');

        sortButtons.forEach(button => {
            button.addEventListener('click', function() {
                const sortType = this.dataset.sort;
                const sortedItems = [...productItems].sort((a, b) => {
                    const priceA = parseFloat(a.dataset.price);
                    const priceB = parseFloat(b.dataset.price);
                    if (sortType === 'price-asc') {
                        return priceA - priceB;
                    } else {
                        return priceB - priceA;
                    }
                });
                productGrid.innerHTML = '';
                sortedItems.forEach(item => productGrid.appendChild(item));
            });
        });
    });
</script>