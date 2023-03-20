<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    $id = $_REQUEST['id'];
    
    include "../include/config.php";
    
    $query = "SELECT * FROM students WHERE id='$id'";

    $result = mysqli_query($conn, $query);

    if($result)
    {
        if(mysqli_num_rows($result) == 1)
        {
            $row1 = mysqli_fetch_array($result);
        }
        else
            header("location:manage-students.php");
    }
    else
    {
        echo "<script>window.alert(\"Erorr : ".mysqli_error($conn)."\");";
        echo "document.location = 'manage-students.php'</script>";
    }
        
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        /* .image-container {
            width: 280px;
            height: 300px;
            overflow: hidden;
        } */

        #image-div {
            width: 200px;
            height: 200px;
            margin: 25px auto 5px;
        }

        #image {
            width: 200px;
            height: 200px;
            border-radius: 5px;
        }
        .form-div{
            overflow-y: scroll;
            height: 425px;
        }
    </style>
    <?php 
        include "includes/includes.php";
    ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include "includes/navbar.php" ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-2">
                        <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="manage-students.php">Manage Students</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Edit Students</h3>
                    </div>
                    <div class="col-md-6 mr-3 ml-auto shadow rounded bg-light pt-4 px-3 border border-primary form-div" id="form-div">
                        <form action="" method="post" id="myForm" enctype="multipart/form-data" name="myForm" onreset="clearPhoto()">
                            <div class="form-group">
                                <input type="text" class="form-control" name="rollnumber" placeholder="Enter Roll Number" value="<?php echo $row1[1] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="enrollnumber" placeholder="Enter Enrollment Number" value="<?php echo $row1[2] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="sname" placeholder="Enter Student Name" value="<?php echo $row1[3] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="mname" class="form-control" placeholder="Enter Mother's Name" value="<?php echo $row1[5] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="fname" class="form-control" placeholder="Enter Father's Name" value="<?php echo $row1[4] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="<?php echo $row1[10] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="parentphone" class="form-control" placeholder="Enter Parent's Phone Number" value="<?php echo $row1[11] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="date" name="dob" class="form-control" value="<?php echo $row1[8] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="age" class="form-control" placeholder="Enter Age" value="<?php echo $row1[9] ?>"required>
                            </div>
                            <div class="form-group">
                                <input type="text" name="address" class="form-control" placeholder="Enter Address" value="<?php echo $row1[6] ?>" required>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $row1[7] ?>" required>
                            </div>
                            <div class="form-group">
                                <select name="classid" class="custom-select" required>
                                    <option value="">Select Class</option>
                                    <?php
                                    $query = "SELECT * FROM classes";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_array($result))
                                        {
                                            if($row['id'] == $row1[12])
                                                echo "<option value='".$row['id']."' selected>".$row['ClassName']." ( ".$row['ClassNameNumeric']." )"."</option>";
                                            else
                                                echo "<option value='".$row['id']."'>".$row['ClassName']." ( ".$row['ClassNameNumeric']." )"."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row my-4">
                                <div class="col-md-6 my-3 text-center">
                                    <input type="submit" name="update" class="btn btn-primary" value="update Student">
                                </div>
                                <div class="col-md-6 my-3 text-center">
                                    <input type="reset" value="Clear Form" class="btn btn-danger">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 ml-3 mr-auto">
                        <div class="image-container shadow bg-light rounded border border-primary">
                            <div id="image-div"><img id="image" src="../photos/<?php echo $row1['id'].'/'.$row1['Photo'] ?>" alt="student image"></div>
                            <div class="custom-file">
                                <input type="file" form="myForm" name="photo" class="custom-file-input" accept=".jpg,.png,.jpeg" 
                                onchange="show()" id="photo">
                                <label class="custom-file-label" for="photo"><?php echo $row1['Photo']?></label>
                            </div>
                        </div>
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

        $('#photo').change(function(e){
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
        $('#myForm').on("reset",function(){
            $('.custom-file-label').html("Choose Photo");
        });
    </script>
</body>
</html>

<?php
    if(isset($_POST['update']))
    {
        $sname = mysqli_real_escape_string($conn, $_POST['sname']);
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $mname = mysqli_real_escape_string($conn, $_POST['mname']);
        $roll = mysqli_real_escape_string($conn, $_POST['rollnumber']);
        $enroll = mysqli_real_escape_string($conn, $_POST['enrollnumber']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $parentphone = mysqli_real_escape_string($conn, $_POST['parentphone']);
        $dob = mysqli_real_escape_string($conn, $_POST['dob']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $cid = mysqli_real_escape_string($conn, $_POST['classid']);

        if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0)
        {
            $filename = $_FILES["photo"]["name"];
            $path = "../photos/$id/";

            if(!file_exists($path))
            {
                mkdir($path);
            }

            if($r = move_uploaded_file($_FILES['photo']['tmp_name'],$path.$filename) == 1)
            {
                $query = "UPDATE `students` SET `RollNumber`='$roll',`EnrollmentNumber`='$enroll',`Name`='$sname',`FatherName`='$fname',`MotherName`='$mname',`Address`='$address',`Email`='$email',`DOB`='$dob',`Age`='$age',`PhoneNumber`='$phone',`ParentPhoneNumber`='$parentphone',`ClassId`='$cid',`Photo`='$filename' WHERE `id`='$id'";
                $result = mysqli_query($conn,$query);
                if($result)
                    echo "<script>document.location = 'manage-students.php?T=success&NM=Student Updated Successfully'</script>";
                else
                {
                    echo "<script>window.alert(\"Erorr : ".mysqli_error($conn)."\");";
                    echo "window.history.back();</script>";
                }    
            }
            else
                echo "<script>errorNotification('Could not upload file');</script>";

        }
        // else
        //     echo "<script>alert(". $_FILES['photo']['error'].")</script>";
        
        if(!isset($r))
        {
            $query = "UPDATE `students` SET `RollNumber`='$roll',`EnrollmentNumber`='$enroll',`Name`='$sname',`FatherName`='$fname',`MotherName`='$mname',`Address`='$address',`Email`='$email',`DOB`='$dob',`Age`='$age',`PhoneNumber`='$phone',`ParentPhoneNumber`='$parentphone',`ClassId`='$cid' WHERE `id`='$id'";
            $result = mysqli_query($conn, $query);
            if ($result)
                echo "<script>document.location = 'manage-students.php?T=success&NM=Student Updated Successfully'</script>";
            else 
            {
                echo "<script>window.alert(\"Erorr : " . mysqli_error($conn) . "\");";
                echo "window.history.back();</script>";
            }
        }
    }
?>