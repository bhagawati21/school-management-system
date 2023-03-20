<?php
    session_start();
    $_SESSION['studentid'] = "";
    $_SESSION['studentname'] = "";
    session_destroy();
    header("location:student-login.php");
?>