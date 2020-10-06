<!DOCTYPE html>
<html>

<head>
    <!-- Адаптивность -->
    <!-- <meta name="viewport" content="width=device-width"> -->
    <!-- Запретить увеличение на моб.устройствах -->
    <!-- <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, user-scalable=0"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Краткое описание страницы, не более 140 символов  -->
    <meta name="description" content=" ">

    <!-- Ключевые слова страницы, не более 20ти слов. Ключевые фразы разделяем запятой  -->
    <meta name="keywords" content=" ">

    <!-- Управление доступом поисковых роботов к странице -->
    <!-- <meta name="robots" content="none"> -->

    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?= PATH ?>favicon.ico" type="image/x-icon">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= PATH ?>views/css/stepper.css">
    <link rel="stylesheet" href="<?= PATH ?>views/cupertino/jquery-ui-1.10.4.custom.css">
    <link rel="stylesheet" type="text/css" href="<?= PATH ?>views/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="<?= PATH ?>views/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="<?= PATH ?>views/css/style.css">

</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header__row">
                <div class="header__body">
                    <a href="<?= PATH ?>" class="header__logo">
                        <img src="<?= PATH ?>views/img/logo.png" alt="">
                    </a>
                    <div class="header__burger">
                        <span></span>
                    </div>
                    <!-- Кнопка для мобильной навигации -->
                    <div id="menu-togle" class="menu-icon">
                        <div class="menu-icon-line"></div>
                    </div>

                    <form action="<?= PATH ?>search/" method="get">
                        <div class="search">

                            <input type="text" id="autocomplete_header" class="search-text" name="search" placeholder="поиск..." />

                            <button type="submit" class="search-go" name="go-search" value=""><img src="<?= PATH ?>views/img/search.png"></button>

                        </div>
                    </form>

                    <div class="address">
                        Санкт-Петербург,
                        пр. Просвещения,
                        дом 20/25
                    </div>
                    <div class="phone"><a href="tel:+78122421872">+7 (812) 242-18-72</a></div>

                    <div class="header_cart">
                        <?php //if(isset($_SESSION['total_quantity']))://если скрывать пустую корзину
                        ?>
                        <?php if ($_SESSION['total_quantity'] > 0) : ?>
                            <div class="header_cart__icon">
                                <a href="<?= PATH ?>cart/"><img src="<?= PATH ?>views/img/buy64.png"></a>
                            </div>
                            <div class="header_cart__count">
                                <?= $_SESSION['total_quantity'] ?>
                            </div>
                        <?php else : ?>
                            <div class="header_cart__icon">
                                <a href="<?= PATH ?>cart/"><img src="<?= PATH ?>views/img/buy64.png"></a>
                            </div>
                            <div class="header_cart__count_zero">
                                0
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
                <nav class="header__menu">
                    <div class="header__list topmenu">
                        <li>
                            <a class="nav__link down" href="<?= PATH ?>page/company/">Компания</a>
                            <ul class="submenu">
                                <li><a href="<?= PATH ?>page/company/">О компании</a></li>
                                <li><a href="<?= PATH ?>page/partners/">Партнеры</a></li>
                                <li><a href="<?= PATH ?>page/vacancy/">Вакансии</a></li>
                                <li><a href="<?= PATH ?>page/requisites/">Реквизиты</a></li>
                            </ul>
                        </li>
                        <li>
                            <a class="nav__link" href="<?= PATH ?>page/sales/">Акции</a>
                        </li>
                        <li>
                            <a class="nav__link" href="<?= PATH ?>catalog/">Поиск лекарств</a>
                        </li>
                        <li>
                            <a class="nav__link" href="<?= PATH ?>page/licenses/">Лицензии</a>
                        </li>
                        <li>
                            <a class="nav__link" href="<?= PATH ?>page/contacts/">Контакты</a>
                        </li>
                    </div>

                    <!-- Мобильная навигация -->
                    <div id="mobile-nav" class="mobile-nav">
                        <ul class="mobile-nav__list">
                            <li class="mobile-nav__item"><a href="<?= PATH ?>page/company/" class="mobile-nav__link">Компания</a></li>
                            <li class="mobile-nav__item"><a href="<?= PATH ?>page/sales/" class="mobile-nav__link">Акции</a></li>
                            <li class="mobile-nav__item"><a href="<?= PATH ?>catalog/" class="mobile-nav__link">Поиск лекарств</a></li>
                            <li class="mobile-nav__item"><a href="<?= PATH ?>page/licenses/" class="mobile-nav__link">Лицензии</a></li>
                            <li class="mobile-nav__item"><a href="<?= PATH ?>page/contacts/" class="mobile-nav__link">Контакты</a></li>
                        </ul>
                        <div class="address-mobile">
                            Санкт-Петербург,
                            пр. Просвещения,
                            дом 20/25
                        </div>
                        <div class="phone-mobile"><a href="tel:+78122421872">+7 (812) 242-18-72</a></div>
                    </div>
                </nav>
            </div>
        </div>
    </header>