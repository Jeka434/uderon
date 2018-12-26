<?php

define('NAME_MAX_LEN', 37);
define('ERR_EMPTY_STR', "Ошибка: Пустая строка.");
define('ERR_MAX_LEN',   "Ошибка: Превышено максимальное количество символов.");
define('ERR_NOT_RUS',   "Ошибка: Недопустимый ввод. Допускаются только русские буквы.");
define('ERR_CASE',      "Ошибка: Недопустимый ввод. Имя и фамилия должны начинаться с большой буквы.");
define('FNAME_REGX', '/^([А-ЯЁ][а-яё]+)$/u');
define('LNAME_REGX', '/^([А-ЯЁ][а-яё]+|[ЕОЮ])(([ -][А-ЯЁ][а-яё]+)| [ЕОЮ])*$/u');

include_once 'sqlconnect.php';
$sys_messages = "";
$err = false;

function log_assert($value, $errmsg = "", $finemsg = "")
{
    if ($value) {
        $GLOBALS['sys_messages'] = ($errmsg === "" ? $GLOBALS['sys_messages'] : $errmsg);
        $GLOBALS['err'] = true;
    } else {
        $GLOBALS['sys_messages'] = ($finemsg === "" ? $GLOBALS['sys_messages'] : $finemsg);
        $GLOBALS['err'] = false;
    }
    return $GLOBALS['err'];
}

function check_name(string $name, string $regx = '/.+/')
{
    return !(log_assert(empty($name), ERR_EMPTY_STR)
          || log_assert(iconv_strlen($name) > NAME_MAX_LEN, ERR_MAX_LEN)
          || log_assert(!preg_match('/^[А-ЯЁа-яё -]+$/u', $name), ERR_NOT_RUS)
          || log_assert(!preg_match($regx, $name), ERR_CASE));
}

function checkFL(string $fname, string $lname)
{
    return check_name($fname, FNAME_REGX) && check_name($lname, LNAME_REGX);
}

function add_user($fname, $lname, $connect)
{
    if (checkFL($fname, $lname)) {
        $user = $connect->query("SELECT *
                                 FROM piddb.pidwart AS pid
                                 GROUP BY pid.FirstName, pid.LastName
                                 HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
        if (!$user || ($row = $user->fetch_assoc()) == false) {
            $add = $connect->query("INSERT INTO piddb.pidwart (FirstName, LastName) VALUES  ('$fname', '$lname')");
            log_assert(!$add, "Ошибка добавления", "Пользователь добавлен.");
        }
    }
}

function pid_check($fname, $lname, $connect)
{
    if (checkFL($fname, $lname)) {
        $user = $connect->query("SELECT *
                                 FROM piddb.pidwart AS pid
                                 GROUP BY pid.FirstName, pid.LastName
                                 HAVING pid.FirstName='$fname' AND pid.LastName='$lname'");
        $row = $user->fetch_assoc();
        $check_id = $user && $row == true ? $row['ID'] : false;
        include_once ($check_id === false ? "pidcheck/notfound.php" : "pidcheck/found.php");
    }
}

function del_user($id, $connect)
{
    $del = $connect->query("DELETE FROM pidwart WHERE ID = $id");
    log_assert(!$del, "Ошибка удаления.", "Пользователь удален.");
}

if (isset($_POST['pidcheck'])) {
    $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['fname']));
    $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['lname']));
    pid_check($fname, $lname, $connect);
}

if (isset($_POST['add'])) {
    $fname = htmlspecialchars(mysqli_escape_string($connect, $_POST['_fname']));
    $lname = htmlspecialchars(mysqli_escape_string($connect, $_POST['_lname']));
    add_user($fname, $lname, $connect);
} elseif (isset($_POST['del'])) {
    $id = (int)$_POST['id'];
    del_user($id, $connect);
}

if (!($sys_messages === "")) {
    echo "<div class='", $err ? "errlog" : "finelog", "'>", $sys_messages, "</div>" ;
}

$connect->close();
