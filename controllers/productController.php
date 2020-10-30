<?php
defined("CATALOG") or die("Access denied");

include 'mainController.php';
include "models/{$view}Model.php";

//получение одного продукта

$product = get_one_product($product_alias, $branch); //alias присваивается в регулярном выражении в import.php

if (empty($product)) {
   header("HTTP/1.1 404 Not Found");
   include 'views/404View.php';
   exit;
}

/*//обращение по id
$product_id = $_GET['product'];
$get_one_product = get_one_product($product_id);*/

include_once "views/{$view}View.php";
