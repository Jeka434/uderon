<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="img/favicon.ico" />
    <title>Список - Uderon</title>
  </head>
  <body>
    <?php
    $connect = new mysqli("localhost", "pidor", "password", "piddb");
    $connect->query("SET NAMES 'utf8'");

    $users = $connect->query("SELECT * FROM pidwart ORDER BY ID");
    echo "<p>Всего пользователей в базе: ", $users->num_rows, "</p>";
    $num = 0;
    while (($row = $users->fetch_assoc()) != FALSE) {
        $num++;
        echo "<p>", $num, ") ", $row['FirstName'], " ", $row['LastName'], "</p>";
    }
    $connect->close();
    ?>
  </body>
</html>
