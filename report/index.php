<?php
ini_set('display_errors', 1); //для ошибок
error_reporting(E_ALL);
//defined("CATALOG") or die("Access denied!!!");
define("CATALOG", TRUE);
require_once '../config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/import/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Функция отладки/распечатки
 *
 * @param данные (переменная, массив, объект) $data
 * @return $data
 */
function db($data)
{
   $info = debug_backtrace();
   $file = file($info[0]['file']);
   $src  = $file[$info[0]['line'] - 1];
   //$src = rtrim(ltrim($src, 'db('), ");");
   //$src = rtrim($src, " \);");
   $pat  = '#(.*)' . __FUNCTION__ . ' *?\( *?\$(.*) *?\)(.*)#i';  // search pattern for wtf(parameter)
   $arguments  = trim(preg_replace($pat, '$2', $src));
   echo ($info[0]['file'] . '<br>');
   echo "Debug: <b>" . $arguments . "</b><br>";
   echo ("Строка: <b>" . $info[0]['line'] . "</b><br>");
   echo "<pre>" . print_r($data, true) . "</pre>";
}

/**
 * Создание отчета
 */

$year = date("Y");
$month = date("m");
$day = date("d");

//если 01 января, то отчет за декабрь
if ($month ==01 && $day == 01) {
   $year = $year - 1;
}

//если первое число, то в $day присваиваем последнее число предыдущего месяца, в $month - предыдущий месяц
if ($day == 01) {
   $day = date("t", strtotime("-1 month"));
   $month = date("m", strtotime("-1 month"));
}


/**
 * Формирование запроса
 */
function query_report($query, $branchid = null, $dostavka_id = null)
{
   $year = date("Y");
   $month = date("m");
   $day = date("d");

   //если январь, то отчет за декабрь
   if ($month == 01 && $day == 01) {
      $year = $year - 1;
   }

   //если первое число, то в $day присваиваем последнее число предыдущего месяца, в $month - предыдущий месяц
   if ($day == 01) {
      $day = date("t", strtotime("-1 month"));
      $month = date("m", strtotime("-1 month"));
   }

   if ($branchid !== null) {
      if ($dostavka_id !== null) {//доставка
         $query_report = mysqli_fetch_assoc(mysqli_query($GLOBALS['connection'], "SELECT {$query} AS 'data' FROM `orders` WHERE `date` >= '{$year}-{$month}-01 00:00:00' AND `date` < '{$year}-{$month}-{$day} 23:59:59' AND `customer_name`<>'Test' AND `dostavka_id` = {$dostavka_id} AND `branchid` = {$branchid} AND `sum_opt` > 0"));
      } else {//самовывоз
         $query_report = mysqli_fetch_assoc(mysqli_query($GLOBALS['connection'], "SELECT {$query} AS 'data' FROM `orders` WHERE `date` >= '{$year}-{$month}-01 00:00:00' AND `date` < '{$year}-{$month}-{$day} 23:59:59' AND `customer_name`<>'Test' AND `branchid` = {$branchid} AND `sum_opt` > 0"));
      }
   } else {//данные по всем аптекам
      if ($dostavka_id !== null) {
         $query_report = mysqli_fetch_assoc(mysqli_query($GLOBALS['connection'], "SELECT {$query} AS 'data' FROM `orders` WHERE `date` >= '{$year}-{$month}-01 00:00:00' AND `date` < '{$year}-{$month}-{$day} 23:59:59' AND `customer_name`<>'Test' AND `dostavka_id` = {$dostavka_id} AND `sum_opt` > 0"));
      } else {
         $query_report = mysqli_fetch_assoc(mysqli_query($GLOBALS['connection'], "SELECT {$query} AS 'data' FROM `orders` WHERE `date` >= '{$year}-{$month}-01 00:00:00' AND `date` < '{$year}-{$month}-{$day} 23:59:59' AND `customer_name`<>'Test' AND `sum_opt` > 0"));
      }
   }
   return $query_report['data'];
}


/**
 * Записать данные отчета в файл
 */

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('report_template_2.xlsx');
$worksheet = $spreadsheet->getActiveSheet();

//период отчета
$worksheet->getCell('D1')->setValue("01.{$month}.{$year} - {$day}.{$month}.{$year}");


//Просвещения 20/25
$worksheet->getCell('B5')->setValue(query_report('COUNT(*)', 9117));
$worksheet->getCell('B6')->setValue(query_report('COUNT(*)', 9117, 0));
$worksheet->getCell('C6')->setValue(query_report('COUNT(*)', 9117, 1));

$worksheet->getCell('D5')->setValue(query_report('SUM(total_sum)', 9117));
$worksheet->getCell('D6')->setValue(query_report('SUM(total_sum)', 9117, 0));
$worksheet->getCell('E6')->setValue(query_report('SUM(total_sum)', 9117, 1));

$worksheet->getCell('F5')->setValue(query_report('SUM(sum_opt)', 9117));
$worksheet->getCell('F6')->setValue(query_report('SUM(sum_opt)', 9117, 0));
$worksheet->getCell('G6')->setValue(query_report('SUM(sum_opt)', 9117, 1));


