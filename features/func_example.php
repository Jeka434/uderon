<?php
//Подключаемся к БД Хост, Имя пользователя MySQL, его пароль, имя нашей базы
$connect = new mysqli("localhost", "bdAdmin", "bdpass", "users" );

//Кодировка данных получаемых из базы
$connect->query("SET NAMES 'utf8' ");

$sysMessages = "Нет системных сообщений";

// --------------------------------- Добавление пользователей
//Функция добавления пользователей
function addUser($fname, $lname, $age, $connect)
{
    $add = $connect->query("INSERT INTO users.user (id, fname, lname, age) VALUES  (NULL, '$fname', '$lname', $age)");
    if($add){$GLOBALS['sysMessages'] = "Добавлен новый пользователь"; } else{ $GLOBALS['sysMessages'] = "Ошибка добавления";}
}

//Если было добавление пользователя, то занести все данные в базу
if($_POST['add'])
{
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $age = $_POST['age'];
    addUser($fname, $lname, $age, $connect);
}
// --------------------------------- Вывод информации и удаление

function userList($connect)
{
    $users = $connect->query("SELECT * FROM user");
    echo "<p>Всего пользователей в базе: ".$users->num_rows."</p>";
    $num = 0;
    //засовываем все записи в ассоциативный массив и перебираем их
    while(($row = $users->fetch_assoc()) != FALSE){
        $num++;
        $id = $row['id'];
        //выводим список на экран
        echo "<p>".$num.") Имя: ".$row['fname']." Фамилия: ".$row['lname']." Возраст: ".$row['age']."</p>";

        //кнопка удаления пользователя
        echo '
              <form method="get">
                <input type="hidden" name="id" value="'.$id.'">
                <input type="submit" name="del" value="Удалить пользователя" >
              </form>
        ';
    }
}

// отслеживаем нажатие кнопки удаления и удалаем пользователя по id
if($_GET['del']){
    $id = $_GET['id'];
    $del = $connect->query("DELETE FROM user WHERE id = $id");
    if($del){
        $GLOBALS['sysMessages'] = "Пользователь удален. <a href='/'>Обновить Страницу</a>";
    }else{
        $GLOBALS['sysMessages'] = " Ошибка удаления";
    }
}
//вывод системных сообщений
echo "<p style='color: darkgreen; font-size: 18px;'>".$sysMessages."</p>" ;
?>
