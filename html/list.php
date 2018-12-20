<!doctype html>
<head>
 <meta charset="UTF-8">
 <link rel="icon" type="image/png" href="img/favicon.ico" />
 <title>Список - Uderon</title>
</head>
<body>
<?php
    $connect = new mysqli("localhost", "pidor", "password", "piddb" );
    $connect->query("SET NAMES 'utf8' ");

    $users = $connect->query("SELECT * FROM pidwart");
    echo "<p>Всего пользователей в базе: ".$users->num_rows."</p>";
    $num = 0;
    //засовываем все записи в ассоциативный массив и перебираем их
    while(($row = $users->fetch_assoc()) != FALSE){
        $num++;
        //выводим список на экран
        echo "<p>".$num.") ".$row['FirstName']." ".$row['LastName']."</p>";
    }
    $connect->close();
?>
</body>
</html>
