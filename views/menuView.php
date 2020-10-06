<?php defined("CATALOG") or die("Access denied"); ?>
<ul class="menu">
    <?php foreach ($pages as $link => $item_page) : ?>
        <?php if ($item_page == 'Главная') : ?>
            <li><a href="<?= PATH ?>"><?= $item_page ?></a></li>
        <?php elseif ($item_page == 'Каталог') : ?>
            <li><a href="<?= PATH ?>catalog/">Каталог</a></li>
        <?php else : ?>
            <li><a href="<?= PATH . 'page/' . $link; ?>"><?= $item_page ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>