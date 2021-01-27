<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/src/PHPMailer.php';

/**
 * Распечатка массива/переменной
 * @param $array array
 * @param string $arrName
 */
function print_arr($array, $arrName = ''){
    $info = debug_backtrace();
    echo "Имя масива/переменной: <b>" . $arrName . "</b><br>";
    //echo ("Имя масива: " . $info[0]['args'][1] . '<br>');//возможно где-то работать не будет, использовать код выше
    echo ("Файл: " . $info[0]['file'] . '<br>');
    echo ("Строка распечатки: <b>" . $info[0]['line'] . "</b><br>");
    echo "<pre>" . print_r($array, true) . "</pre>";
}

/**
*Транслит кириллицы в латиницу
*/
function translit($s) {
  $s = (string) $s; // преобразуем в строковое значение
  $s = strip_tags($s); // убираем HTML-теги
  $s = str_replace(array("\n", "\r"), " ", $s); // убираем перевод каретки
  $s = preg_replace("/\s+/", ' ', $s); // удаляем повторяющие пробелы
  $s = trim($s); // убираем пробелы в начале и конце строки
  $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s); // переводим строку в нижний регистр (иногда надо задать локаль)
  $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
  $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s); // очищаем строку от недопустимых символов
  $s = str_replace(" ", "-", $s); // заменяем пробелы знаком минус
  return $s; // возвращаем результат
}

/**
 *Для получения остатков(чтобы на beget работало)
 * file_get_contents - только через curl
 */
function file_get_contents_curl($url, $sessionId) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("WebApiSession:" . $sessionId . "\r\n"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

/**
*Авторизация
*/
function auth(){
	//https://farmnet.ru:1988/Login?customerId=11797&password=5uQwDTkt
	global $sessionId;
	// $customerId = '11797';
	// $password = '5uQwDTkt';

	$customerId ='10966'; //через эти данные квестор логинится
	$password = 'mZZ04JDl';

	$query_auth = file_get_contents('https://farmnet.ru:1988/Login?customerId='.$customerId.'&password='.$password);
	$query_auth = json_decode($query_auth, true);
	//print_arr($query_auth);
	if ($query_auth['status'] == 1) {
        mail_error($query_auth['error']);
        die;
    }
	$sessionId = $query_auth['sessionId'];
	return $sessionId;
}


/**
*Получить остатки на дату
*/
function ostByDate() {
    //$customerId = '11797' = три аптеки рядом с Сашей
	/*$customerId = '11797';
	$branchId = 9117;*/

	$parentId = '10966'; // id владельца pass = mZZ04JDl

	global $sessionId;
	$ost_arr = [];
	$opts = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"WebApiSession:" . $sessionId . "\r\n"
	  )
	);
	$context = stream_context_create($opts);
	//$file = file_get_contents('https://farmnet.ru:1988/OstByDate?customerId='.$customerId.'&date='.date("Y-m-dH:i:s"), false, $context); //для трех аптек на Просвещении
	$file = file_get_contents('https://farmnet.ru:1988/OstByDate?parentId='.$parentId.'&date='.date("Y-m-dH:i:s"), false, $context);
    if (!$file) {
        mail_error('Ошибка с file_get_contents');
        die;
    }
	$ost_arr = json_decode($file, true);
	//print_arr($ost_arr);
    return $ost_arr;


}

/**
 *Получить остатки на дату при помощи file_get_contents_curl
 */
function ostByDate_file_get_contents_curl() {
    //$customerId = '11797' = три аптеки рядом с Сашей
    /*$customerId = '11797';
    $branchId = 9117;*/

    $parentId = '10966'; // id владельца pass = mZZ04JDl

    global $sessionId;
    $ost_arr = [];
    $opts = array(
        'http'=>array(
            'method'=>"GET",
            'header'=>"WebApiSession:" . $sessionId . "\r\n"
        )
    );
    $context = stream_context_create($opts);
    //$file = file_get_contents('https://farmnet.ru:1988/OstByDate?customerId='.$customerId.'&date='.date("Y-m-dH:i:s"), false, $context); //для трех аптек на Просвещении
    //$file = file_get_contents('https://farmnet.ru:1988/OstByDate?parentId='.$parentId.'&date='.date("Y-m-dH:i:s"), false, $context);
    $file = file_get_contents_curl('https://farmnet.ru:1988/OstByDate?parentId='.$parentId.'&date='.date("Y-m-d%20H:i:s"), $sessionId);
    if (!$file) {
        mail_error('Ошибка с ostByDate_file_get_contents_curl');
        die;
    }
    $ost_arr = json_decode($file, true);

    //var_dump($file);
    //print_arr($ost_arr);
    return $ost_arr;


}

