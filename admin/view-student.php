<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";
    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $query = "SELECT students.*, classes.* FROM students LEFT JOIN classes ON students.ClassId = classes.id WHERE students.id='$id'";
        $result = mysqli_query($conn,$query);
        if($result)
        {
            if(mysqli_num_rows($result) == 1)
            {
                $row = mysqli_fetch_array($result);
                $photo = "../photos/".$row[0]."/".$row['Photo'];
            }
            else
            { 
                header("location:manage-students.php");
            }
        }
        else
        {
            echo "<script>alert('ERROR :: Some sql query error')
                document.location = 'manage-students.php'</script>";
        }
    }
    else
    {
        header("location:manage-students.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <?php include "includes/includes.php"; ?>
    <style>
        .img{
            width: 90px!important;
        }
        @media print{
            body * {
                visibility: hidden;
            }
            #print, #print *{
                visibility: visible;
            }
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <?php include "includes/navbar.php"; ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="manage-students.php">Manage Students</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Student</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-1 rounded">Student Details</h3>
                    </div>
                    <div id="print" class="col-md-10 rounded border border-primary mx-auto bg-light shadow p-3 mb-2">
                        <table class="table table-light table-striped">
                            <tr>
                                <th>Name</th>
                                <td><?php echo $row[3]?></td>
                                <th>Photo</th>
                                <td><img class="img img-thumbnail" src="<?php echo $photo; ?>" alt="student-image"></td>
                            </tr>
                            <tr>
                                <th>Roll Number</th>
                                <td><?php echo $row[1]; ?></td>
                                <th>Enrollment Number</th>
                                <td><?php echo $row[2]; ?></td>
                            </tr>
                            <tr>
                                <th>Class</th>
                                <td><?php echo $row[18]; ?></td>
                                <th>Gender</th>
                                <td><?php echo $row[14]; ?></td>
                            </tr>
                            <tr>
                                <th>Father's Name</th>
                                <td><?php echo $row[4]; ?></td>
                                <th>Mother's Name</th>
                                <td><?php echo $row[5]; ?></td>
                            </tr>
                            <tr>
                                <th>Dob</th>
                                <td><?php echo $row[8]; ?></td>
                                <th>Age</th>
                                <td><?php echo $row[9]; ?></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td><?php echo $row[6]; ?></td>
                                <th>E-mail</th>
                                <td><?php echo $row[7]; ?></td>
                            </tr>
                            <tr>
                                <th>Phone Number</th>
                                <td><?php echo $row[10]; ?></td>
                                <th>Parent's Phone Number</th>
                                <td><?php echo $row[11]; ?></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <button class="btn btn-primary mt-3" onclick="window.print()">Print</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>