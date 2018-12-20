<?php

$connect = new mysqli("localhost", "pidor", "password", "piddb" );

$connect->query("SET NAMES 'utf8' ");

$sysMessages = "None";

function addUser($fname, $lname, $connect)
{
    $user = $connect->query("SELECT * FROM piddb.pidwart AS pid GROUP BY pid.FirstName, pid.LastName HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    if(!$user || ($row = $user->fetch_assoc()) == FALSE){
        $add = $connect->query("INSERT INTO piddb.pidwart (FirstName, LastName) VALUES  ('$fname', '$lname')");
        if($add){
            $GLOBALS['sysMessages'] = "Пользователь добавлен. <a href='/'>Обновить Страницу</a>";
        }else{
            $GLOBALS['sysMessages'] = "Ошибка добавления";
        }
    }
}

if($_POST['add'])
{
    $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['fname']));
    $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['lname']));
    addUser($fname, $lname, $connect);
}

function pidCheck($fname, $lname, $connect)
{
    $user = $connect->query("SELECT * FROM piddb.pidwart AS pid GROUP BY pid.FirstName, pid.LastName HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    echo "<p>Имя: <b>".$fname."</b></p>
          <p>Фамилия: <b>".$lname."</b></p>
          <p>Ориентация: <b>";
    if(!$user || ($row = $user->fetch_assoc()) == FALSE){
        echo 'НАТУРАЛ</b></p>
          <form method="post">
            <input type="hidden" name="fname" value="'.$fname.'">
            <input type="hidden" name="lname" value="'.$lname.'">
            <input type="submit" name="add" value="Добавить в базу" >
          </form>
        ';
    }else{
        //кнопка удаления пользователя
        echo 'ПИДАРАС</b></p>
          <form method="post">
            <input type="hidden" name="id" value="'.$row['ID'].'">
            <input type="submit" name="del" value="Удалить пользователя" >
          </form>
        ';
    }
}

if($_POST['pidcheck']){
    $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['fname']));
    $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['lname']));
    pidCheck($fname, $lname, $connect);
}

if($_POST['del']){
    $id = htmlspecialchars(mysqli_escape_string($connect, $_POST['id']));
    $del = $connect->query("DELETE FROM pidwart WHERE ID = $id");
    if($del){
        $GLOBALS['sysMessages'] = "Пользователь удален. <a href='/'>Обновить Страницу</a>";
    }else{
        $GLOBALS['sysMessages'] = " Ошибка удаления";
    }
}

function userList($connect)
{
    $users = $connect->query("SELECT * FROM pidwart");
    echo "<p>Всего пользователей в базе: ".$users->num_rows."</p>";
    $num = 0;
    //засовываем все записи в ассоциативный массив и перебираем их
    while(($row = $users->fetch_assoc()) != FALSE){
        $num++;
        //выводим список на экран
        echo "<p>".$num.") ".$row['FirstName']." ".$row['LastName']."</p>";
    }
}

if (!($sysMessages === "None")) {
    echo "<p style='color: darkgreen; font-size: 18px;'>".$sysMessages."</p>" ;
}
?>
