<?php
session_start();
if ($_SESSION['usertype'] == 'user') {
    $userType = 'thisisuser';
}
if (isset($_POST['action']) && $_POST['action'] == 'user_last_active_time') {
    if (time() - $_SESSION['last_active_time'] > 20) {
        echo 'logout';
    }
} else {
    // if (isset($_SESSION['last_active_time'])) {
    //     if (time() - $_SESSION['last_active_time'] > 20) {
    //         header("Location:logout.php");
    //     }
    // }
    $_SESSION['last_active_time'] = time();
    if (!isset($_SESSION['id'])) {
        header("Location:login.php");
    }
}