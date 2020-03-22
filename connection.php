<?php
$host = 'localhost';
$database = 'queries';
$user = 'mysql';
$password = 'mysql';
$link = mysqli_connect($host,$user,$password,$database) or die("Ошибка " . mysqli_error($link));
?>