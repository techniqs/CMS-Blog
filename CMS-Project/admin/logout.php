<?php
session_start();
if (isset($_COOKIE['username'])) {
    $cookie_value = $_COOKIE['username'];
    setcookie("username", "",  time()-(11 * 365 * 24 * 60 * 60),'/CMS-Project');

    unset($_COOKIE['username']);

    // empty value and expiration one hour before
}
session_unset();
session_destroy();

header("Location: http://localhost/CMS-Project/index.php");