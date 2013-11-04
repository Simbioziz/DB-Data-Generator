<?php
error_reporting(E_ALL);
define("DB_HOST", "localhost"); //Сервер БД
define("DB_LOGIN", "root"); //Имя пользователя
define("DB_PASSWORD", ""); //Пароль пользователя
define("DB_NAME", ""); //База данных

if(!mysql_connect(DB_HOST, DB_LOGIN, DB_PASSWORD)) { exit ('Ошибка подключения к серверу БД');}
if(!mysql_select_db(DB_NAME)){ exit('Ошибка подключения к базе' .DB_NAME .' !');}
mysql_query('SET NAMES CP1251');
$i = 0;
?>
