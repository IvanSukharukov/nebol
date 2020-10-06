<?php
defined("CATALOG") or die("Access denied");
include 'mainController.php';
include "models/{$view}Model.php";

/*====================Пагинация=====================*/

            //Количество товаров на странице
            //$perpage = 10;
            $perpage = (int)$_COOKIE['per_page'] ? $_COOKIE['per_page'] : PERPAGE;

            //Общее количество товаров
            $count_goods = countGoods();

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

$arr_product = getProducts($start_pos, PERPAGE);




include "views/{$view}View.php";