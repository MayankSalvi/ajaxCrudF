<?php

session_start();
session_destroy();
session_unset($_SESSION['id']);
session_unset($_SESSION['fullname']);
setcookie('emailCookie', '', time() - 86400);
setcookie('passwordCookie', '', time() - 86400);
header("Location:login.php");
echo '1';