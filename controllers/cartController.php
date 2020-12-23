<?php
defined("CATALOG") or die("Access denied");
//include_once 'catalogController.php';
include_once 'mainController.php';
include "models/{$view}Model.php";


//if ($_POST['update']){
//    updateCart();
//    redirect();
//}

//очистить корзину
if ($_POST['delete-cart']){
    unset($_SESSION['cart']);
    unset($_SESSION['total_sum']);
    unset($_SESSION['sum_opt']);
    unset($_SESSION['total_quantity']);
    unset($_SESSION['branch']);
    unset($_SESSION['branch_address']);
    unset($_SESSION['phone']);
    redirect();
}

//удалить товар из корзины
if (isset($_POST['del-cart-product'])){
    if (count($_SESSION['cart']) > 1) { //если в корзине больше одного товара
        $key_regid = array_search($_POST['regid'], array_column($_SESSION['cart'], 'regid'));
        unset($_SESSION['cart'][$key_regid]);
        //unset($_SESSION['cart'][$_POST['regid']]);
        //общая цена
        $_SESSION['total_sum'] = total_sum($_SESSION['cart']);
        $_SESSION['sum_opt'] = total_sum_opt($_SESSION['cart']);
        // кол-во товара в корзине + защита от ввода несуществующего ID товара
        total_quantity();
    } else { //если в корзине остался один товар - удалить всю сессию
        unset($_SESSION['cart']);
        unset($_SESSION['total_sum']);
        unset($_SESSION['sum_opt']);
        unset($_SESSION['total_quantity']);
        unset($_SESSION['branch']);
        unset($_SESSION['branch_address']);
        unset($_SESSION['phone']);
    }
    redirect();
}

include "views/{$view}View.php";