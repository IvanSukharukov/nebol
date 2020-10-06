<?php
defined("CATALOG") or die("Access denied");

include 'mainController.php';
include "models/{$view}Model.php";

//получение одного продукта

$product = get_one_product($product_alias);//alias присваивается в регулярном выражении в import.php

/*//обращение по id
$product_id = $_GET['product'];
$get_one_product = get_one_product($product_id);*/

include_once "views/{$view}View.php";