//Просвещения 24
$worksheet->getCell('B7')->setValue(query_report('COUNT(*)', 16606));
$worksheet->getCell('B8')->setValue(query_report('COUNT(*)', 16606, 0));
$worksheet->getCell('C8')->setValue(query_report('COUNT(*)', 16606, 1));

$worksheet->getCell('D7')->setValue(query_report('SUM(total_sum)', 16606));
$worksheet->getCell('D8')->setValue(query_report('SUM(total_sum)', 16606, 0));
$worksheet->getCell('E8')->setValue(query_report('SUM(total_sum)', 16606, 1));

$worksheet->getCell('F7')->setValue(query_report('SUM(sum_opt)', 16606));
$worksheet->getCell('F8')->setValue(query_report('SUM(sum_opt)', 16606, 0));
$worksheet->getCell('G8')->setValue(query_report('SUM(sum_opt)', 16606, 1));


//Композиторов 22
$worksheet->getCell('B9')->setValue(query_report('COUNT(*)', 11263));
$worksheet->getCell('B10')->setValue(query_report('COUNT(*)', 11263, 0));
$worksheet->getCell('C10')->setValue(query_report('COUNT(*)', 11263, 1));

$worksheet->getCell('D9')->setValue(query_report('SUM(total_sum)', 11263));
$worksheet->getCell('D10')->setValue(query_report('SUM(total_sum)', 11263, 0));
$worksheet->getCell('E10')->setValue(query_report('SUM(total_sum)', 11263, 1));

$worksheet->getCell('F9')->setValue(query_report('SUM(sum_opt)', 11263));
$worksheet->getCell('F10')->setValue(query_report('SUM(sum_opt)', 11263, 0));
$worksheet->getCell('G10')->setValue(query_report('SUM(sum_opt)', 11263, 1));


//Луначарского 72
$worksheet->getCell('B11')->setValue(query_report('COUNT(*)', 9758));
$worksheet->getCell('B12')->setValue(query_report('COUNT(*)', 9758, 0));
$worksheet->getCell('C12')->setValue(query_report('COUNT(*)', 9758, 1));

$worksheet->getCell('D11')->setValue(query_report('SUM(total_sum)', 9758));
$worksheet->getCell('D12')->setValue(query_report('SUM(total_sum)', 9758, 0));
$worksheet->getCell('E12')->setValue(query_report('SUM(total_sum)', 9758, 1));

$worksheet->getCell('F11')->setValue(query_report('SUM(sum_opt)', 9758));
$worksheet->getCell('F12')->setValue(query_report('SUM(sum_opt)', 9758, 0));
$worksheet->getCell('G12')->setValue(query_report('SUM(sum_opt)', 9758, 1));


//Луначарского 62
$worksheet->getCell('B13')->setValue(query_report('COUNT(*)', 9208));
$worksheet->getCell('B14')->setValue(query_report('COUNT(*)', 9208, 0));
$worksheet->getCell('C14')->setValue(query_report('COUNT(*)', 9208, 1));

$worksheet->getCell('D13')->setValue(query_report('SUM(total_sum)', 9208));
$worksheet->getCell('D14')->setValue(query_report('SUM(total_sum)', 9208, 0));
$worksheet->getCell('E14')->setValue(query_report('SUM(total_sum)', 9208, 1));

$worksheet->getCell('F13')->setValue(query_report('SUM(sum_opt)', 9208));
$worksheet->getCell('F14')->setValue(query_report('SUM(sum_opt)', 9208, 0));
$worksheet->getCell('G14')->setValue(query_report('SUM(sum_opt)', 9208, 1));


//Всего
$worksheet->getCell('B15')->setValue(query_report('COUNT(*)', null));
$worksheet->getCell('B16')->setValue(query_report('COUNT(*)', null, 0));
$worksheet->getCell('C16')->setValue(query_report('COUNT(*)', null, 1));

$worksheet->getCell('D15')->setValue(query_report('SUM(total_sum)', null));
$worksheet->getCell('D16')->setValue(query_report('SUM(total_sum)', null, 0));
$worksheet->getCell('E16')->setValue(query_report('SUM(total_sum)', null, 1));

$worksheet->getCell('F15')->setValue(query_report('SUM(sum_opt)', null));
$worksheet->getCell('F16')->setValue(query_report('SUM(sum_opt)', null, 0));
$worksheet->getCell('G16')->setValue(query_report('SUM(sum_opt)', null, 1));

//Создать и сохранить файл xls
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save("site_report_{$month}_{$year}.xls");


//отправить письмо с отчетом
$mail = new PHPMailer();
$mail->CharSet = "utf-8";
$mail->setFrom('report@aptekaneboleyka.ru', '=?UTF-8?B?' . base64_encode("Отчет по сайту") . '?=');
$mail->addAddress('iva2742@mail.ru');
$mail->addAddress('aneboleyka@mail.ru'); //если так слать на два адреса, то оба видят друг друга
$mail->Subject = "период: 01.{$month}.{$year} - {$day}.{$month}.{$year}";
$mail->msgHTML(" "); //текст в письме
$mail->addAttachment("site_report_{$month}_{$year}.xls"); //вложение
$mail->send();