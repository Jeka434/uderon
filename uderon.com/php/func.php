<?php

define('NAME_MAX_LEN', 37);
define('ERR_EMPTY_STR', "Ошибка: Пустая строка.");
define('ERR_MAX_LEN',   "Ошибка: Превышено максимальное количество символов.");
define('ERR_NOT_RUS',   "Ошибка: Недопустимый ввод. Допускаются только русские буквы.");
define('ERR_CASE',      "Ошибка: Недопустимый ввод. Имя и фамилия должны начинаться с большой буквы.");
define('FNAME_REGX', '/^([А-ЯЁ][а-яё]+)$/u');
define('LNAME_REGX', '/^([А-ЯЁ][а-яё]+|[ЕОЮ])(([ -][А-ЯЁ][а-яё]+)| [ЕОЮ])*$/u');

include_once 'sqlconnect.php';
$sys_messages = "OK";
$err = false;

function set_err(bool $value = true)
{
    $GLOBALS['err'] = $value;
}

function check_name(string $name, string $regx = '/.+/')
{
    if (empty($name)) {
        $GLOBALS['sys_messages'] = ERR_EMPTY_STR;
    } elseif (iconv_strlen($name) > NAME_MAX_LEN) {
        $GLOBALS['sys_messages'] = ERR_MAX_LEN;
    } elseif (!preg_match('/^[А-ЯЁа-яё -]+$/u', $name)) {
        $GLOBALS['sys_messages'] = ERR_NOT_RUS;
    } elseif (!preg_match($regx, $name)) {
        $GLOBALS['sys_messages'] = ERR_CASE;
    } else {
        return true;
    }
    return false;
}

function checkFL(string $fname, string $lname)
{
    if (check_name($fname, FNAME_REGX) && check_name($lname, LNAME_REGX)) {
        return true;
    }
    set_err();
    return false;
}

function add_user($fname, $lname, $connect)
{
    $user = $connect->query("SELECT *
                             FROM piddb.pidwart AS pid
                             GROUP BY pid.FirstName, pid.LastName
                             HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    if (!$user || ($row = $user->fetch_assoc()) == false) {
        $add = $connect->query("INSERT INTO piddb.pidwart (FirstName, LastName) VALUES  ('$fname', '$lname')");
        if ($add) {
            $GLOBALS['sys_messages'] = "Пользователь добавлен.";
        } else {
            set_err();
            $GLOBALS['sys_messages'] = "Ошибка добавления";
        }
    }
}

function pid_check($fname, $lname, $connect)
{
    $user = $connect->query("SELECT *
                             FROM piddb.pidwart AS pid
                             GROUP BY pid.FirstName, pid.LastName
                             HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
    return $user && ($row = $user->fetch_assoc()) == true;
}

if (isset($_POST['pidcheck'])) {
    $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['fname']));
    $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['lname']));
    if (checkFL($fname, $lname)) {
        pid_check($fname, $lname, $connect);
?>
          <div class='user_inf'>
            <div class='urow'>
              <div class='ulabel'>Имя:</div>
              <div class='ulabeled'><?= $fname ?></div>
            </div>
            <div class='urow'>
              <div class='ulabel'>Фамилия:</div>
              <div class='ulabeled'><?= $lname ?></div>
            </div>
            <div class='urow'>
              <div class='ulabel'>Ориентация:</div>
              <div class='ulabeled'><?= $found ? 'ПИДАРАС' : 'НЕИЗВЕСТНО'; ?></div>
            </div>
            <div class='button'>
              <form method='post'>
<?php   if($found) { ?>
                <input type='hidden' name='id' value='<?= $row['ID'] ?>'>
                <input type='submit' name='del' value='Удалить из базы'>
<?php   } else { ?>
                <input type='hidden' name='_fname' value='<?= $fname ?>'>
                <input type='hidden' name='_lname' value='<?= $lname ?>'>
                <input type='submit' name='add' value='Добавить в базу'>
<?php   } ?>
              </form>
            </div>
          </div>
<?php
    }
}

if (isset($_POST['add'])) {
    $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['_fname']));
    $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['_lname']));
    if (checkFL($fname, $lname)) {
        add_user($fname, $lname, $connect);
    }
} elseif (isset($_POST['del'])) {
    $id = (int)$_POST['id'];
    $del = $connect->query("DELETE FROM pidwart WHERE ID = $id");
    if ($del) {
        $GLOBALS['sys_messages'] = "Пользователь удален.";
    } else {
        $GLOBALS['sys_messages'] = "Ошибка удаления.";
        set_err();
    }
}

if (!($sys_messages === "OK")) {
    echo "<div class='", $err ? "finelog" : "errlog", "'>", $sys_messages, "</div>" ;
}

$connect->close();
