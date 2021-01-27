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
            <?php if (empty($_GET['search'])) : ?>
                <div class="search_result">Поиск лекарств:</div>
            <?php else : ?>
                <div class="search_result">Результаты поиска по запросу: <span><?= $_GET['search'] ?></span></div>
            <?php endif; ?>
            <div class="search_form_catalog">
                <form action="<?= PATH ?>search/" method="get">
                    <div class="search_form_catalog_content">
                        <input type="text" id="autocomplete_catalog" class="search_text" name="search" placeholder="Для поиска можно ввести часть названия" />
                        <input type="submit" class="search-btn" name="go-search" value="поиск" />
                    </div>
                </form>
            </div>

            <?php if (is_array($result_search)) : ?>

                <?php foreach ($result_search as $product) : ?>
                    <?php //foreach ($product_group as $product) : 
                    ?>
                    <?php require 'product_form_list.php'; ?>
                    <?php //endforeach; 
                    ?>
                <?php endforeach; ?>

                <?php if ($count_pages > 1) : ?>
                    <div class="pagination"><?= $pagination; ?></div>
                <?php endif; ?>

            <?php else : ?>
                <div class="search_result no_result"><?= $result_search ?></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>