<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Список - Uderon</title>
    <link rel="stylesheet" type="text/css" href="/styles/mainstyle.css?v=1.1" />
  </head>
  <body>
<?php
$connect = new mysqli("localhost", "pidor", "password", "piddb");
$connect->query("SET NAMES 'utf8'");

$users = $connect->query("SELECT * FROM pidwart ORDER BY ID");
?>
    <div class='mainBody'>
      <div class='head'>
        <h2>Всего пидарков в базе: <b><?= $users->num_rows; ?></b></h2>
      </div>
<?php
$num = 0;
while (($row = $users->fetch_assoc()) != FALSE) {
  $num++;
?>
      <div class='userInf'>
        <div class='urow'>
          <div class='ulabel' style='font-size: 20px;'><?= $num; ?></div>
        </div>
        <div class='right_col'>
          <div class='urow'>
            <div class='ulabel'>ID:</div>
            <div class='ulabeled'><?= $row['ID']; ?></div>
          </div>
          <div class='urow'>
            <div class='ulabel'>Имя:</div>
            <div class='ulabeled'><?= $row['FirstName']; ?></div>
          </div>
          <div class='urow'>
            <div class='ulabel'>Фамилия:</div>
            <div class='ulabeled'><?= $row['LastName']; ?></div>
          </div>
          <div class='urow'>
            <div class='ulabel'>Добавлен:</div>
            <div class='ulabeled'><?= $row['time'] == '2012-12-21 00:00:00' ? 'НЕИЗВЕСТНО' : $row['time']; ?>
              <form style="float: right; margin-right: 30%;" action='/' method='post'>
                <input type='hidden' name='id' value='<?= $row['ID']; ?>'>
                <input type='submit' name='add' value='Удалить из базы'>
              </form>
            </div>
          </div>
        </div>
      </div>
<?php
}
$connect->close();
?>
    </div>
  </body>
</html>
