<?php
defined("CATALOG") or die("Access denied");

include 'mainController.php';
include "models/{$view}Model.php";

if (isset($page_alias)){
    include_once "views/{$page_alias}View.php";
} else {
    include_once "views/{$view}View.php";
}
