<?php
include_once ("./helpers.php");
require_once 'connection.php';
if(isset($_POST['btn_aut'])){
    $data = array();
    $data['email'] = isset($_POST['email']) ? $_POST['email'] : '';
    $data['password'] = isset($_POST['password']) ? $_POST['password'] : '';
    $bool1 = empty($data['email']);
    if ($bool1){
        $errorText1 = 'Zapolnite4 email';
    }
    $bool2 = empty($data['password']);
    if ($bool2){
        $errorText2 = 'Zapolnite4 pass';
    }
    if (!$bool1 && !$bool2){
        $userId = getUserByEmail($data['email']);
        if ($userId == NULL) {
        $errorText1 = 'Такого юзера нет';
        $bool1 = true;
        }
        else{
            $query = mysqli_query($link,"SELECT pass, nameUser From users WHERE idUser='".$userId."'");
            $result = mysqli_fetch_array($query);
            $hash = $result['pass'];
            if (password_verify($data['password'], $hash) == false){
                $errorText2 = 'Пароль не правильный';
                $bool2 = true;
            }
        }
    }
    $bool =  !$bool1 && !$bool2;
    if ($bool){
        $_SESSION['idUser'] = $userId;
        $_SESSION['name'] = $result['nameUser'];
        header('Location: /');
    }
}

$page_content = include_template('auth.php', [
    'errorText1'=>$errorText1,
    'errorText2'=>$errorText2,
    'validation'=>$bool
    ]);
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Авторизация']);
print($layout_content);
mysqli_close($link);
?>