<?php
defined("CATALOG") or die("Access denied");

/**
 * Подключение к БД
 */

define("DBHOST", "localhost");

define("DBUSER", "root");
define("DBPASS", "root");
define("DB", "apteka");//price_test
define("PATH", "http://aptekanew2.loc/");

//define("DBUSER", "aneboltw_apt");
//define("DBPASS", "Apt2025");//A!1234567
//define("DB", "aneboltw_apt");
//define("PATH", "http://aptekaneboleyka.ru/");



//define("PATH", "http://aptekaneboleyka.ru/");

//define('ADMIN_EMAIL', 'iva2742@mail.ru');
define('ADMIN_EMAIL', 'info@aptekaneboleyka.ru');
//define('ADMIN_EMAIL', 'admin@test.aneboltw.beget.tech');

define("PERPAGE", 10);

/*$connection = @mysqli_connect(DBHOST, DBUSER, DBPASS, DB) or die("Нет соединения с БД");
mysqli_report(MYSQLI_REPORT_ERROR);
mysqli_set_charset($connection, "utf8") or die("Не установлена кодировка соединения");*/


$connection = @mysqli_connect(DBHOST, DBUSER, DBPASS, DB) or die("Нет соединения с БД");
mysqli_report(MYSQLI_REPORT_ERROR);
//$connection->options('MYSQLI_OPT_CONNECT_TIMEOUT', 28880);
mysqli_set_charset($connection, "utf8") or die("Не установлена кодировка соединения");
mysqli_query($connection, 'set session wait_timeout=28800');



/*$connection = mysqli_init();
mysqli_options($connection, MYSQLI_OPT_CONNECT_TIMEOUT, 28800);
mysqli_real_connect($connection, DBHOST, DBUSER, DBPASS, DB);
mysqli_query($connection, 'set session wait_timeout=28800');*/


/*//create the object
$connection = mysqli_init();
//specify the connection timeout
$connection->options(MYSQLI_OPT_CONNECT_TIMEOUT, 28880);
//specify the read timeout
$connection->options(MYSQLI_OPT_READ_TIMEOUT, 10);
//initiate the connection to the server, using both previously specified timeouts
$connection->real_connect('DBHOST', 'DBUSER', 'DBPASS', 'DB');*/

# Здесь будут cron jobs
//переподключиться
//if( !mysqli_ping($connection) ) $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DB);