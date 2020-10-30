<?php require_once 'header.php'; ?>

<div class="not404">Что-то пошло не так, повторите действие.<br>Если Вы искали препарат - воспользуйтесь формой поиска.</div>

<div class="search_form_catalog search404">
    <form action="<?= PATH ?>search/" method="get">
        <div class="search_form_catalog_content">
            <input type="text" id="autocomplete_catalog" class="search_text" name="search" placeholder="Для поиска можно ввести часть названия" />
            <input type="submit" class="search-btn" name="go-search" value="поиск" />
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>