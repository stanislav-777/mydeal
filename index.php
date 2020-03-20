<?php
include_once ("./helpers.php");
require_once 'connection.php';


//массив проектов
$masProject = array(); 
//двумерный массив задач
$masTask = array();
//текущий пользователь  тут определить авторизированного пользователя 
$idUser = 1;

$link = mysqli_connect($host,$user,$password,$database) or die("Ошибка " . mysqli_error($link));

$query = mysqli_query($link, "SELECT * FROM `project` WHERE idUser=".$idUser) or die("Ошибка " . mysqli_error($link)); 
        while ($result = mysqli_fetch_array($query)) {
            if ((int)$result['idUser'] === $idUser){
                $masProject[] = array(
                    'name' => $result['nameProject'],
                    'number'=>numberOfTasks($result['idProject'],$idUser),
                    'href' => '?id='.$result['idProject'],
                    'id' => $result['idProject']
                );
            }
        }
$idProject = 0;         
if(isset($_GET['id'])){
    $idProject = intval($_GET['id']);
}
if($idProject != 0){
$query  = mysqli_query($link,"SELECT COUNT(*) FROM project WHERE idUser='".$idUser."' AND idProject='".$idProject."'") or die("Ошибка " . mysqli_error($link)); 
$result = mysqli_fetch_array($query);
if ($result['COUNT(*)'] == 0){
    exit(header('Location: /error404/'));
}
}
if ($idProject == 0){
    $query = mysqli_query($link,"SELECT * FROM `tasks` WHERE idUser=".$idUser) or die("Ошибка " . mysqli_error($link));
} 
else{
    $query = mysqli_query($link,"SELECT * FROM `tasks` WHERE idProject=".$idProject." AND idUser=".$idUser) or die("Ошибка " . mysqli_error($link)); 
}             
while ($data = mysqli_fetch_array($query)) {
    $masTask[] = array(
    'idUser' => $data['idUser'],
    'idProject' => $data['idProject'],
    'dateStart' => $data['dateStart'],
    'statusTask' => $data['statusTask'],
    'nameTask' => $data['nameTask'],
    'fileTask' => $data['fileTask'],
    'deadline' => $data['deadline']
    );
}


     

//Статический id для КОнстантина


// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);


function numberOfTasks($idProject,$idUser){
    GLOBAL $link;
    $query = mysqli_query($link, "SELECT COUNT(*) FROM tasks WHERE idUser='".$idUser."' AND idProject='".$idProject."'") or die("Ошибка " . mysqli_error($link)); 
    $result = mysqli_fetch_array($query);
    return $result['COUNT(*)'];
}


$items_list = [];
$page_content = include_template('main.php', ['idProject'=>$idProject,'items' => $items_list,'show_complete_tasks'=>$show_complete_tasks,'masTask' => $masTask,'masProject' => $masProject]);
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Мои дела']);
print($layout_content);
mysqli_close($link);
?>
