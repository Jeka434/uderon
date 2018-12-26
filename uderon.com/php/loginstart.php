<?php

if (isset($_GET['ret_name']) && in_array($_GET['ret_name'], array(
    'list.php',
    'slist.php',
))) {
    $ret_name = $_GET['ret_name'];
} else {
    $ret_name = 'error.php?400'
}
