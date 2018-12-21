<?php

define('NAME_MAX_LEN', 37);
define('ERR_EMPTY_STR', "Ошибка: Пустая строка.");
define('ERR_MAX_LEN',   "Ошибка: Превышено максимальное количество символов.");
define('ERR_NOT_RUS',   "Ошибка: Недопустимый ввод. Допускаются только русские буквы.");
define('ERR_CASE',      "Ошибка: Недопустимый ввод. Имя и фамилия должны начинаться с большой буквы.");
define('FNAME_REGX', '/^([А-ЯЁ][а-яё]+)$/u');
define('LNAME_REGX', '/^([А-ЯЁ][а-яё]+|[ЕОЮ])(([ -][А-ЯЁ][а-яё]+)| [ЕОЮ])*$/u');

$connect = new mysqli("localhost", "pidor", "password", "piddb");
$connect->query("SET NAMES 'utf8'");
$sysMessages = "OK";
$logType = "finelog";

function antiCheat($str)
{
    return htmlspecialchars(mysqli_escape_string($connect, $str));
}

function setLog(bool $value = true)
{
    if ($value) {
        $GLOBALS['logType'] = "errlog";
    } else {
        $GLOBALS['logType'] = "finelog";
    }
}

function checkName(string $name, string $regx = '/.+/')
{
    if (empty($name)) {
        $GLOBALS['sysMessages'] = ERR_EMPTY_STR;
    } elseif (iconv_strlen($name) > NAME_MAX_LEN) {
        $GLOBALS['sysMessages'] = ERR_MAX_LEN;
    } elseif (!preg_match('/^[А-ЯЁа-яё]+$/u', $name)) {
        $GLOBALS['sysMessages'] = ERR_NOT_RUS;
    } elseif (!preg_match($regx, $name)) {
        $GLOBALS['sysMessages'] = ERR_CASE;
    } else {
        return true;
    }
    return false;
}

function checkFL(string $fname, string $lname)
{
    if (checkName($fname, FNAME_REGX) && checkName($lname, LNAME_REGX)) {
        return true;
    }
    setLog();
    return false;
}

function addUser($fname, $lname, $connect)
{
    $user = $connect->query("SELECT *
                             FROM piddb.pidwart AS pid
                             GROUP BY pid.FirstName, pid.LastName
                             HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    if (!$user || ($row = $user->fetch_assoc()) === false) {
        $add = $connect->query("INSERT INTO piddb.pidwart (FirstName, LastName) VALUES  ('$fname', '$lname')");
        if ($add) {
            $GLOBALS['sysMessages'] = "Пользователь добавлен.";
        } else {
            setLog();
            $GLOBALS['sysMessages'] = "Ошибка добавления";
        }
    }
}

function pidCheck($fname, $lname, $connect)
{
    $user = $connect->query("SELECT *
                             FROM piddb.pidwart AS pid
                             GROUP BY pid.FirstName, pid.LastName
                             HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    echo "<div class='userInf'>
            <div class='urow'>
              <div class='ulabel'>Имя:</div>
              <div class='ulabeled'>", $fname, "</div>
            </div>
            <div class='urow'>
              <div class='ulabel'>Фамилия:</div>
              <div class='ulabeled'>", $lname, "</div>
            </div>
            <div class='urow'>
              <div class='ulabel'>Ориентация:</div>";
    if (!$user || ($row = $user->fetch_assoc()) === false) {
        echo "<div class='ulabeled'>НЕИЗВЕСТНО</div>
            </div>
            <div class='button'>
              <form method='post'>
                <input type='hidden' name='_fname' value='", $fname, "'>
                <input type='hidden' name='_lname' value='", $lname, "'>
                <input type='submit' name='add' value='Добавить в базу'>
              </form>
            </div>
          </div>";
    } else {
        echo "<div class='ulabeled'>ПИДАРАС</div>
            </div>
            <div class='button'>
              <form method='post'>
                <input type='hidden' name='id' value='", $row['ID'], "'>
                <input type='submit' name='del' value='Удалить из базы'>
              </form>
            </div>
          </div>";
    }
}

if (isset($_POST['pidcheck'])) {
    $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['fname']));
    $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['lname']));
    if (checkFL($fname, $lname)) {
        pidCheck($fname, $lname, $connect);
    }
}

if (isset($_POST['add'])) {
    $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['_fname']));
    $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['_lname']));
    if (checkFL($fname, $lname)) {
        addUser($fname, $lname, $connect);
    }
} elseif (isset($_POST['del'])) {
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
    echo "<div class='", $logType, "'>", $sysMessages, "</div>" ;
}

$connect->close();
