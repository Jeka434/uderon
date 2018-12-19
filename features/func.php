<?php

$connect = new mysqli("localhost", "pidor", "password", "piddb" );

$connect->query("SET NAMES 'utf8' ");

$sysMessages = "None";

function addUser($fname, $lname, $connect)
{
    $user = $connect->query("SELECT * FROM piddb.toadd AS pid GROUP BY pid.FirstName, pid.LastName HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    if(($row = $user->fetch_assoc()) == FALSE){
        $add = $connect->query("INSERT INTO piddb.toadd (FirstName, LastName) VALUES  ('$fname', '$lname')");
        if($add){$GLOBALS['sysMessages'] = "Заявка на добавление будет рассмотренна"; } else{ $GLOBALS['sysMessages'] = "Ошибка добавления";}
    }else{
        $GLOBALS['sysMessages'] = "Заявка на добавление этого пользователя уже была отправлена. Ждите";
    }
}

if($_POST['add'])
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    addUser($fname, $lname, $connect);
    echo $_POST['del'];
}

function pidCheck($fname, $lname, $connect)
{
    $user = $connect->query("SELECT * FROM piddb.pidors AS pid GROUP BY pid.FirstName, pid.LastName HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    if(($row = $user->fetch_assoc()) == FALSE){
        echo '<p>Пользователь <b>'.$lname.' '.$fname.'</b> не найден. Хотите его добавить?</p>';
        echo '
        <form method="post">
            <input type="hidden" name="fname" value="'.$fname.'">
            <input type="hidden" name="lname" value="'.$lname.'">
            <input type="submit" name="add" value="Добавить в базу" >
        </form>
        ';
    }else{
        echo "<p>Имя: <b>".$fname."</b></p>
              <p>Фамилия: <b>".$lname."</b></p>
              <p>Род деятельности: <b>ПИДАРАС</b></p>";
        //кнопка удаления пользователя
        echo '
              <form method="post">
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

if($_POST['del']){
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

if (!($sysMessages === "None")) {
    echo "<p style='color: darkgreen; font-size: 18px;'>".$sysMessages."</p>" ;
}
?>
