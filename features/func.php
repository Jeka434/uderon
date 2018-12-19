<?php
//Подключаемся к БД Хост, Имя пользователя MySQL, его пароль, имя нашей базы
$connect = new mysqli("localhost", "pidar", "password", "piddb" );

//Кодировка данных получаемых из базы
$connect->query("SET NAMES 'utf8' ");

$sysMessages = "Нет системных сообщений";

// --------------------------------- Добавление пользователей
//Функция добавления пользователей
function addUser($fname, $lname, $connect)
{
    $add = $connect->query("INSERT INTO piddb.toadd (firstname, lastname) VALUES  ('$fname', '$lname')");
    if($add){$GLOBALS['sysMessages'] = "Добавлен новый пользователь"; } else{ $GLOBALS['sysMessages'] = "Ошибка добавления";}
}

if($_GET['pidcheck']){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];

    $num = $connect->query("SELECT COUNT(*) FROM piddb.pidors AS pid GROUP BY pid.firstname, pid.lastname HAVING pid.firstname=$fname, pid.lastname=$lname");
    if($num == 0){
        echo 'Скорее всего данный пользователь - натурал. Хотите его добавить?';
        echo '
        <form method="post">
            <input type="submit" name="add" value="Добавить в базу" >
        </form>
        '
        if($_POST['add'])
        {
            addUser($fname, $lname, $connect);
        }
    }else{
        echo "<p>"."Имя: ".$fname." Фамилия: ".$lname." Род деятельности: ПИДАРАС</p>";
        //кнопка удаления пользователя
        echo '
              <form method="get">
                <input type="submit" name="del" value="Удалить пользователя" >
              </form>
        '; 
    }
}

//Если было добавление пользователя, то занести все данные в базу

// отслеживаем нажатие кнопки удаления и удалаем пользователя по id
if($_GET['del']){
    $GLOBALS['sysMessages'] = "Ваше мнение очень важно для нас!";
}
//вывод системных сообщений
echo "<p style='color: darkgreen; font-size: 18px;'>".$sysMessages."</p>" ;
?>
