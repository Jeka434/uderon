<?php
include_once 'config.php';

$connect = new mysqli($dblocation, $dbuser, $dbpasswd, $dbname);
if (!$connect) {
    echo "<div class='errlog'>Не удалось соединиться с базой данных</div>" ;
    exit();
}
$connect->query("SET NAMES 'utf8'");
