<?php
defined("CATALOG") or die("Access denied");

/**
 * Получение отдельного товара (9 ЧПУ Кудл)
 * @param $product_alias string
 */
function get_one_product($product_alias){
        $product_alias = mysqli_real_escape_string($GLOBALS['connection'], $product_alias);
        $query = "SELECT * FROM ostbydate WHERE `alias`= '$product_alias' LIMIT 1";
        $res = mysqli_query($GLOBALS['connection'], $query);
        return mysqli_fetch_assoc($res);
}

