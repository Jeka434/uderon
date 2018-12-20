<!doctype html>
<html lang="ru">
<head>
 <meta charset="UTF-8">
 <link rel="icon" type="image/png" href="img/favicon.ico" />
 <link rel="stylesheet" type="text/css" href="css/style.css" />
 <title>База пидарков - Uderon</title>
</head>
<body>
<h2>Проверить пользователя</h2>
<form method="post">
 <label>Имя</label>
 <input type="text" name="fname">
 <label>Фамилия</label>
 <input type="text" name="lname">
 <input type="submit" name="pidcheck" value="Проверить" >
 <?php include_once ("func.php");?>
 <?php $connect->close();?>
</form>
</body>
</html>
