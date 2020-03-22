<?php
include_once ("./helpers.php");
require_once 'connection.php';

//двумерный массив задач

//текущий пользователь  тут определить авторизированного пользователя 
$idUser = 1;
$idProject = 0;
if(isset($_GET['id'])){
    $idProject = intval($_GET['id']);
}   
$masProject  = getProjects($idUser);
$masTask = getTasks($idUser,$idProject);
if($idProject != 0){

if (!issetProject($idUser,$idProject)){
    exit(header('Location: /error404/'));
}
}

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$page_content = include_template('main.php', [
    'idProject'=>$idProject,
    'show_complete_tasks'=>$show_complete_tasks,
    'masTask' => $masTask,
    'masProject' => $masProject
    ]);
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Мои дела']);
print($layout_content);
mysqli_close($link);
?>