/**
 *Получить остатки на дату при помощи curl
 */
function ostByDate_curl() {
    //$customerId = '11797' = три аптеки рядом с Сашей
    /*$customerId = '11797';
    $branchId = 9117;*/

    $parentId = '10966'; // id владельца pass = mZZ04JDl

    global $sessionId;
    $ost_arr = [];
    $opts = array(
        'http'=>array(
            'method'=>"GET",
            'header'=>"WebApiSession:" . $sessionId . "\r\n"
        )
    );
/*    $context = stream_context_create($opts);
    ////$file = file_get_contents('https://farmnet.ru:1988/OstByDate?customerId='.$customerId.'&date='.date("Y-m-dH:i:s"), false, $context); //для трех аптек на Просвещении
    $file = file_get_contents('https://farmnet.ru:1988/OstByDate?parentId='.$parentId.'&date='.date("Y-m-dH:i:s"), false, $context);
    $ost_arr = json_decode($file, true);
    //print_arr($ost_arr);
    return $ost_arr;*/

    //$url = 'https://farmnet.ru:1988/OstByDate?parentId='.$parentId.'&date='.date("Y-m-dH:i:s");
//    $options = ['content' => $data];
    $ch = curl_init('https://farmnet.ru:1988/OstByDate?parentId='.$parentId.'&date='.date("Y-m-dH:i:s"));
//    curl_setopt($ch, CURLOPT_POST, 1);
//    curl_setopt($ch, CURLOPT_POSTFIELDS, $options);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("WebApiSession:" . $sessionId . "\r\n"));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $file = curl_exec($ch);
    curl_close($ch);
    $ost_arr = json_decode($file, true);
    return $ost_arr;

//    ===
/*    $options = array( // задаем параметры запроса
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => $data,
        ),
    );
    $context  = stream_context_create($options); // создаем контекст отправки
    $result = file_get_contents($url, false, $context); // отправляем*/
}



/**
 *Записать товары в таблицу ОБРАБОТАННЫЙ массив
 */
function write_db_OstByDate($ost_arr){
    //del_db_ostbydate();
    //global $ost_arr;
    //print_arr($ost_arr);
    global $connection;
    if($ost_arr) {
        //удалить все данные из таблицы перед добавлением. Вероятно логичнее сделать обновление.
        $query = "DELETE FROM `ostbydate`";
        mysqli_query($connection, $query);
        for ($i = 0; ($i < count($ost_arr)); $i++) {
            $branchId = (int) $ost_arr[$i]['branchId'];
            $regId = (int)$ost_arr[$i]['regId'];
            $tovName = mysqli_real_escape_string($connection, $ost_arr[$i]['tovName']);
            $alias = mysqli_real_escape_string($connection, translit($ost_arr[$i]['tovName']));
            $fabr = mysqli_real_escape_string($connection, $ost_arr[$i]['fabr']);
            $uQntOst = (int)$ost_arr[$i]['uQntOst'];
            $priceRoznWNDS = (double)$ost_arr[$i]['priceRoznWNDS'];
            $recipe = (int)$ost_arr[$i]['recipe'];
            $query = "INSERT INTO ostbydate (`branchid`,`regid`,`tovName`,`alias`,`fabr`,`ost`,`pricerozn`,`recipe`) VALUES ('$branchId', '$regId', '$tovName', '$alias','$fabr', '$uQntOst', '$priceRoznWNDS', '$recipe')";
            mysqli_query($connection, $query) or die(mysqli_error($connection));
        }
    } else {
        mail_error('массив $ost_arr пуст, данные не обновлялись');
        die;
    }
}

/**
 *Записать товары в таблицу НЕ обработанный массив Сашиной аптеки
 */
