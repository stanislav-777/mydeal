<?php
include_once ("./helpers.php");
require_once 'connection.php';

$idUser = intval($_SESSION['idUser']);
if (isset($_POST['btn_add-project'])){
    $data = array();
    $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
    $bool = !($data['name']!=='');
    if ($bool) {
        $errorText = 'Введите название проекта';
    }
    else{
        $bool = issetProjectByName($idUser,$data['name']);
        if ($bool){
            $errorText = 'Такой проект уже есть';
        }
    }

    if (!$bool){
        if (addProject($idUser,$data['name'])){
            header('Location: /');
        }
    }
}



$page_content = include_template('addProject.php', [
    'masProject'=>getProjects($idUser),
    'errorText'=>$errorText,
    'validation'=>$bool
    ]);
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Добавление проекта']);
print($layout_content);
mysqli_close($link);
?>