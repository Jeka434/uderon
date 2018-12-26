<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset='UTF-8'>
    <meta name="description" content="База данных пидарков">
    <title>Ошибка <?= htmlspecialchars($_SERVER['QUERY_STRING']); ?> — Uderon</title>
    <link rel='stylesheet' type='text/css' href='/styles/style.css?v=1.4' />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <div id="content">
      <div id="header">
        <h2><?= htmlspecialchars($_SERVER['QUERY_STRING']); ?>. Похоже вы пидарок. <a href="/">Добавьте себя в базу</a></h2>
      </div>
    </div>
  </body>
</html>
