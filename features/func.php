<?php

$connect = new mysqli("localhost", "pidar", "password", "piddb" );

$connect->query("SET NAMES 'utf8' ");

$sysMessages = "Нет системных сообщений";

function addUser($fname, $lname, $connect)
{
    $add = $connect->query("INSERT INTO piddb.toadd (firstname, lastname) VALUES  ('$fname', '$lname')");
    if($add){$GLOBALS['sysMessages'] = "Добавлен новый пользователь"; } else{ $GLOBALS['sysMessages'] = "Ошибка добавления";}
}

if($_POST['add'])
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    addUser($fname, $lname, $connect);
}

function pidCheck($fname, $lname, $connect)
{
    $num = $connect->query("SELECT COUNT(*) FROM piddb.pidors AS pid GROUP BY pid.firstname, pid.lastname HAVING pid.firstname=$fname, pid.lastname=$lname");
    if($num == 0){
        echo 'Скорее всего данный пользователь - натурал. Хотите его добавить?';
        echo '
        <form method="post">
            <input type="submit" name="add" value="Добавить в базу" >
        </form>
        ';
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

if($_POST['pidcheck']){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    pidCheck($fname, $lname, $connect);
}

if($_GET['del']){
    $GLOBALS['sysMessages'] = "Ваше мнение очень важно для нас!";
}

echo "<p style='color: darkgreen; font-size: 18px;'>".$sysMessages."</p>" ;
?>
