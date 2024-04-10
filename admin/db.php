<?php
$servername = "localhost";
$username = "phpmyadmin";
$password = "root";
$dbname = "music_academy";

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
	die("Connection Failed: " . $conn->connect_error);
}
?>