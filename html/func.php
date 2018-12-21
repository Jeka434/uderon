<?php
$connect = new mysqli("localhost", "pidor", "password", "piddb");
$connect->query("SET NAMES 'utf8'");
$sysMessages = "OK";
$logType = "finelog";

function setLog(bool $value = TRUE) {
  if ($value) {
    $GLOBALS['logType'] = "errlog";
  } else {
    $GLOBALS['logType'] = "finelog";
  }
}

function checkstr($str) {
  if (empty($str)) {
    $GLOBALS['sysMessages'] = "Ошибка: Пустая строка.";
  } else if (iconv_strlen($str) > 37) {
    $GLOBALS['sysMessages'] = "Ошибка: Превышено максимальное количество символов.";
  } else if (!preg_match("/^[А-ЯЁа-яё]+$/u", $str)) {
    $GLOBALS['sysMessages'] = "Ошибка: Недопустимый ввод. Допускаются только русские буквы.";
  } else if (!preg_match("/^[А-ЯЁ][а-яё]+$/u", $str)) {
    $GLOBALS['sysMessages'] = "Ошибка: Недопустимый ввод. Имя и фамилия должны начинаться с большой буквы.";
  } else {
    return TRUE;
  }
  setLog();
  return FALSE;
}

function addUser($fname, $lname, $connect) {
  $user = $connect->query("SELECT *
                           FROM piddb.pidwart AS pid
                           GROUP BY pid.FirstName, pid.LastName
                           HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
  if (!$user || ($row = $user->fetch_assoc()) == FALSE) {
    $add = $connect->query("INSERT INTO piddb.pidwart (FirstName, LastName) VALUES  ('$fname', '$lname')");
    if ($add) {
      $GLOBALS['sysMessages'] = "Пользователь добавлен.";
    } else {
      setLog();
      $GLOBALS['sysMessages'] = "Ошибка добавления";
    }
  }
}

if (isset($_POST['add'])) {
  $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['_fname']));
  $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['_lname']));
  if (checkstr($fname) && checkstr($lname)) {
    addUser($fname, $lname, $connect);
  }
}

function pidCheck($fname, $lname, $connect) {
  $user = $connect->query("SELECT *
                           FROM piddb.pidwart AS pid
                           GROUP BY pid.FirstName, pid.LastName
                           HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
  echo "<div class='userInf'>
            <div class='urow'>
              <div class='ulabel'>Имя:</div>
              <div class='ulabeled'>".$fname."</div>
            </div>
            <div class='urow'>
              <div class='ulabel'>Фамилия:</div>
              <div class='ulabeled'>".$lname."</div>
            </div>
            <div class='urow'>
              <div class='ulabel'>Ориентация:</div>";
  if (!$user || ($row = $user->fetch_assoc()) == FALSE) {
    echo   "<div class='ulabeled'>НЕИЗВЕСТНО</div>
          </div>
          <div class='button'>
            <form method='post'>
              <input type='hidden' name='_fname' value='".$fname."'>
              <input type='hidden' name='_lname' value='".$lname."'>
              <input type='submit' name='add' value='Добавить в базу'>
            </form>
          </div>
        </div>";
  } else {
    echo   "<div class='ulabeled'>ПИДАРАС</div>
          </div>
          <div class='button'>
            <form method='post'>
              <input type='hidden' name='id' value='".$row['ID']."'>
              <input type='submit' name='del' value='Удалить из базы'>
            </form>
          </div>
        </div>";
  }
}

if (isset($_POST['pidcheck'])) {
  $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['fname']));
  $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['lname']));
  if (checkstr($fname) && checkstr($lname)) {
    pidCheck($fname, $lname, $connect);
  }
}

if (isset($_POST['del'])) {
  $id = (int)$_POST['id'];
  $del = $connect->query("DELETE FROM pidwart WHERE ID = $id");
  if ($del) {
    $GLOBALS['sysMessages'] = "Пользователь удален.";
  } else {
    $GLOBALS['sysMessages'] = "Ошибка удаления.";
    setLog();
  }
}

if (!($sysMessages === "OK")) {
  echo "<div class='".$logType."'>".$sysMessages."</div>" ;
}

$connect->close();

?>
