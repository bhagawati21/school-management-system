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
    <title>Add Result</title>
    <?php include "includes/includes.php"; ?>
    <style>
        .form-div{
            overflow-y: scroll;
            height: 430px;           
        }
        .input-group-text{
            width: 45px!important;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    <?php include "includes/navbar.php"; ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-2">
                        <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Result</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Add Result</h3>
                    </div>
                    <div id="form-div" class="col-md-8 rounded bg-light mx-auto border border-primary shadow py-3 pt-5 px-4 form-div">
                        <form action="calculate-result.php" method="post">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-users class"></i>
                                    </span>
                                </div>
                                <select name="classid" class="custom-select" onchange="getStudents(this); getSubjects(this);" required>
                                    <option value="">Select Class</option>
                                    <?php
                                        $query = "SELECT * FROM classes";

                                        $result = mysqli_query($conn, $query);
                                        if($result)
                                        {
                                            if(mysqli_num_rows($result) > 0)
                                            {
                                                while($row = mysqli_fetch_array($result))
                                                    echo "<option value='$row[0]'>$row[1] ( $row[2] )</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="input-group form-goup">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                <select name="studentid" class="custom-select" id="sname" required>
                                    <option value="">Select name</option>
                                    <!-- student names will be automatically fetched. -->
                                </select>
                            </div>
                            <div class="form-row my-3" id="subjects">
                                <!-- subject will be automatically fetched. -->
                            </div>
                            <div class="form-group text-center py-4">
                                <input type="submit" class="btn btn-primary" value="Add Result" name="addresult">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#form-div').overlayScrollbars({
            scrollbars : {
                visibility : 'auto',    //visible || hidden || auto || v || h || a
                autoHide : 'leave',     //never || scroll || leave || n || s || l
                autoHideDelay : 200,    //number
                dragScrolling : true,   //true || false
                clickScrolling : false, //true || false
                touchSupport : true,     //true || false
                snapHandle: true     //true || false
            }
        }); 
    </script>
</body>
</html>

<?php
    if(isset($_GET['NM']) && $_GET['T'])
    {
        $msg = $_GET['NM'];
        if($_GET['T'] == "error")
            echo "<script>errorNotification('".$msg."')</script>";
        else if($_GET['T'] == "success")
            echo "<script>successNotification('".$msg."')</script>";
        else if($_GET['T'] == "warning")
            echo "<script>warningNotification('".$msg."')</script>";
        else if($_GET['T'] == "info")
            echo "<script>infoNotification('".$msg."')</script>";
    }
?>