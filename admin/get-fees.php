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

        $query = "SELECT * FROM fees WHERE ClassId='$cid'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
            echo json_encode(unserialize($row[2]));
        }
    }
?>