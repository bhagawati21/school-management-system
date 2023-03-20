<?php
    session_start();
    if ($_SESSION['userid'] == "") {
        header("location:admin-login.php");
    }
    include "../include/config.php";

    if(isset($_GET['cid']) && $_GET['cid'] != "" && $_GET['sid'] && $_GET['sid'] != "" && $_GET['date'] && $_GET['date'] != "")
    {
        $cid = $_GET['cid'];
        $sid = $_GET['sid'];
        $date = $_GET['date'];

        $query = "SELECT `attendance`.*, `classes`.`ClassName`, `subjects`.*,`students`.`RollNumber`,`students`.`Name` FROM `attendance` LEFT JOIN `classes` ON `attendance`.`ClassId` = `classes`.`id` LEFT JOIN `subjects` ON `attendance`.`SubjectId` = `subjects`.`id` LEFT JOIN `students` ON `attendance`.StudentId = `students`.id WHERE `attendance`.ClassId='$cid' AND `attendance`.SubjectId='$sid' AND `attendance`.AttendanceDate='$date'";

        $result = mysqli_query($conn, $query);
        if($result)
        {
            if(mysqli_num_rows($result) > 0)
            {
                $r = mysqli_query($conn,"SELECT `subjects`.*, `classes`.* FROM subjects LEFT JOIN classes ON `subjects`.ClassId = `classes`.id WHERE `subjects`.id = '$sid'");
                $row = mysqli_fetch_array($r);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attendance</title>
    <style>
        .attendance-div{
            height: 440px;
            overflow-y: scroll;
            position: relative;
        }
        th {
            background-color: #007bff;
            color: white;
            /* position: sticky;
            top: 0;
            left: 0; */
        }
    </style>
    <?php
        include "includes/includes.php";
    ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include "includes/navbar.php"; ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-2">
                        <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="manage-attendance.php">Manage Attendance</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Attendance</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-1 rounded">View Attendance</h3>
                    </div>
                    <div class="col-11 my-2 attendance-div border mx-auto border-primary rounded shadow px-5 pt-4 bg-light text-center">
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <span class="font-weight-bold">Class : <?php echo $row['ClassName']; ?></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <span class="font-weight-bold">Subject : <?php echo $row['SubjectName'] . " ( " . $row['SubjectCode'] . " )"; ?></span>
                            </div>
                            <div class="col-md-4 mt-2">
                                <span class="font-weight-bold">Date : <?php echo date('d-m-Y',strtotime($date)); ?></span>
                            </div>

                            <div class="col-md-12 mt-5">
                                <table class="table table-striped text-center" id="table">
                                    <tr>
                                        <th>Attendance</th>
                                        <th>Roll Number</th>
                                        <th>Student Name</th>
                                    </tr>
                                    <?php
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            echo "<tr>";
                                            if($row[5])
                                                echo "<td><span class='text-success font-weight-bold'>Present</span></td>";
                                            else
                                                echo "<td><span class='text-danger font-weight-bold'>Absent</span></td>";

                                            echo "  <td>$row[11]</td>
                                                    <td>$row[12]</td>
                                                  </tr>";
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> <!--row-->
            </div> <!--container-fluid-->
        </div> <!--wrapper-content-->
    </div> <!--wrapper-->
    <script>
        $('.attendance-div').overlayScrollbars({
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
            }
            else
            {
                header("location: manage-attendance.php");
            }
        }
        else
        {
            echo "<script>alert('ERROR :: some sql query error.');";
            echo "document.location = 'manage-attendance.php'; </script>";
        }
    }
    else
        header("location: manage-attendance.php");
?>