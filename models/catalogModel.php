<?php
defined("CATALOG") or die("Access denied");

/**
 * Модель для таблицы товаров, получить товары
 * @param $start_pos int стартовая позиция для запроса
 * @param $perpage int сколько товаров на странице
 * @return array
 */
function getProducts($start_pos, $perpage){
    $query = "SELECT * FROM ostbydate LIMIT $start_pos, $perpage";//возможно стоит получать только нужное, для соритровки ORDER BY tovName

    $rs = mysqli_query($GLOBALS['connection'], $query);//Выполняет запрос к базе данных; $GLOBALS['db'] - обращение к переменной $db в db.php

    //получить значения из запроса в виде массива
    $rsProduct = [];
    while ($row = mysqli_fetch_assoc($rs)){
        $rsProduct[] = $row;
    }
    return $rsProduct;
}


/**
 *Количество товаров
 */
function countGoods(){
    $query = 'SELECT COUNT(*) FROM ostbydate';
    $res = mysqli_query($GLOBALS['connection'], $query);
    $count_goods = mysqli_fetch_row($res);
    return $count_goods['0'];
}