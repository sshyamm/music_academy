<?php 

$db_user     = "phpmyadmin";
$db_password = "root";
$db_name     = "music_academy";

$db = new PDO('mysql:host=127.0.0.1;dbname=' . $db_name . ';charset=utf8' , $db_user , $db_password);

//set some db attributes

$db->setAttribute(PDO::ATTR_EMULATE_PREPARES , false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY , true);
$db->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);

define('URL', 'http://localhost/music_academy');
?>