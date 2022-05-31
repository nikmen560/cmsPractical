<?php
include_once "db.php";
include_once "../admin/functions.php";
include_once "header.php";
session_start();

//TODO: login popup create

if (isset($_POST['submit_login'])) {
    $user_name = escape($_POST['user_name']);
    $user_password = escape($_POST['user_password']);
    log_in($user_name, $user_password);
}
