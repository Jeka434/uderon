<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="img/favicon.ico" />
    <title>Список - Uderon</title>
    <style type="text/css">
      .prow {
        padding: 2px;
        font-size: 18px;
        border: 1px solid #ccc;
      }
      .s {
        margin-left: 30px;
      }
    </style>
  </head>
  <body>
    <?php
    $connect = new mysqli("localhost", "pidor", "password", "piddb");
    $connect->query("SET NAMES 'utf8'");

    $users = $connect->query("SELECT * FROM pidwart ORDER BY ID");
    echo "<p>Всего пользователей в базе: <b>", $users->num_rows, "</b></p>";
    $num = 0;
    while (($row = $users->fetch_assoc()) != FALSE) {
        $num++;
        echo "<div class='prow'>
                <span class='f'>", $num, ") ", $row['FirstName'], " ", $row['LastName'], "</span>
                <span class='s'>", $row['time'] ?? "NONE", "</span>
              </div>";
    }
    $connect->close();
    ?>
  </body>
</html>
