<?php
defined("CATALOG") or die("Access denied");

/**
 * Получение отдельного товара (9 ЧПУ Кудл)
 * @param $product_alias string
 */
function get_one_product($product_alias, $branch)
{
        //global $branchid;
        $product_alias = mysqli_real_escape_string($GLOBALS['connection'], $product_alias);
        //$query = "SELECT * FROM ostbydate_all WHERE `alias`= '$product_alias' LIMIT 1";

        //!$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE `alias`= '$product_alias' AND ostbydate_all.branchid = {$_GET['branchid']} AND ostbydate_all. pricerozn = {$_GET['pricerozn']} AND ostbydate_all.ost = {$_GET['ost']} LIMIT 1";

        //echo $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE `alias`= '$product_alias' AND ostbydate_all.branchid = {$_GET['branchid']}";





        if ($branch === 1) {
                $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE `alias`= '$product_alias'";
        } else {
                //$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE `alias`= '$product_alias' AND branches.branch_main_id = '$branch' AND ostbydate_all.branchid = 9208 LIMIT 1";
                echo $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE `alias`= '$product_alias' AND ostbydate_all.branchid = '$branch'";
        }


        //$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE branches.branch_main_id = $branch LIMIT $start_pos, $perpage";


        $res = mysqli_query($GLOBALS['connection'], $query);

        $result_product = [];
        while ($row = mysqli_fetch_assoc($res)) {
                $result_product[] = $row;
        }
        //print_arr(mysqli_fetch_assoc($result_product), 'res');
        return $result_product;
}
