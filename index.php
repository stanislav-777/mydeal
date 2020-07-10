<?php
include_once ("./helpers.php");
require_once 'connection.php';

//двумерный массив задач

//текущий пользователь  тут определить авторизированного пользователя 
$idUser = intval($_SESSION['idUser']);
$idProject = 0;
if(isset($_GET['id'])){
    $idProject = intval($_GET['id']);
}   
$masProject  = getProjects($idUser);
if (isset($_GET['btn_search'])){
    $data = array();
    $data['text_search'] = isset($_GET['text_search']) ? $_GET['text_search'] : '';
    if(!empty($data['text_search'])){
        $data['text_search'] = trim($data['text_search']);
        $masTask = getSearchTasks($idUser,$data['text_search']);
    }
    else{
        $masTask = getTasks($idUser,$idProject);
    }
}
else{
    $masTask = getTasks($idUser,$idProject);
}

if($idProject != 0){

if (!issetProject($idUser,$idProject)){
    exit(header('Location: /error404/'));
}
}
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
if ($idUser == 0){ 
    $page_content = include_template('guest.php', array());
}
else {
$page_content = include_template('main.php', [
    'idProject'=>$idProject,
    'show_complete_tasks'=>$show_complete_tasks,
    'masTask' => $masTask,
    'masProject' => $masProject
    ]);
}
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Мои дела']);
print($layout_content);
mysqli_close($link);
?>