function write_db_OstByDate_9117($ost_arr)
{
    //del_db_ostbydate();
    //global $ost_arr;
    //print_arr($ost_arr);
    global $connection;
    if ($ost_arr) {
        //удалить все данные из таблицы перед добавлением. Вероятно логичнее сделать обновление.
        $query = "DELETE FROM `ostbydate_all`";
        mysqli_query($connection, $query);
        for ($i = 0; ($i < count($ost_arr['items'])); $i++) {
            $branchId = (int) $ost_arr['items'][$i]['branchId'];
            $regId = (int)$ost_arr['items'][$i]['regId'];
            $tovName = mysqli_real_escape_string($connection, $ost_arr['items'][$i]['tovName']);
            $alias = mysqli_real_escape_string($connection, translit($ost_arr['items'][$i]['tovName']));
            $fabr = mysqli_real_escape_string($connection, $ost_arr['items'][$i]['fabr']);
            $uQntOst = (int)$ost_arr['items'][$i]['uQntOst'];
            $priceRoznWNDS = (float)$ost_arr['items'][$i]['priceRoznWNDS'];
            $recipe = (int)$ost_arr['items'][$i]['recipe'];
            if ($branchId == 9117) {
                $query = "INSERT INTO ostbydate_all (`branchid`,`regid`,`tovName`,`alias`,`fabr`,`ost`,`pricerozn`,`recipe`) VALUES ('$branchId', '$regId', '$tovName', '$alias','$fabr', '$uQntOst', '$priceRoznWNDS', '$recipe')";
                mysqli_query($connection, $query) or die(mysqli_error($connection));
            }
        }
    } else {
        mail_error('массив $ost_arr пуст, данные не обновлялись');
        die;
    }
}


/**
 *Записать товары в таблицу НЕ обработанный массив ВСЕХ АПТЕК (исключить Приладожский)
 */
function write_db_OstByDate_all($ost_arr)
{
    //del_db_ostbydate();
    //global $ost_arr;
    //print_arr($ost_arr);
    global $connection;
    if ($ost_arr) {
        //удалить все данные из таблицы перед добавлением. Вероятно логичнее сделать обновление.
        $query = "DELETE FROM `ostbydate_all`";
        mysqli_query($connection, $query);
        for ($i = 0; ($i < count($ost_arr['items'])); $i++) {
            $branchId = (int) $ost_arr['items'][$i]['branchId'];
            if ($branchId == 8863 || $branchId == 13826) {//Приладожский исключен
                continue;
            }
            $regId = (int)$ost_arr['items'][$i]['regId'];
            $tovName = mysqli_real_escape_string($connection, $ost_arr['items'][$i]['tovName']);
            if ($tovName == 'Цефтриаксон-АКОС фл.(пор. д/приг. р-ра д/в/в и в/м введ.) 1г №1 (пач.карт.)' ||
                $tovName == 'Цефтриаксон фл.(пор. д/приг. р-ра д/в/в и в/м введ.) 1г №1 пач.карт.' ||
                $tovName == 'Цефтриаксон-АКОС фл.(пор. д/приг. р-ра д/в/в и в/м введ.) 2г №1 (пач.карт.)' ||
                $tovName == 'Цефтриаксон фл.(пор. д/приг. р-ра д/в/в и в/м введ.) 1г №50' ||
                $tovName == 'Цефтриаксон-АКОС фл.(пор. д/приг. р-ра д/в/в и в/м введ.) 1г №50' ||
                $tovName == 'Клексан шприц (р-р д/ин.) 4000 анти-Ха МЕ/0,4 мл №10 (с защитной системой иглы)'
                ) {
                continue;
            }
            $alias = mysqli_real_escape_string($connection, translit($ost_arr['items'][$i]['tovName']));
            $fabr = mysqli_real_escape_string($connection, $ost_arr['items'][$i]['fabr']);
            $uQntOst = (int)$ost_arr['items'][$i]['uQntOst'];
            if ($uQntOst == 0) {
                continue;
            }
            $priceRoznWNDS = (float)$ost_arr['items'][$i]['priceRoznWNDS'];
            $priceOptWNDS = (float)$ost_arr['items'][$i]['priceOptWNDS'];
            $recipe = (int)$ost_arr['items'][$i]['recipe'];
            $srokg = $ost_arr['items'][$i]['srokG'];
            $query = "INSERT INTO ostbydate_all (`branchid`,`regid`,`tovName`,`alias`,`fabr`,`ost`,`pricerozn`,`priceopt`,`recipe`,`srokg`) VALUES ('$branchId', '$regId', '$tovName', '$alias','$fabr', '$uQntOst', '$priceRoznWNDS', '$priceOptWNDS', '$recipe', '$srokg')";
            mysqli_query($connection, $query) or die(mysqli_error($connection));
            
        }
    } else {
        mail_error('массив $ost_arr пуст, данные не обновлялись');
        die;
    }
}

