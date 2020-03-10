<?php
include_once ("./helpers.php");
require_once 'connection.php';


//массив проектов
$masProject = array(); 
//двумерный массив задач
$masTask = array();
$idUser = 1;

$link = mysqli_connect($host,$user,$password,$database) or die("Ошибка " . mysqli_error($link));

$query = mysqli_query($link, "SELECT `idProject`, `idUser`, `nameProject` FROM `project`") or die("Ошибка " . mysqli_error($link)); 
        while ($result = mysqli_fetch_array($query)) {
            if ((int)$result['idUser'] === $idUser){
            array_push($masProject, $result['nameProject']);
            }
        }
$query = mysqli_query($link,"SELECT `idUser`,`idProject`, `dateStart`, `statusTask`,`nameTask`,`fileTask`,`deadline` FROM `tasks`") or die("Ошибка " . mysqli_error($link));       
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


function numberOfTasks($arr,$nameProject){
    GLOBAL $link;
    $query = mysqli_query($link, "SELECT `idProject`, `idUser`, `nameProject` FROM `project`") or die("Ошибка " . mysqli_error($link)); 
    $count = 0;
    while ($result = mysqli_fetch_array($query)) {
        if ($result['nameProject'] === $nameProject){
            for($i=0;$i<count($arr);$i++){
                if ($arr[$i]['idProject'] == $result['idProject']){
                $count++;
                }
            }
        }
    }

return $count;
}


$items_list = [];
$page_content = include_template('main.php', ['items' => $items_list,'show_complete_tasks'=>$show_complete_tasks,'masTask' => $masTask,'masProject' => $masProject]);
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Мои дела']);
print($layout_content);
mysqli_close($link);
?>
