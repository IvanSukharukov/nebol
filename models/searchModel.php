<?php
defined("CATALOG") or die("Access denied");


/**
 *Поиск автокомплит для живого поиска
 */
function search_autocomplete(){
    $search = trim(mysqli_real_escape_string($GLOBALS['connection'], $_GET['term']));
    $query = "SELECT tovName FROM ostbydate WHERE tovName LIKE '%{$search}%' LIMIT 10";
    $res = mysqli_query($GLOBALS['connection'], $query);
    $result_search = [];
    while ($row = mysqli_fetch_assoc($res)){
        $result_search[] = $row['tovName'];
    }
    return $result_search;
}


/**
 *Количество результатов поиска
 */
function countSearch(){
    $search = trim(mysqli_real_escape_string($GLOBALS['connection'], $_GET['search']));
    $query = "SELECT COUNT(*) FROM ostbydate WHERE tovName LIKE '%{$search}%'";
    $res = mysqli_query($GLOBALS['connection'], $query);
    $count_search = mysqli_fetch_row($res);
    return $count_search[0];
}


/**
 * Поиск
 * @param $start_pos начальная позиция
 * @param $perpage количество товаров на странице
 * @return array|string результирующий массив | ничего не найдено
 */
function search($start_pos, $perpage){
    $search = trim(mysqli_real_escape_string($GLOBALS['connection'], $_GET['search']));

    $query = "SELECT * FROM ostbydate WHERE tovName LIKE '%{$search}%' ORDER BY tovName LIMIT $start_pos, $perpage";//возможно стоит получать только нужное

    $res = mysqli_query($GLOBALS['connection'], $query);

    if(!mysqli_num_rows($res)){
        return 'Ничего не найдено';
    }
    $result_search = [];
    while ($row = mysqli_fetch_assoc($res)){
        $result_search[] = $row;
    }
    return $result_search;
}

