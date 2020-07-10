<?php
session_start();
$_SESSION['idUser'] = NULL;
$_SESSION['name'] = NULL;
header('Location: /');
?>