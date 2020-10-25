<?php
define("CATALOG", TRUE);
ini_set('display_errors', 1); //для ошибок
error_reporting(E_ALL);
require_once '../config.php';
require_once '003ms_functions.php';

write_txt_file();
zip_file(); //заархивировать
send_mail_to_003();//отправить письмо в 003ms
