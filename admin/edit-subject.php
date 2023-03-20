<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";
    
    $subjectid = intval($_GET['SubjectId']);
    
    if(isset($_POST['update']))
    {
        $sname = mysqli_real_escape_string($conn, $_POST['subname']);
        $scode = mysqli_real_escape_string($conn, $_POST['subcode']);
        $cid = mysqli_real_escape_string($conn, $_POST['classid']);

        $query = "UPDATE `subjects` SET `SubjectName`='$sname',`SubjectCode`='$scode',`ClassId`='$cid' WHERE id='$subjectid'";

        if(mysqli_query($conn, $query))
            echo "<script>document.location = 'manage-subjects.php?T=success&NM=Subject Updated Successfully';</script>";
        else
        {
            echo "<script>window.alert(\"Erorr : ".mysqli_error($conn)."\");";
            echo "window.history.back();</script>";
        }
    }
        $query = "SELECT SubjectName,SubjectCode,ClassId,(SELECT ClassName FROM classes WHERE subjects.ClassId=classes.id)ClassName FROM subjects WHERE id='$subjectid'";
        $query1 = "SELECT * FROM classes";

        $result = mysqli_query($conn, $query);
        $result1 = mysqli_query($conn, $query1);
    
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
    
            $subjectname = $row['SubjectName'];
            $subjectcode = $row['SubjectCode'];  
            $classid = $row['ClassId'];
            $classname = $row['ClassName'];
        }
        else
            header("location:manage-subjects.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
    <?php
        include "includes/includes.php";
    ?>
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
                            <li class="breadcrumb-item"><a href="manage-subjects.php">Manage Subjects</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Subject</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Edit Subject</h3>
                    </div>
                    <div class="col-md-8 mx-auto bg-light my-4 px-4 pt-4 rounded shadow">
                        <form method="post" action="">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-font-case"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="subname" placeholder="Enter Subject Name" value="<?php echo htmlentities($subjectname); ?>" required>
                            </div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-code"></i>
                                    </span>
                                </div>
                                <input type="text" name="subcode" class="form-control" placeholder="Enter Subject Code" value="<?php echo htmlentities($subjectcode); ?>" required>
                            </div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-users-class"></i>
                                    </span>
                                </div>
                                <select name="classid" class="custom-select" required>
                                    <?php
                                        if(mysqli_num_rows($result1) > 0)
                                        {
                                            while($row = mysqli_fetch_array($result1))
                                            {
                                                if($classid == $row['id'])
                                                    echo "<option value='".$row['id']."' selected>".$row['ClassName']."</option>";    
                                                else
                                                    echo "<option value='".$row['id']."'>".$row['ClassName']."</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Update" name="update">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>