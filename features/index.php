<?php include_once ("func.php");?>
<!doctype html>
<head>
 <meta charset="UTF-8">
 <link rel="icon" type="image/png" href="img/favicon.ico" />
 <title>Пользователи - Uderon</title>
</head>
<body>
<h2>Проверить пользователя</h2>
<form method="post">
 <label>Имя</label>
 <input type="text" name="fname">
 <label>Фамилия</label>
 <input type="text" name="lname">
 <input type="submit" name="pidcheck" value="Проверить" >
 <?php
 //закрываем соединение с БД
 $connect->close();
 ?>
</form>
</body>
</html>