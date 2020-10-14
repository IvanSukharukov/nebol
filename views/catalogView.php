<?php require_once 'header.php'; ?>

<div class="container">
    <div class="page_title">
        <h1>Товары</h1>
    </div>
    <div class="catalog">
        <div class="sidebar">
            <div class="sidebar__img">
                <img src="../views/img/card_nebol_1.png" alt="Аптека Неболейка" title="Аптека Неболейка">
            </div>
            <div class="sidebar__text">
                Цель нашей компании — предложение широкого ассортимента товаров и услуг на постоянно высоком качестве обслуживания.
            </div>
        </div>

        <div class="content_catalog">

            <div class="search_form_catalog">
                <form action="<?= PATH ?>search/" method="get">
                    <div class="search_form_catalog_content">
                        <input type="text" id="autocomplete_catalog" class="search_text" name="search" placeholder="Для поиска можно ввести часть названия" />
                        <input type="submit" class="search-btn" name="go-search" value="поиск" />
                    </div>
                </form>
            </div>

            <?php if ($arr_product) : ?>
                <?php foreach ($arr_product as $product) : ?>

                    <?php require 'product_form_list.php'; ?>

                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($count_pages > 1) : ?>
                <div class="pagination"><?= $pagination; ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>




<?php require_once 'footer.php'; ?>