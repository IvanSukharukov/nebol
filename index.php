<?php
//определяем переменную, и если она не определена (в адресной строке вводится не то, что можно), то в доступе отказать
define("CATALOG", TRUE);

session_start();
//если в сессии нет массива корзины, то создаем его
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    $_SESSION['total_items'] = 0;
    $_SESSION['total_price'] = 0; //'0.00'
    $_SESSION['branch'] = 'all'; //'0.00'
}

include 'config.php';

//маршруты
$routes = array(
    //^ - с начала строки
    // i - не зависит от регистра
    // + - как минимум 1 символ
    // $ - запрещает дополнительные параметры после него
    //array('url' => '#^$|^\?#','view' => 'page'),

    array('url' => '#^$|^\?#', 'view' => 'home'),
    array('url' => '#^catalog/?([a-z0-9-]+)?#i', 'view' => 'catalog'),
    array('url' => '#^order/#i', 'view' => 'order'),
    array('url' => '#^cart/?([a-z0-9-]+)?#i', 'view' => 'cart'),
    //array('url' => '#^product/(?P<product_alias>[a-z0-9-]+)?$#i','view' => 'product'), //
    array('url' => '#^product/(?P<product_alias>[a-z0-9-]+)?#i', 'view' => 'product'),
    array('url' => '#^page/(?P<page_alias>[a-z0-9-]+)#i', 'view' => 'page'),
    array('url' => '#^search#i', 'view' => 'search'),
    //array('url' => '#^addtocart/(?P<regid>[0-9-]+)?#i','view' => 'cart')
);


//хранится путь к скрипту, исключая доменное имя
$url = ltrim($_SERVER['REQUEST_URI'], '/'); //обрезать '/' слева

foreach ($routes as $route) {
    $view = null; //чтобы не было ошибки Notice
    if (preg_match($route['url'], $url, $match)) {
        $view = $route['view'];
        break; //если совпадение в массиве $routes есть, то прекратить обход
    }
}

//если массив $match пуст (т.е. несуществующий адрес), то показать 404 ошибку(вид) и завершить работу скрипта
if (empty($match)) {
    header("HTTP/1.1 404 Not Found");
    include 'views/404View.php';
    exit;
}

//создать переменные измассива $match
extract($match);

//записать выбранную аптеку (выбор либо через select, либо $branch перезаписывается на id аптеки первого добавленного товара)

$branch = (int)$_COOKIE['branch'] ? (int)$_COOKIE['branch'] : BRANCH;

//повились следующие переменные
//$product_alias - alias продукта
//$view - вид для подключения
include_once "controllers/{$view}Controller.php";
