<?php
defined("CATALOG") or die("Access denied");
include 'config.php';
include 'models/mainModel.php';
//require_once 'models/productModel.php';

//$branchid = 1;
if (isset($_POST['addtocart'])) {
    $regid = abs((int)$_POST['regid']);
    $qty = abs((int)$_POST['qty']);
    $branchid = abs((int)$_POST['branchid']);
    $pricerozn = abs((float)$_POST['pricerozn']);//цена приводится к float, возможно где-то не будет работать, в БД тип decimal(10,1)
    $ost = abs((int)$_POST['ost']);

    addToCart($regid, $qty, $branchid, $pricerozn, $ost);
 
    $_SESSION['total_sum'] = total_sum($_SESSION['cart']);
    // кол-во товара в корзине + защита от ввода несуществующего ID товара
    total_quantity();
    redirect();
}

//записать в $_COOKIE['branch'] id аптеки первого добавленного товара
if (!empty(current($_SESSION['cart']))) {
    // $_COOKIE['branch'] = current($_SESSION['cart'])['branchid'];
    //получить id главной аптеки (на случай маркировки)
    $branch = get_branch_main_id(current($_SESSION['cart'])['branchid']);
}

//все аптеки
$branches = getBranches();


//print_arr($branches, '$branches');
//print_arr($branch, '$branch');
//print_arr($_COOKIE['branch'], '$_COOKIE');
