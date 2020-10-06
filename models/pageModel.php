<?php
defined("CATALOG") or die("Access denied");

/**
 * Получение отдельной страницы
 * @param $page_alias string
 */
/*function get_one_page($page_alias){
        $page_alias = mysqli_real_escape_string($GLOBALS['connection'], $page_alias);
        $query = "SELECT * FROM pages WHERE `alias`= '$page_alias' LIMIT 1";
        $res = mysqli_query($GLOBALS['connection'], $query);
        return mysqli_fetch_assoc($res);
}*/