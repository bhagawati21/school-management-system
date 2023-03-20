<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";
    
    $classid = intval($_GET['ClassId']);
    
    if(isset($_POST['update']))
    {
        $cname = mysqli_real_escape_string($conn, $_POST['classname']);
        $numcname = mysqli_real_escape_string($conn, $_POST['numclassname']);

        $query = "UPDATE `classes` SET `ClassName`='$cname',`ClassNameNumeric`='$numcname' WHERE id='$classid'";

        if(mysqli_query($conn, $query))
            echo "<script>document.location = 'manage-classes.php?T=success&NM=Class Updated Successfully'</script>";
        else
        {
            echo "<script>window.alert(\"Erorr : ".mysqli_error($conn)."\");";
            echo "window.history.back();</script>";   
        }
    }
        $query = "SELECT * FROM classes WHERE id='$classid'";

        $result = mysqli_query($conn, $query);
    
        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
    
            $classname = $row['ClassName'];
            $classnamenumeric = $row['ClassNameNumeric'];
        }
        else
            header("location:manage-classes.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
    <?php include "includes/includes.php"; ?>
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
                            <li class="breadcrumb-item"><a href="manage-classes.php">Manage Classes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Class</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Edit Class</h3>
                    </div>
                    <div class="col-md-8 shadow border border-primary mx-auto rounded bg-light px-4 py-4 pt-5">
                        <form method="post" action="">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-font-case"></i>
                                    </span>
                                </div>
                                <input type="text" name="classname" class="form-control" placeholder="Enter class name" value="<?php echo htmlentities($classname); ?>">
                            </div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-font-case"></i>
                                    </span>
                                </div>
                                <input type="text" name="numclassname" class="form-control" placeholder="Enter numeric class name" value="<?php echo htmlentities($classnamenumeric); ?>">
                            </div>
                            <div class="form-group pt-3 text-center">
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