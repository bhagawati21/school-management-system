<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";

    if(isset($_POST['cid']))
    {
        $cid = $_POST['cid'];

        $query = "SELECT * FROM subjects WHERE ClassId='$cid'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0)
        {
            echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
        }
        else
            echo json_encode("No subjects");
    }
?>