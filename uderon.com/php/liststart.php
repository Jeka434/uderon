<?php

if (!isset($_POST['access']) || !($_POST['password'] === 'pidor')) {
    header("Location: http://uderon.com/login.php?ret_name=".$GLOBALS[ret_name]);
}

include_once 'sqlconnect.php';

if (isset($_POST['del'])) {
    $id = (int) $_POST['id'];
    $del = $connect->query("DELETE FROM pidwart WHERE ID = $id");
}
$users = $connect->query("SELECT * FROM pidwart ORDER BY ID");
