<?php
defined("CATALOG") or die("Access denied");
include 'mainController.php';
include "models/{$view}Model.php";

//ели нажата кнопка "заказать"
if($_POST['order']){
    //Добавление заказа
    add_order();
    redirect();
}

include "views/{$view}View.php";