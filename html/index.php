<!DOCTYPE html>
<html lang="ru">
<head>
 <meta charset="UTF-8">
 <link rel="icon" type="image/png" href="img/favicon.ico" />
 <link rel="stylesheet" type="text/css" href="css/mainstyle.css" />
 <title>База пидарков - Uderon</title>
</head>
<body>
  <div class="mainBody">
    <div class="head">
      <h2>Проверить пользователя</h2>
      <form class="mainForm" method="post">
        <label>Имя</label>
        <input type="text" name="fname">
        <label>Фамилия</label>
        <input type="text" name="lname">
        <input type="submit" name="pidcheck" value="Проверить">
      </form>
    </div>
    <?php include_once ("func.php");?>
  </div>
</body>
</html>
