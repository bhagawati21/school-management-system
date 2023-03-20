<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";

    if(isset($_POST['sid']))
    {
        $sid = $_POST['sid'];

        $query = "SELECT `ParentEmail`,`ParentPhoneNumber` FROM students WHERE id='$sid'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0)
        {
            echo json_encode(mysqli_fetch_all($result, MYSQLI_ASSOC));
        }
        else
            echo json_encode("No Data");
    }
?>