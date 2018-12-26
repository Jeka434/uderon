<?php include_once 'loginstart.php' ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset='UTF-8'>
    <meta name="description" content="База данных пидарков">
    <title>Вход — Uderon</title>
    <link rel='stylesheet' type='text/css' href='/styles/style.css?v=1.41' />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <div id="content">
      <div id="header">
        <h2 style="font-size: 16px;">
          <form action="/<?= $ret_name; ?>" method="post">
            <label>Пароль: <input type="password" name="password"></label>
            <input type="submit" name="access" value="Войти">
          </form>
        </h2>
      </div>
    </div>
  </body>
</html>