/**
 *Записать товары в таблицу необработанный массив
 */
function write_db_OstByDate_test()
{
    //del_db_ostbydate();
    global $ost_arr;
    //print_arr($ost_arr);
    global $connection;
    for ($i = 0; ($i < count($ost_arr['items'])); $i++) {
        $branchId = (int) $ost_arr['items'][$i]['branchId'];
        $regId = (int)$ost_arr['items'][$i]['regId'];
        $tovName = mysqli_real_escape_string($connection, $ost_arr['items'][$i]['tovName']);
        $alias = mysqli_real_escape_string($connection, translit($ost_arr['items'][$i]['tovName']));
        $fabr = mysqli_real_escape_string($connection, $ost_arr['items'][$i]['fabr']);
        $uQntOst = (int)$ost_arr['items'][$i]['uQntOst'];
        $priceRoznWNDS = (float)$ost_arr['items'][$i]['priceRoznWNDS'];
        $recipe = (int)$ost_arr['items'][$i]['recipe'];
        $query = "INSERT INTO test (`branchid`,`regid`,`tovName`,`alias`,`fabr`,`ost`,`pricerozn`,`recipe`) VALUES ('$branchId', '$regId', '$tovName', '$alias','$fabr', '$uQntOst', '$priceRoznWNDS', '$recipe')";
        mysqli_query($connection, $query) or die(mysqli_error($connection));
    }
}

/**
 *Адреса аптек
 */
function adress_aptek(){
	global $sessionId;
	$opts = array(
	  'http'=>array(
	    'method'=>"GET",
	    'header'=>"WebApiSession:" . $sessionId . "\r\n"
	  )
	);
	$context = stream_context_create($opts);
	
	$file = file_get_contents('https://farmnet.ru:1988/BranchList', false, $context);
	$apteki_arr = json_decode($file, true);
	//print_arr($apteki_arr);
}


/**
 *Отправка письма с информацией об импорте
 */
/* function mail_import() {
    $query_count = "SELECT COUNT(1) FROM `ostbydate_all`";
    $count_db = mysqli_query($GLOBALS['connection'], $query_count) or die(mysqli_error($GLOBALS['connection']));//сколько строк ПОСЛЕ ипорта
    $count_db = mysqli_fetch_assoc($count_db);

    $query_date = "SELECT `date_import` FROM `ostbydate_all` LIMIT 1";
    $date_import = mysqli_query($GLOBALS['connection'], $query_date) or die(mysqli_error($GLOBALS['connection']));//дата последнего импорта
    $date_import = mysqli_fetch_assoc($date_import);
    
    $subject = "{$count_db['COUNT(1)']} строк, дата {$date_import['date_import']}";
    echo $subject;
    
    $headers = "Content-type: text/plain; charset=utf-8\r\n";
    $headers .= "From: Импорт <" . ADMIN_EMAIL . ">\r\n";

    
    $mail_body = "В таблице {$count_db['COUNT(1)']} строк, дата обновления {$date_import['date_import']}";
        
    mail('iva2742@mail.ru', $subject, $mail_body, $headers);//возможно стоит указать настоящий email админа жестко
    
} */

/**
 *Отправка письма с информацией об импорте
 */
function mail_import()
{
    $query_count = "SELECT COUNT(1) FROM `ostbydate_all`";
    $count_db = mysqli_query($GLOBALS['connection'], $query_count) or die(mysqli_error($GLOBALS['connection'])); //сколько строк ПОСЛЕ ипорта
    $count_db = mysqli_fetch_assoc($count_db);

    $query_date = "SELECT `date_import` FROM `ostbydate_all` LIMIT 1";
    $date_import = mysqli_query($GLOBALS['connection'], $query_date) or die(mysqli_error($GLOBALS['connection'])); //дата последнего импорта
    $date_import = mysqli_fetch_assoc($date_import);

    $subject = "{$count_db['COUNT(1)']} строк, дата {$date_import['date_import']}";
    echo $subject;


    $mail = new PHPMailer();
    $mail->CharSet = "utf-8";//кодировка
    $mail->setFrom(ADMIN_EMAIL, '=?UTF-8?B?' . base64_encode('Импорт') . '?=');// от кого (email и имя)
    $mail->addAddress('iva2742@mail.ru', 'John'); // кому (email и имя)
    $mail->Subject = "{$count_db['COUNT(1)']} строк, дата {$date_import['date_import']}"; // тема письма
    $mail->msgHTML("В таблице {$count_db['COUNT(1)']} строк, дата обновления {$date_import['date_import']}"); //текст в письме 
    $mail->send();
}


