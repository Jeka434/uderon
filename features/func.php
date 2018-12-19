<?php

$connect = new mysqli("localhost", "pidor", "password", "piddb" );

$connect->query("SET NAMES 'utf8' ");

$sysMessages = "Нет системных сообщений";

function addUser($fname, $lname, $connect)
{
    $add = $connect->query("INSERT INTO piddb.toadd (FirstName, LastName) VALUES  ('$fname', '$lname')");
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
    $num = $connect->query("SELECT COUNT(*) FROM piddb.pidors AS pid GROUP BY pid.FirstName, pid.LastName HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    $str = $connect->query("SELECT TOP 1 pid.LastName FROM piddb.pidors AS pid GROUP BY pid.FirstName, pid.LastName HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    if($num == 0){
        echo 'Скорее всего данный пользователь - натурал. Хотите его добавить?';
        echo '
        <form method="post">
            <input type="submit" name="add" value="Добавить в базу" >
        </form>
        ';
    }else{
        echo $str;
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

function userList($connect)
{
    $users = $connect->query("SELECT * FROM pidors");
    echo "<p>Всего пользователей в базе: ".$users->num_rows."</p>";
    $num = 0;
    //засовываем все записи в ассоциативный массив и перебираем их
    while(($row = $users->fetch_assoc()) != FALSE){
        $num++;
        //выводим список на экран
        echo "<p>".$num.") ".$row['FirstName']." ".$row['LastName']."</p>";
    }
}

echo "<p style='color: darkgreen; font-size: 18px;'>".$sysMessages."</p>" ;
?>
