<?php
include_once ("./helpers.php");
require_once 'connection.php';

if(isset($_POST['btn_reg'])){
    $data = array();
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
    $data['name'] = isset($_POST['name']) ? $_POST['name'] : '';
    $bool1 = empty($data['email']);
    if ($bool1){
        $errorText1 = 'Zapolnite4 email';
    }
    else{
        if (!(filter_var($data['email'], FILTER_VALIDATE_EMAIL))){
            $errorText1 = 'Email not valid';
            $bool1 = true;
        }
        else{
            if(getUserByEmail($data['email']) !== NULL){
                $bool1 = true;
                $errorText1 = 'Takou email syzh';
            }
        }
    }
    $bool2 = empty($data['password']);
    if ($bool2){
        $errorText2 = 'Zapolnite4 pass';
    }
    $bool3 = empty($data['name']);
    if ($bool3){
        $errorText3 = 'Zapolnite4 name';
    }
    $bool =  !$bool1 && !$bool2 && !$bool3;
    if ($bool){
        if(addUser($data['email'],$data['password'],$data['name'])){
            header('Location: /');
        }
    }
}


$page_content = include_template('register.php', [
    'errorText1'=>$errorText1,
    'errorText2'=>$errorText2,
    'errorText3'=>$errorText3,
    'validation'=>$bool
    ]);
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Регистрация']);
print($layout_content);
mysqli_close($link);
?>