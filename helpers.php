<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);
    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}


/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function numberOfTasks($idUser,$idProject) {
    GLOBAL $link;
    $query = mysqli_query($link, "SELECT COUNT(*) FROM tasks WHERE idUser='".$idUser."' AND idProject='".$idProject."'") or die("Ошибка " . mysqli_error($link)); 
    $result = mysqli_fetch_array($query);
    return $result['COUNT(*)'];
}

function getProjects($idUser) {
    GLOBAL $link;
    $masProject = array(); 
    $query = mysqli_query($link, "SELECT * FROM `project` WHERE idUser=".$idUser) or die("Ошибка " . mysqli_error($link)); 
        while ($result = mysqli_fetch_array($query)) {
            if ((int)$result['idUser'] === $idUser){
                $masProject[] = array(
                    'name' => $result['nameProject'],
                    'number'=>numberOfTasks($idUser,$result['idProject']),
                    'href' => '?id='.$result['idProject'],
                    'id' => $result['idProject']
                );
            }
        }
return $masProject;
}

function getTasks($idUser,$idProject) {
    GLOBAL $link;
    $masTask = array();
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
    return $masTask;
}

function issetProject($idUser,$idProject){
    GLOBAL $link;
    $query  = mysqli_query($link,"SELECT COUNT(*) FROM project WHERE idUser=".$idUser." AND idProject=".$idProject) or die("Ошибка " . mysqli_error($link)); 
    $result = mysqli_fetch_array($query);
    return ($result['COUNT(*)']!=0);
}
function addTask($idUser,$idProject,$nameTask,$fileTask,$deadline){
    GLOBAL $link;
    $dateStart = date('Y-m-d',time());
    $status = 0;
    $query = mysqli_query($link,"INSERT INTO tasks(idUser,idProject,dateStart,statusTask,nameTask,fileTask,deadline) VALUES('$idUser','$idProject','$dateStart','$status','$nameTask','$fileTask','$deadline')");
    return mysqli_insert_id($link);
}

function getUserByEmail($email){
    GLOBAL $link;
    $query = mysqli_query($link,"SELECT idUser From users WHERE email='".$email."'");
    $result = mysqli_fetch_array($query);
    return $result['idUser'];
}

function addUser($email,$pass,$name){
    GLOBAL $link;
    $query = mysqli_query($link,'SELECT idUser FROM users ORDER BY idUser DESC LIMIT 1');
    $result = mysqli_fetch_array($query);
    $idUser = $result['idUser']+1;
    $dateReg = date('Y-m-d H:i:s',time());
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    $query = mysqli_query($link,"INSERT INTO users(idUser, dateRegistration, email,nameUser, pass) VALUES('$idUser','$dateReg','$email','$name','$pass')");
    return mysqli_insert_id($link);
}