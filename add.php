<?php
include_once ("./helpers.php");
require_once 'connection.php';

$idUser = intval($_SESSION['idUser']);
if (isset($_POST['submit_task'])){
    $data = array();
    $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
    $data['project'] = isset($_POST['project']) ? intval($_POST['project']) : '';
    $data['date'] = isset($_POST['date']) ? $_POST['date'] : '';
    $data['file'] = isset($_POST['file']) ? $_POST['file'] : '';
    $bool1 = is_date_valid($data['date']);
    if (!$bool1) {
        $errorText1 = 'Дата должна быть в формате год-месяц-день'; 
    }
    //беды с датой
    $bool2 = !(time()<=strtotime($data['date']));
    if ($bool2) {
        $errorText2 = 'дата не прошедее';
    }
    $bool3 = (issetProject($idUser,$data['project']));
    if (!$bool3) {
        $errorText3 = 'Неккоректный ввод названия проекта'; 
    }
    $bool4 = !($data['name']!=='');
    if ($bool4) {
        $errorText4 = 'Введите название задачи';
    }
    $bool =  $bool1 && !$bool2 && $bool3 && !$bool4;
    if ($bool){
        $tmp = time();
        //разобратсья со слешем
        $uploaddir = 'C:/Users/stani/Downloads/OSPanel/domains/mydeal/files/';
        $uploadfile = $uploaddir . $tmp.basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
        if (addTask($idUser,$data['project'],$data['name'],$uploadfile,$data['date'])){
            header('Location: /');
        }
    }
    // else{
    //     echo 'error';
    // }
}



$page_content = include_template('form-task.php', [
    'masProject'=>getProjects($idUser),
    'errorText1'=>$errorText1,
    'errorText2'=>$errorText2,
    'errorText3'=>$errorText3,
    'errorText4'=>$errorText4,
    'validation'=>$bool
    ]);
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Добавление задачи']);
print($layout_content);
mysqli_close($link);
?>