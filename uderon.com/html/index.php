<?php include_once 'func.php' ?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset='UTF-8'>
    <meta name="description" content="База данных пидарков">
    <title>База пидарков — Uderon</title>
    <link rel='stylesheet' type='text/css' href='/styles/style.css?v=1.41' />
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <div id="content">
      <div id="header">
        <h2>Проверить пользователя</h2>
        <form id="main_form" method="post">
          <label>Имя: <input type="text" name="fname"></label>
          <label>Фамилия: <input type="text" name="lname"></label>
          <input type="submit" name="pidcheck" value="Проверить">
        </form>
      </div>
<?php main(); ?>
    </div>
  </body>
</html>
