<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Ошибка <?= htmlspecialchars($_SERVER['QUERY_STRING']); ?> - Uderon</title>
    <link rel="stylesheet" type="text/css" href="/styles/mainstyle.css?v=1.1" />
  </head>
  <body>
    <div class="mainBody">
      <div class="head">
        <h2><?= htmlspecialchars($_SERVER['QUERY_STRING']); ?>. Похоже вы пидарок. <a href="/">Добавьте себя в базу</a></h2>
      </div>
    </div>
  </body>
</html>
