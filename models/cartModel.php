<?php
defined("CATALOG") or die("Access denied");

/**
 *Обновить корзину
 */
function updateCart(){
    foreach ($_SESSION['cart'] as $regid => $qty){
        if ($_POST[$regid] == '0'){
            unset($_SESSION['cart'][$regid]);
        }else{
            $_SESSION['cart'][$regid] = $_POST[$regid];
        }
    }
}

