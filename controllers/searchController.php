<?php
defined("CATALOG") or die("Access denied");

include 'mainController.php';
include "models/{$view}Model.php";



if(isset($_GET['term'])){
    $result_search = search_autocomplete();
    exit(json_encode($result_search));
}elseif(isset($_GET['search']) && $_GET['search']){

    /*====================Пагинация=====================*/
    //Количество товаров на странице
    //$perpage = 10;
      //  $perpage = PERPAGE;

    //Общее количество товаров
        $count_goods = countSearch();

    //необходимое количество страниц для отображения
        $count_pages = ceil($count_goods / PERPAGE);

    //минимум 1 страница
        if(!$count_pages) $count_pages = 1;

    //получение текущей страницы
        if(isset($_GET['page'])){
            $page = (int)$_GET['page'];
            if($page < 1) $page = 1;
        } else {
            $page = 1;
        }

    //если запрошенная страница больше максимума
        if ($page > $count_pages) $page = $count_pages;

    //начальная позиция для запроса в БД
        $start_pos = ($page - 1) * PERPAGE;

        $pagination = pagination($page, $count_pages);
    /*====================Пагинация=====================*/
    $result_search = search($start_pos, PERPAGE);
}else{
    $result_search = 'Повторите поисковой запрос';
}


/*if( !isset($page_alias) ) $page_alias = 'index'; // назначаем главную страницу
$page = get_one_page($page_alias);//alias присваивается в регулярном выражении в import.php*/

/*if( !$page ){
    include 'views/404View.php';
    exit;
}*/

include_once "views/{$view}View.php";