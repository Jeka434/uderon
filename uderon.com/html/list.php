<?php $GLOBALS['ret_name'] = 'list.php'; include_once 'liststart.php' ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset='UTF-8'>
    <meta name="description" content="База данных пидарков">
    <title>Список — Uderon</title>
    <link rel='stylesheet' type='text/css' href='/styles/style.css?v=1.41' />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <div id="content">
      <div id='header'>
        <h2>Всего пидарков в базе: <b><?= $users->num_rows; ?></b></h2>
      </div>
<?php
$num = 0;
while (($row = $users->fetch_assoc()) != false) {
    $num++;
?>
      <div class='user_inf'>
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
              <form style='float: right; margin-right: 30%;' method='post'>
                <input type='hidden' name='id' value='<?= $row['ID']; ?>'>
                <input type='hidden' name='password' value='pidor'>
                <input type='submit' name='del' value='Удалить из базы'>
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
