<?php include_once ("func_examle.php");?>
<!doctype html>
<head>
 <meta charset="UTF-8">
 <title>Пользователи</title>
</head>
<body>
<h2>Добавить пользователя </h2>
<form method="post">
 <label>Имя</label>
 <input type="text" name="fname">
 <label>Фамилия</label>
 <input type="text" name="lname">
 <label>Возраст</label>
 <input type="number" name="age">
 <input type="submit" name="add" value="Добавить в базу" >
 <?php userList($connect);?>
 <?php
 //закрываем соединение с БД
 $connect->close();
 ?>
</form>
</body>
</html>