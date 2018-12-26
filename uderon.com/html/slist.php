<?php include_once 'liststart.php'; ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset='UTF-8'>
    <meta name="description" content="База данных пидарков">
    <title>Простой список — Uderon</title>
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
      <p><?= $num; ?>) <?= $row['LastName']; ?> <?= $row['FirstName']; ?></p>
<?php
}
$connect->close();
?>
    </div>
  </body>
</html>
