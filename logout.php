<?php

session_start();

unset($_SESSION['user']);
session_destroy();

unset($_SERVER['PHP_AUTH_USER']);

Header("Location: index.php");

?>