/**
 *Отправка письма об ошибке
 */
function mail_error($mail_error) {
    
   /*  $subject = "Ошибка";
    echo $subject;    
    $headers = "Content-type: text/plain; charset=utf-8\r\n";
    $headers .= "From: Ошибка аптека <" . ADMIN_EMAIL . ">\r\n";    
    $mail_body = "{$mail_error}";        
    mail('iva2742@mail.ru', $subject, $mail_body, $headers); //возможно стоит указать настоящий email админа жестко
 */

    $mail = new PHPMailer();
    $mail->CharSet = "utf-8"; //кодировка
    $mail->setFrom(ADMIN_EMAIL, '=?UTF-8?B?' . base64_encode('Ошибка аптека') . '?='); // от кого (email и имя)
    $mail->addAddress('iva2742@mail.ru', 'John'); // кому (email и имя)
    $mail->Subject = "Ошибка"; // тема письма
    $mail->msgHTML("{$mail_error}"); //текст в письме 
    $mail->send();
}

/*
$customerIdAvalible = '9117';
$accesses[0]['customerId']='10966';
$accesses[0]['password']= 'mZZ04JDl';

$accesses[1]['customerId']='18458';
$accesses[1]['password']= 'JMBbDrXT';

$accesses[2]['customerId']='11797';
$accesses[2]['password']= '5uQwDTkt';*/

//минимальная цена из повторяющихся препаратов одного названия
//SELECT `tovName`,MIN(`pricerozn`) FROM `test` WHERE `alias`='amoksiklav-kviktab-tab-disperg-500mg--125mg-14'


/**
 * Минимальная цена у конкретного наименования (продукта) для сайта
 * @param $arr array входящий массив (необработанный)
 * @return array обработанный массив
 */
function min_price_one_product($arr){
    $result = [];
    for($i = 0; $i < count($arr['items']); $i++) {
        //в эту переменную записываем ключ найденного товара,
        // array_column - ищем по колонке названия товара, возможно поиск по полю regId будет быстрее
        $key_tovName = array_search($arr['items'][$i]['tovName'], array_column($result, 'tovName'));
        if ($key_tovName !== false) {//если ключа нет, т.е. товар не найден, то записать
            //если товар есть, то сравнить цену и обновить, если в результирующем массиве цена больше
            if($arr['items'][$i]['priceRoznWNDS'] <= $result[$key_tovName]['priceRoznWNDS']){
                $result[$key_tovName]['priceRoznWNDS'] = $arr['items'][$i]['priceRoznWNDS'];
                //если нужно будет учитывать общее количество, а не только товара у которого мин.цена
                //$result[$key_tovName]['ost'] += $arr['items'][$i]['ost'];
            }
        }else{
            array_push($result, $arr['items'][$i]);
        }
    }
    return $result;
}

/**
 * 003ms
 * Минимальная цена у конкретного наименования (продукта) для сайта
 * @param $arr array входящий массив (необработанный)
 * @return array обработанный массив
 */
function min_price_one_product_003ms($arr)
{
    $result = [];
    for ($i = 0; $i < count($arr); $i++) {
        //в эту переменную записываем ключ найденного товара,
        // array_column - ищем по колонке названия товара, возможно поиск по полю regId будет быстрее
        $key_tovName = array_search($arr[$i]['tovName'], array_column($result, 'tovName'));
        if ($key_tovName !== false) { //если ключа нет, т.е. товар не найден, то записать
            //если товар есть, то сравнить цену и обновить, если в результирующем массиве цена больше
            if ($arr[$i]['pricerozn'] <= $result[$key_tovName]['pricerozn']) {
                $result[$key_tovName]['pricerozn'] = $arr[$i]['pricerozn'];
                //если нужно будет учитывать общее количество, а не только товара у которого мин.цена
                //$result[$key_tovName]['ost'] += $arr['items'][$i]['ost'];
            }
        } else {
            array_push($result, $arr[$i]);
        }
    }
    return $result;
}