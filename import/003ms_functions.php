<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/src/PHPMailer.php';
/**
 * Распечатка массива/переменной
 * @param $array array
 * @param string $arrName
 */
function print_arr($array, $arrName = '')
{
   $info = debug_backtrace();
   echo "Имя масива/переменной: <b>" . $arrName . "</b><br>";
   //echo ("Имя масива: " . $info[0]['args'][1] . '<br>');//возможно где-то работать не будет, использовать код выше
   echo ("Файл: " . $info[0]['file'] . '<br>');
   echo ("Строка распечатки: <b>" . $info[0]['line'] . "</b><br>");
   echo "<pre>" . print_r($array, true) . "</pre>";
}

/**
 *записать данные в txt
 */
function write_txt_file(){
   //получить массив всех товаров
   //$query_all = "SELECT * FROM `ostbydate_all`";
   $query_all = "SELECT * FROM ostbydate_all JOIN branches ON branches.branchid = ostbydate_all.branchid ORDER BY branch";
   $result_sql_price_003ms = mysqli_query($GLOBALS['connection'], $query_all) or die(mysqli_error($GLOBALS['connection']));
   $price_003ms = [];
   while ($row = mysqli_fetch_assoc($result_sql_price_003ms)) {
      $price_003ms[] = $row;
   }

   //записать полученный массив в txt
   $fp = fopen('apteka_neboleyka_price.txt', 'w');
   $field_description = 'TYP' . '|' . 'APTEKA' . '|' . 'PREPARAT' . '|' . 'PROIZV' . '|' . 'STRANA' . '|' . 'CENA' . '|' . 'OST' . '|' . 'SROK' . '|' . 'HREF';
   fwrite($fp, $field_description . "\r\n");
   foreach ($price_003ms as $product) {
      $typ = "остатки";
      $apteka = "{$product['branch']}";//!
      $preparat = "{$product['tovName']}";
      $proizv = "{$product['fabr']}";//!производитель и страна в одном поле, может обрезать?
      $strana = "";
      $cena = "{$product['pricerozn']}";
      $ost = "{$product['ost']}";
      $srok = "{$product['srokg']}";
      $href = PATH . "product/" . "{$product['alias']}";
      $data = $typ . '|' . $apteka . '|' . $preparat . '|' . $proizv . '|' . $strana . '|' . $cena . '|' . $ost . '|' . $srok . '|' . $href;
      fwrite($fp, $data . "\r\n");
   }
   fwrite($fp, "\n");
   fclose($fp);
}

/**
 *заархивировать
 */
function zip_file(){
   $zip = new ZipArchive();
   if ($zip->open('apteka_neboleyka_price.zip') === TRUE) {
      $zip->addFile('apteka_neboleyka_price.txt', 'apteka_neboleyka_price.txt');
      $zip->close();
   }
}

/**
 *отправить письмо в 003ms
 */
function send_mail_to_003() {
   $mail = new PHPMailer();
   $mail->setFrom(ADMIN_EMAIL, '=?UTF-8?B?' . base64_encode('Аптека Неболейка') . '?=');
   $mail->addAddress('iva2742@mail.ru', 'John');
   $mail->addAddress('iva2742@yandex.ru', 'John2');//если так слать на два адреса, то оба видят друг друга
   $mail->Subject = 'apteka_neboleyka_price';
   $mail->msgHTML(" ");//текст в письме
   $mail->addAttachment('apteka_neboleyka_price.zip'); //вложение
   $mail->send(); 
}


/**
 *отчет-письмо
 */
function report_mail(){

}