<?php
defined("CATALOG") or die("Access denied");


/**
 *Поиск автокомплит для живого поиска по нескольким словам
 */
/* function search_autocomplete()
{
    $search = trim(mysqli_real_escape_string($GLOBALS['connection'], $_GET['term']));
    $query = "SELECT DISTINCT tovName FROM ostbydate_all WHERE tovName LIKE '%{$search}%' LIMIT 10";
    $res = mysqli_query($GLOBALS['connection'], $query);
    $result_search = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $result_search[] = $row['tovName'];
    }
    return $result_search;
} */

function search_autocomplete()
{    
    $search = trim(mysqli_real_escape_string($GLOBALS['connection'], $_GET['term']));
    $searchWords = explode(" ", $search);
    $query = "SELECT DISTINCT tovName FROM ostbydate_all WHERE tovName LIKE '%'";
    foreach ($searchWords as $word) {
        $query .= " AND tovName LIKE '%{$word}%'";
    }
    $query .= " LIMIT 10";
    $res = mysqli_query($GLOBALS['connection'], $query);
    $result_search = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $result_search[] = $row['tovName'];
    }
    return $result_search;
}




/**
 * Лимит запросов для получения товаров
 * должен вернуть количество для запроса, и это количество нужно запомнить
 */
function limit_sql($arr, $page)
{
    $limit = 0;
        for ($i = ($page - 1) * 10; $i < (($page - 1) * 10 + 10) && $i < count($arr); $i++) {
            $limit += count($arr[$i]);
        print_arr($i, '');
        }
    return $limit;
}

/**
 * Стартовая позиция
 */
function result_search_page ($arr, $page) {
    $result_search = [];
    for ($i = ($page - 1) * 10; $i < (($page - 1) * 10 + 10) && $i < count($arr); $i++) {
        $result_search[] = $arr[$i];
    }
    return $result_search;
}

/**
 *Весь массив искомого товара (по нескольким словам)
 */
function allSearch($branch)
{
    $search = trim(mysqli_real_escape_string($GLOBALS['connection'], $_GET['search']));

    $searchWords = explode(" ", $search);
    //$query = "SELECT COUNT(*) FROM ostbydate_all WHERE tovName LIKE '%{$search}%'";
    //если аптека не выбрана
    if ($branch === 1) {
        //получить дополнительно адреса аптек из таблицы branches
        //$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%{$search}%' ORDER BY tovName";
        
        $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%'";
        foreach ($searchWords as $word) {
            $query .= " AND tovName LIKE '%{$word}%'";
        }
        $query .= " ORDER BY tovName";


    } else {
        $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%'";

        foreach ($searchWords as $word) {
            $query .= " AND tovName LIKE '%{$word}%'";
        }
        $query .= " AND branches.branch_main_id = $branch ORDER BY tovName";

    }
    $res = mysqli_query($GLOBALS['connection'], $query);
    /* $count_search = mysqli_fetch_row($res);
    return $count_search[0]; */

    while ($row = mysqli_fetch_assoc($res)) {
        $result_search[] = $row;
    }
    //$count_search = count(do_group_products($result_search));

    //return do_group_products($result_search);
    return $result_search;
}


/**
 * Поиск, в том числе по выбранной аптеке
 * @param $start_pos начальная позиция
 * @param $perpage количество товаров на странице
 * @return array|string результирующий массив | ничего не найдено
 */
function search($branch, $start_pos, $perpage)
{
    $search = trim(mysqli_real_escape_string($GLOBALS['connection'], $_GET['search']));

    //$query = "SELECT * FROM ostbydate WHERE tovName LIKE '%{$search}%' ORDER BY tovName LIMIT $start_pos, $perpage";//возможно стоит получать только нужное
    //если аптека не выбрана
    if ($branch === 1) {
        //получить дополнительно адреса аптек из таблицы branches
        //$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%{$search}%' ORDER BY tovName LIMIT $start_pos, $perpage";

        //$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%{$search}%' ORDER BY pricerozn LIMIT $start_pos, $perpage";

        //$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%{$search}%' ORDER BY pricerozn";

        //$query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%{$search}%' ORDER BY tovName LIMIT $start_pos, $perpage";
        $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%{$search}%' ORDER BY tovName, pricerozn LIMIT $start_pos, $perpage";
    } else {
        $query = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid WHERE tovName LIKE '%{$search}%' AND branches.branch_main_id = $branch ORDER BY tovName LIMIT $start_pos, $perpage";
    }
    $res = mysqli_query($GLOBALS['connection'], $query);

    if (!mysqli_num_rows($res)) {
        return 'Ничего не найдено';
    }
    $result_search = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $result_search[] = $row;
    }
    $result_search = replace_tovName_with_key(do_group_products($result_search)); //!
    //$result_search = do_group_products($result_search);//!
    //print_arr($result_search, '$result_search');
    return $result_search;
}
