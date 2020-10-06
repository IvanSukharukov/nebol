<?php
defined("CATALOG") or die("Access denied");

include 'mainController.php';
include "models/{$view}Model.php";

/*if( !isset($page_alias) ) $page_alias = 'index'; // назначаем главную страницу
$page = get_one_page($page_alias);//alias присваивается в регулярном выражении в import.php

if( !$page ){
    include 'views/404View.php';
    exit;
}*/



//include_once "views/{$view}View.php";
include_once "views/{$page_alias}View.php";
