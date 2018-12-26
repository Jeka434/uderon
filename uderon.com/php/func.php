<?php

define('NAME_MAX_LEN', 37);
define('ERR_ADDMIN', "Ошибка: Ваша мать – шалава.");
define('ERR_EMPTY_STR', "Ошибка: Пустая строка.");
define('ERR_MAX_LEN',   "Ошибка: Превышено максимальное количество символов.");
define('ERR_NOT_RUS',   "Ошибка: Недопустимый ввод. Допускаются только русские буквы.");
define('ERR_CASE',      "Ошибка: Недопустимый ввод. Имя и фамилия должны начинаться с большой буквы.");
define('ERR_ADD_USER', "Ошибка добавления.");
define('ERR_DEL_USER', "Ошибка удаления.");
define('MSG_ADD_USER', "Пользователь добавлен.");
define('MSG_DEL_USER', "Пользователь удален.");
define('FNAME_REGX', '/^([А-ЯЁ][а-яё]+)$/u');
define('LNAME_REGX', '/^([А-ЯЁ][а-яё]+|[ЕОЮ])(([ -][А-ЯЁ][а-яё]+)| [ЕОЮ])*$/u');
define('ADMINS', array(
    array('Евгений', 'Ростовский'),
    array('Евгений', 'Васин'),
));

$sys_messages = "";

function log_assert($value, $errmsg = "", $finemsg = "")
{
    if ($value) {
        $GLOBALS['sys_messages'] = ($finemsg === "" ? $GLOBALS['sys_messages'] : "<div class='finelog'>$finemsg</div>");
    } else {
        $GLOBALS['sys_messages'] = ($errmsg === "" ? $GLOBALS['sys_messages'] : "<div class='errlog'>$errmsg</div>");
    }
    return (boolean) $value;
}

function check_name(string $name, string $regx = '/.+/')
{
    return log_assert(!empty($name), ERR_EMPTY_STR)
        && log_assert(iconv_strlen($name) <= NAME_MAX_LEN, ERR_MAX_LEN)
        && log_assert(preg_match('/^[А-ЯЁа-яё -]+$/u', $name), ERR_NOT_RUS)
        && log_assert(preg_match($regx, $name), ERR_CASE);
}

function checkFL(string $fname, string $lname)
{
    return check_name($fname, FNAME_REGX) && check_name($lname, LNAME_REGX);
}

function check_admin(string $fname, string $lname)
{
    if (in_array(array($fname, $lname), ADMINS)) {
        include_once 'pidcheck/admin.php';
        return true;
    }
    return false;
}

function find_user($fname, $lname, $connect)
{
    $user = $connect->query("SELECT *
                             FROM piddb.pidwart AS pid
                             WHERE pid.FirstName='$fname' AND pid.LastName='$lname'");
    return $user ? $user->fetch_assoc() : false;
}

function add_user($fname, $lname, $connect)
{
    if (checkFL($fname, $lname)) {
        $row = find_user($fname, $lname, $connect);
        if (log_assert(!$row, ERR_ADD_USER)) {
            $add = $connect->query("INSERT INTO piddb.pidwart (FirstName, LastName) VALUES  ('$fname', '$lname')");
            log_assert($add, ERR_ADD_USER, MSG_ADD_USER);
        }
    }
}

function pid_check($fname, $lname, $connect)
{
    if (checkFL($fname, $lname) && !check_admin($fname, $lname)) {
        $row = find_user($fname, $lname, $connect);
        include_once ($row ? "pidcheck/notfound.php" : "pidcheck/found.php");
    }
}

function del_user($id, $connect)
{
    $del = $connect->query("DELETE FROM pidwart WHERE ID = $id");
    log_assert($del, ERR_DEL_USER, MSG_DEL_USER);
}

function main()
{
    require_once 'sqlconnect.php';
    $fname = isset($_POST['fname']) ? htmlspecialchars(mysqli_escape_string($connect, $_POST['fname'])) : "";
    $lname = isset($_POST['lname']) ? htmlspecialchars(mysqli_escape_string($connect, $_POST['lname'])) : "";
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    if (isset($_POST['pidcheck'])) {
        pid_check($fname, $lname, $connect);
    } elseif (isset($_POST['add'])) {
        add_user($fname, $lname, $connect);
    } elseif (isset($_POST['del'])) {
        del_user($id, $connect);
    } elseif (isset($_POST['addmin'])) {
        log_assert(false, ERR_ADDMIN);
    }
    echo $sys_messages;
    $connect->close();
}
