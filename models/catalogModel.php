<?php
defined("CATALOG") or die("Access denied");

/**
 * Модель для таблицы товаров, получить товары
 * @param $start_pos int стартовая позиция для запроса
 * @param $perpage int сколько товаров на странице
 * @return array
 */
function getProducts($branch, $start_pos, $perpage)
{
    //если аптека не выбрана - показать все препараты из всех аптек
    if ($branch === 1) {
        //получить дополнительно адреса аптек из таблицы branches
        $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid LIMIT $start_pos, $perpage";
        $rs = mysqli_query($GLOBALS['connection'], $query);
    } else {
        //показать препараты выбранной аптеки
        //$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE ostbydate_all.branchid = $branch LIMIT $start_pos, $perpage";
        $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE branches.branch_main_id = $branch LIMIT $start_pos, $perpage";

        //получить препараты по двум branchid (маркировка и обычные)
        //SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE ostbydate_all.branchid IN(9117, 15837) LIMIT $start_pos, $perpage

        $rs = mysqli_query($GLOBALS['connection'], $query);
    }

    //получить значения из запроса в виде массива
    $rsProduct = [];
    while ($row = mysqli_fetch_assoc($rs)) {
        $rsProduct[] = $row;
    }

    $rsProduct = replace_tovName_with_key(do_group_products($rsProduct));


    return $rsProduct;
}


/**
 *Количество товаров
 */

function countGoodsAllProduct($branch)
{
    if ($branch === 1) {
        $query = 'SELECT COUNT(DISTINCT tovName) FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid';
    } else {
        $query = "SELECT COUNT(DISTINCT tovName) FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE branches.branch_main_id = {$branch}";
    }
    $res = mysqli_query($GLOBALS['connection'], $query);
    $count_goods = mysqli_fetch_row($res);
    return $count_goods['0'];
}