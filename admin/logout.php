<?php
    session_start();
    $_SESSION = array();
    unset($_SESSION["userid"]);
    session_destroy();
    header("location:admin-login.php");
?>