<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Ошибка <?= htmlspecialchars($_SERVER['QUERY_STRING']); ?> - Uderon</title>
    <link rel="icon" type="image/png" href="img/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="css/mainstyle.css" />
  </head>
  <body>
    <div class="mainBody">
      <div class="head">
        <h2><?= htmlspecialchars($_SERVER['QUERY_STRING']); ?>. Похоже вы пидарок</h2>
        <a href="/">Добавьте себя в базу</a>
      </div>
    </div>
  </body>
</html>
