<?php
include_once ("./helpers.php");
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
//массив проектов
$masProject = array('Входящие','Учеба','Работа','Домашние дела','Авто'); 
//двумерный массив задач
$masTask = array(
    array( 'task' => 'Собеседование в IT компании', 'date' => '04.03.2019','cathegory' => 'Работа', 'done' => false),
    array( 'task' => 'Выполнить тестовое задание', 'date' => '03.03.2019','cathegory' => 'Работа', 'done' => false),
    array( 'task' => 'Сделать задание первого раздела', 'date' => '21.12.2020','cathegory' => 'Учеба', 'done' => true),
    array( 'task' => 'Встреча с другом', 'date' => '22.12.2020','cathegory' => 'Входящие', 'done' => false),
    array( 'task' => 'Купить корм для кота', 'date' => null,'cathegory' => 'Домашние дела', 'done' => false),
    array( 'task' => 'Заказать пиццу', 'date' => null,'cathegory' => 'Домашние дела', 'done' => false),
);

function numberOfTasks($arr,$nameProject){
    $count = 0;
for($i=0;$i<6;$i++){
    if ($arr[$i]['cathegory'] === $nameProject){
        $count++;
    }
}
return $count;
}


$items_list = [];
$page_content = include_template('main.php', ['items' => $items_list,'show_complete_tasks'=>$show_complete_tasks,'masTask' => $masTask,'masProject' => $masProject]);
$layout_content = include_template('layout.php',
['content' => $page_content, 'title' => 'Мои дела']);
print($layout_content);
?>
