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

    <meta name="mailru-verification" content="62574aefae115c70" />
    <meta charset="utf-8">
    <link rel="shortcut icon" href="<?= PATH ?>favicon.ico" type="image/x-icon">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="<?= PATH ?>views/css/stepper.css">
    <link rel="stylesheet" href="<?= PATH ?>views/cupertino/jquery-ui-1.10.4.custom.css">
    <link rel="stylesheet" type="text/css" href="<?= PATH ?>views/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="<?= PATH ?>views/slick/slick-theme.css" />
    <link rel="stylesheet" type="text/css" href="<?= PATH ?>views/css/style_v2_4.css">

    <title>Аптека Неболейка</title>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(49344637, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/49344637" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

</head>

<body>
    <div class="hot-demand" id="blink">
        В период повышенного спроса на лекарственные препараты, уточняйте наличие препаратов по телефону.
    </div>
    <header class="header">
        <div class="container">
            <div class="header__row">
                <div class="header__body">
                    <a href="<?= PATH ?>" class="header__logo">
                        <img src="<?= PATH ?>views/img/logo_ng.png" alt="">
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

                    <!-- <div class="address<?php //if (!empty($_SESSION['cart'])) echo ' address-select-hide'; 
                                            ?>">
                        <select name="branch" id="branch">
                            <option <?php //if ($branch == 1) echo "selected"; 
                                    ?> value="1">Аптека не выбрана</option>
                            <option <?php //if ($branch == 9117) echo "selected"; 
                                    ?> value="9117, 15837">Просвещения</option>
                            <option <?php //if ($branch == 11263) echo "selected"; 
                                    ?> value="11263">Композиторов</option>
                            <option <?php //if ($branch == 9758) echo "selected"; 
                                    ?> value="9758">Луначарского</option>
                        </select>
                    </div> -->


                    <div class="address<?php if (!empty($_SESSION['cart'])) echo ' address-select-hide'; ?>">
                        <div class="apteka_zakaz">Аптека для заказа:</div>
                        <div class="select" id="standard-select">
                            <select name="branch" id="branch">
                                <option <?php if ($branch == 1) echo "selected"; ?> value="1">Аптека не выбрана</option>

                                <?php foreach (not_mark_branches($branches) as $branch_option) : ?>
                                    <option <?php if ($branch == $branch_option['branch_main_id']) echo "selected"; ?> value="<?= $branch_option['branch_main_id'] ?>"><?= $branch_option['address'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="focus"></span>
                        </div>
                        <?php if ($branch !== 1) : ?>
                            <div><b><?= $branches[array_search($branch, array_column($branches, 'branchId'))]['phone'] ?></b></div>
                        <?php endif; ?>
                    </div>

                    <div>
                        <div class="address-current<?php if (!empty($_SESSION['cart'])) echo ' address-current-view'; ?>" data-title="Чтобы сменить аптеку очистите корзину">
                            <span>Аптека для заказа:</span><br> <?= $branches[array_search($branch, array_column($branches, 'branchId'))]['address'] ?>
                            <div><b><?= $branches[array_search($branch, array_column($branches, 'branchId'))]['phone'] ?></b></div>
                        </div>
                    </div>


                    <div class="phone">
                        <div class="sprav"><span>Справочная:</span></div>
                        <a href="tel:+78122421872">+7 (812) 242-18-72</a>
                    </div>

                    <div class="header_cart">
                        <?php //if(isset($_SESSION['total_quantity']))://если скрывать пустую корзину
                        ?>
                        <?php if ($_SESSION['total_quantity'] > 0) : ?>
                            <div class="header_cart__icon">
                                <a href="<?= PATH ?>cart/"><img src="<?= PATH ?>views/img/buy64.png"></a>
                            </div>
                            <div class="header_cart__count">
                                <a href="<?= PATH ?>cart/"><?= $_SESSION['total_quantity'] ?></a>
                            </div>
                        <?php else : ?>
                            <div class="header_cart__icon">
                                <a href="<?= PATH ?>cart/"><img src="<?= PATH ?>views/img/buy64.png"></a>
                            </div>
                            <div class="header_cart__count_zero">
                                <a href="<?= PATH ?>cart/">0</a>
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