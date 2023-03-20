<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
    <?php
        include "includes/includes.php";
    ?>
    <style>
        .showbtn{
            border: 1px solid #ced4da!important;
            border-left: 0!important;
            color: #0c6abd;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php 
            include "includes/navbar.php";
        ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-2">
                        <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Change Password</h3>
                    </div>
                    <div class="col-md-8 col-sm-7 my-5 mx-auto bg-white p-3 pt-5 rounded shadow border border-primary">
                        <form action="" method="POST" name="myForm">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-key"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control form-control-lg border-right-0" name="currentpass" placeholder="Enter Current Password" autocomplete="off" required/>
                                <div class="input-group-append">
                                    <button type="button" onclick="show()" tabindex="-1" id="showbtn" class="btn rounded-right showbtn"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-key"></i>
                                    </span>
                                </div>
                                <input type="password" name="newpass" class="form-control form-control-lg border-right-0" placeholder="Enter New Password" autocomplete="off" required/>
                                <div class="input-group-append">
                                    <button type="button" onclick="show1()" tabindex="-1" id="showbtn1" class="btn showbtn rounded-right"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary btn-lg mt-4" value="Change" name="change">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function show()
        {
            if(document.forms['myForm']['currentpass'].type == "password")
            {
                document.forms['myForm']['currentpass'].type = "text";
                document.getElementById('showbtn').innerHTML = '<i class="fas fa-eye-slash">';
            }
            else
            {
                document.forms['myForm']['currentpass'].type = "password";
                document.getElementById('showbtn').innerHTML = '<i class="fas fa-eye">';
            }
        }
        function show1()
        {
            if(document.forms['myForm']['newpass'].type == "password")
            {
                document.forms['myForm']['newpass'].type = "text";
                document.getElementById('showbtn1').innerHTML = '<i class="fas fa-eye-slash">';
            }
            else
            {
                document.forms['myForm']['newpass'].type = "password";
                document.getElementById('showbtn1').innerHTML = '<i class="fas fa-eye">';
            }
        }
    
    </script>
</body>
</html>

<?php
    if(isset($_POST['change']))
    {
        $cpass = $_POST['currentpass'];
        $npass = $_POST['newpass'];
        $userid = $_SESSION['userid'];

        $query = "SELECT * FROM `admin` WHERE UserId='$userid' AND `Password`='$cpass'";

        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_array($result);
            $id = $row[0];
            $query = "UPDATE `admin` SET `Password`='$npass' WHERE id='$id'";
            $result = mysqli_query($conn, $query);
            if($result)
                echo "<script>successNotification('Password Changed')</script>";
            else
                echo mysqli_error($conn);
        }
        else
            echo "<script>infoNotification('Current Password Wrong')</script>";
    }
?>