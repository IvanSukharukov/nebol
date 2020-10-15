<?php
defined("CATALOG") or die("Access denied");

/**
 * Функция дебага
 * @param null $value что проверяем
 * @param int $die ничего - остановить работу, 0 - продолжить
 */
function d($value = null, $die = 1)
{
    echo 'Debag-режим: </br><pre>';
    print_r($value);
    echo '</pre>';

    if ($die) die;
}

/**
 * Распечатка массива/переменной
 * @param $array array
 * @param string $arrName
 */
function print_arr($array, $arrName = '')
{
    $info = debug_backtrace();
    echo "Имя масива/переменной: <b>" . $arrName . "</b><br>";
    //echo ("Имя масива: " . $info[0]['args'][1] . '<br>');//возможно где-то работать не будет, использовать код выше
    echo ("Файл: " . $info[0]['file'] . '<br>');
    echo ("Строка распечатки: <b>" . $info[0]['line'] . "</b><br>");
    echo "<pre>" . print_r($array, true) . "</pre>";
}

/**
 * Фильтрация входящих данных
 * @param $var
 * @return string
 */
function clear($var)
{
    $var = mysqli_real_escape_string($GLOBALS['connection'], strip_tags(trim($var)));
    return $var;
}


/**
 * Обрезать нулевыt копейки у цены
 */
function trim_zero($num)
{
    return $num == (int)($num) ? (int)$num : $num;
}





/**
 * Получение страниц
 * @return array
 */
/*function get_pages(){
    $query = "SELECT title, alias FROM pages ORDER BY position";

    $res = mysqli_query($GLOBALS['connection'], $query);//Выполняет запрос к базе данных; $GLOBALS['db'] - обращение к переменной $db в db.php

    //получить значения из запроса в виде массива
    $pages = [];
    while ($row = mysqli_fetch_assoc($res)){
        $pages[$row['alias']] = $row['title'];
    }
    return $pages;
}*/


/**
 * Постраничная навигация
 * @param $page int номер запрошенной страницы
 * @param $count_pages int общее кол-во страниц
 * @param bool $modrew true - работаем с ЧПУ, false - работаем по обычному
 *
 */
function pagination($page, $count_pages, $modrew = true)
{
    // << < 3 4 5 6 7 > >>
    $back = null; // ссылка НАЗАД
    $forward = null; // ссылка ВПЕРЕД
    $startpage = null; // ссылка В НАЧАЛО
    $endpage = null; // ссылка В КОНЕЦ
    $page2left = null; // вторая страница слева
    $page1left = null; // первая страница слева
    $page2right = null; // вторая страница справа
    $page1right = null; // первая страница справа

    $uri = "?";
    // если есть параметры в запросе
    if (!$modrew) {
        //работаем без ЧПУ
        if ($_SERVER['QUERY_STRING']) {
            foreach ($_GET as $key => $value) {
                if ($key != 'page') $uri .= "{$key}=$value&amp;";
            }
        }
    } else {
        //работаем с ЧПУ
        $url = $_SERVER['REQUEST_URI'];
        $url = explode("?", $url);
        if (isset($url[1]) && $url[1] != '') {
            $params = explode("&", $url[1]);
            foreach ($params as $param) {
                if (!preg_match("#page=#", $param)) $uri .= "{$param}&amp;";
            }
        }
    }

    if ($page > 1) {
        $back = "<a class='nav-link' href='{$uri}page=" . ($page - 1) . "'>&lt;</a>";
    }
    if ($page < $count_pages) {
        $forward = "<a class='nav-link' href='{$uri}page=" . ($page + 1) . "'>&gt;</a>";
    }
    if ($page > 3) {
        $startpage = "<a class='nav-link' href='{$uri}page=1'>&laquo;</a>";
    }
    if ($page < ($count_pages - 2)) {
        $endpage = "<a class='nav-link' href='{$uri}page={$count_pages}'>&raquo;</a>";
    }
    if ($page - 2 > 0) {
        $page2left = "<a class='nav-link' href='{$uri}page=" . ($page - 2) . "'>" . ($page - 2) . "</a>";
    }
    if ($page - 1 > 0) {
        $page1left = "<a class='nav-link' href='{$uri}page=" . ($page - 1) . "'>" . ($page - 1) . "</a>";
    }
    if ($page + 1 <= $count_pages) {
        $page1right = "<a class='nav-link' href='{$uri}page=" . ($page + 1) . "'>" . ($page + 1) . "</a>";
    }
    if ($page + 2 <= $count_pages) {
        $page2right = "<a class='nav-link' href='{$uri}page=" . ($page + 2) . "'>" . ($page + 2) . "</a>";
    }

    return $startpage . $back . $page2left . $page1left . '<a class="nav-active">' . $page . '</a>' . $page1right . $page2right . $forward . $endpage;
}


/**
 *Редирект на ту же страницу, используется в обновлении корзины
 */
function redirect()
{
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location: $redirect");
    exit;
}

/**
 * Проверить есть ли добавляемый товар в корзине, учитывая regid, branchid, pricerozn, ost
 */
function double_Product_Cart($regid, $branchid, $pricerozn, $ost)
{
    foreach ($_SESSION['cart'] as $key => $product) {
        if (($_SESSION['cart'][$key]['regid'] == $regid) && ($_SESSION['cart'][$key]['branchid'] == $branchid) &&  ($_SESSION['cart'][$key]['pricerozn'] == $pricerozn) && ($_SESSION['cart'][$key]['ost'] == $ost)) {
            return $key; //если найден, то вернуть ключ этого товара, далее в addToCart добавить количество
        }
    }
    return false;
}


