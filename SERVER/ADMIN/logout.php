<?php
    session_start();
    $_SESSION['login'] = '';
    unset($_SESSION['login']);
    session_unset();
    session_destroy();
	setcookie("login", "", time() - (86400 * 365), "/"); // 86400 = 1 day
    header("Location:/?");
?>