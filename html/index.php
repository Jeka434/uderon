<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>База пидарков - Uderon</title>
    <link rel="icon" type="image/png" href="img/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="css/mainstyle.css" />
  </head>
  <body>
    <div class="mainBody">
      <div class="head">
        <h2>Проверить пользователя</h2>
        <form class="mainForm" method="post">
          <label>Имя: <input type="text" name="fname"></label>
          <label>Фамилия: <input type="text" name="lname"></label>
          <input type="submit" name="pidcheck" value="Проверить">
        </form>
      </div>
      <?php include("func.php");?>
    </div>
  </body>
</html>