/**
 * Добавить в корзину
 * @param $regid
 * @param int $qty
 * @return mixed
 */
function addToCart($regid, $qty, $branchid, $pricerozn, $ost)
{
    //проверка, есть ли товар в корзине
    $key = double_Product_Cart($regid, $branchid, $pricerozn, $ost);
    if ($key !== false) { // ноль тоже проходит эту проверку
        //$key = double_Product_Cart($regid, $branchid, $pricerozn, $ost);//!ранее было так
        
        //если добавляемое кол-во больше допустимого остатка
        if ($_SESSION['cart'][$key]['qty'] == $_SESSION['cart'][$key]['ost']) $qty = 0;
        //если повторное добавление больше допустимого остатка
        if ($_SESSION['cart'][$key]['qty'] + $qty > $_SESSION['cart'][$key]['ost']) $qty = $_SESSION['cart'][$key]['ost'] - $_SESSION['cart'][$key]['qty'];
        //на странице корзины положить то кол-во, которое выбрано, а не суммировать старое и новое кол-во
        if ($_POST['qty_cart']) $_SESSION['cart'][$key]['qty'] = abs((int)$_POST['qty_cart']);
        
        $_SESSION['cart'][$key]['qty'] += $qty;
    } else {
        // если товар кладется в корзину впервые
        array_push($_SESSION['cart'], ["regid" => $regid, "qty" => $qty]);
        $next_item = array_key_last($_SESSION['cart']); //последний ключ
        atributes_product($next_item, $branchid, $pricerozn, $ost, $regid);
    }
    
    return $_SESSION['cart'];
}

/**
 * Атрибуты товара
 * @param $goods
 * @return float|int
 */
function atributes_product($next_item, $branchid, $pricerozn, $ost, $regid)
{

    $_SESSION['cart'][$next_item]['branchid'] = $branchid;
    $_SESSION['cart'][$next_item]['pricerozn'] = $pricerozn;
    $_SESSION['cart'][$next_item]['ost'] = $ost;


    $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE `regid`='{$regid}' AND ostbydate_all.branchid = '{$branchid}' AND ostbydate_all. pricerozn = '{$pricerozn}' AND ostbydate_all.ost = '{$ost}'";

    $res = mysqli_query($GLOBALS['connection'], $query) or die(mysqli_error($GLOBALS['connection']));

    $row = mysqli_fetch_assoc($res);

    $_SESSION['cart'][$next_item]['branchid'] = $row['branchid'];
    $_SESSION['cart'][$next_item]['tovName'] = $row['tovName'];
    $_SESSION['cart'][$next_item]['fabr'] = $row['fabr'];
    $_SESSION['cart'][$next_item]['ost'] = $row['ost'];
    $_SESSION['cart'][$next_item]['pricerozn'] = $row['pricerozn'];
    $_SESSION['cart'][$next_item]['recipe'] = $row['recipe'];
    $_SESSION['cart'][$next_item]['branch'] = $row['branch'];
}



/**
 * Сумма заказа в корзине
 * @param $goods
 * @return float|int
 */
function total_sum($goods)
//function total_sum($goods, $branchid, $pricerozn, $ost)
{
    $total_sum = 0;
    foreach ($goods as $good) {
        $total_sum += $good['qty'] * $good['pricerozn'];
    }

    return $total_sum;
}

/**
 * Общее количество товаров
 *
 */
function total_quantity()
{
    $_SESSION['total_quantity'] = 0;
    foreach ($_SESSION['cart'] as $key => $value) {
        if (isset($value['pricerozn'])) {
            // если получена цена товара из БД - суммируем кол-во
            $_SESSION['total_quantity'] += $value['qty'];
        } else {
            // иначе - удаляем такой ID из сессиии (корзины)
            unset($_SESSION['cart'][$key]);
        }
    }
}


/**
 *Получить филиалы, маркировка отсекается
 */
function getBranches()
{
    $query = "SELECT * FROM `branches` WHERE `branchId`=`branch_main_id`";
    $rs = mysqli_query($GLOBALS['connection'], $query);
    $result_getBranches = [];
    while ($row = mysqli_fetch_assoc($rs)) {
        $result_getBranches[] = $row;
    }
    return $result_getBranches;
}


/**
 * Сделать группировку по наименованию входящего массива([анальгин][0]параметры[1])
 */
function do_group_products($arr)
{
    $result_group = [];
    if (!empty($arr)) {
        for ($i = 0; $i < count($arr); $i++) {

            //$key_num = (array_key_last($result_group)) ?? 0;

            //в эту переменную записываем ключ товара, если он найден
            $key_tovName = array_search($arr[$i]['tovName'], array_column($result_group, 'tovName'));
            if ($key_tovName !== false) { //если товар найден, то записать его атрибуты
                $result_group[$key_tovName][] = $arr[$i];
            } else { //если такого товара нет в результирующем массиве сделать новую запись с атрибутами
                $result_group[$arr[$i]['tovName']][] = $arr[$i];
            }
        }
        return $result_group;
    }
}

/**
 * Заменить ключ-название на ключ-цифру
 */
function replace_tovName_with_key($arr)
{
    $replace_arr_key = [];
    foreach ($arr as $value) {
        $replace_arr_key[] = $value;
    }
    return $replace_arr_key;
}