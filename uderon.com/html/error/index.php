<?php $err = in_array($_SERVER['QUERY_STRING'], array('403', '404', '500')) ? $_SERVER['QUERY_STRING'] : '404'; ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset='UTF-8'>
    <meta name="description" content="База данных пидарков">
    <title>Ошибка <?= htmlspecialchars($err); ?> — Uderon</title>
    <link rel='stylesheet' type='text/css' href='/styles/style.css?v=1.41' />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <div id="content">
      <div id="header">
        <h2>Ошибка <?= htmlspecialchars($err); ?>. Похоже вы пидарок. <a href="/">Добавьте себя в базу</a></h2>
      </div>
    </div>
  </body>
</html>
