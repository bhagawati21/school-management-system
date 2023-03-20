<?php
    session_start();
    if ($_SESSION['userid'] == "") {
        header("location:admin-login.php");
    }
    include "../include/config.php";
    
    $query = "SELECT * FROM classes";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 0)
        header("location:create-classe.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance</title>
    <style>
        .attendance-div{
            height: 440px;
            overflow-y: scroll;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .input-group-text{
            width: 45px;
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
                            <li class="breadcrumb-item active" aria-current="page">Add Attendance</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-1 rounded">Add Attendance</h3>
                    </div>
                    <div class="col-11 my-2 attendance-div border mx-auto border-primary rounded shadow px-5 pt-4 bg-light">
                        <form action="" method="POST">
                            <div class="form-group input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-users-class"></i>
                                    </span>
                                </div>
                                <select name="class" class="custom-select" onchange="attendanceGetStudents(this); attendanceGetSubjects(this);" required>
                                    <option value="">Select Class</option>
                                    <?php
                                        while($row = mysqli_fetch_array($result))
                                            echo "<option value='$row[0]'>$row[1] ( $row[2] )</option>";
                                    ?>
                                </select>
                            </div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="date" name="attendance-date" class="form-control" value="<?php echo date('Y-m-d');?>" required>
                            </div>
                            <div class="form-group input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-book"></i>
                                    </span>
                                </div>
                                <select name="subject" id="subjects" class="custom-select" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                            <div class="student-div">
                                <table class="table table-striped text-center" id="table">
                                </table>
                            </div>
                            <div class="form-group text-center mt-5 mb-3">
                                <input type="submit" value="Add Attendance" class="btn btn-primary my-2" name="add">
                            </div> 
                        </form>
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
        if(isset($_POST['add']))
        {
            $attendance = $_POST['attendance'];
            $class = $_POST['class'];
            $subject = $_POST['subject'];
            $attendanceDate = $_POST['attendance-date'];
            
            foreach ($attendance as $key => $value) 
            {
                $query = "INSERT INTO attendance VALUES(NULL,'$key','$subject','$class','$attendanceDate','$value')";
                $result = mysqli_query($conn, $query);
            }
            // echo "<script>console.log(".'"'.$query.'"'.")</script>"; //For Development Purpose
            if($result)
                echo "<script>successNotification('Attendance Added');</script>";
            else
                echo "<script>alert(\"" . mysqli_error($conn) . "\")</script>";
        }
?>