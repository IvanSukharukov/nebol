<?php
defined("CATALOG") or die("Access denied");
include 'config.php';
include 'models/mainModel.php';
//require_once 'models/productModel.php';

//получение страниц меню
//$pages = get_pages();

//получаем regid для добавления в корзину


/*if ($_GET['addtocart'] != 0) {
    $regid = abs((int)$_GET['addtocart']);
    //добавить в корзину
    addToCart($regid);
    //общая цена
    $_SESSION['total_sum'] = total_sum($_SESSION['cart']);
    // кол-во товара в корзине + защита от ввода несуществующего ID товара
    total_quantity();
    redirect();
}*/
//$branchid = 9117;
if (isset($_POST['addtocart'])) {
    $regid = abs((int)$_POST['regid']);
    $qty = abs((int)$_POST['qty']);
    $branchid = 9117;
    $pricerozn = abs((float)$_POST['pricerozn']); //цена приводится к float, возможно где-то не будет работать, в БД тип decimal(10,1)
    $ost = abs((int)$_POST['ost']);

    //добавить в корзину
    addToCart($regid, $qty, $branchid, $pricerozn, $ost);
    //общая цена
    $_SESSION['total_sum'] = total_sum($_SESSION['cart']);
    // кол-во товара в корзине + защита от ввода несуществующего ID товара
    total_quantity();
    redirect();
}