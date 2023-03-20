<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Class</title>
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
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Class</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Add Class</h3>
                    </div>
                    <div class="col-md-8 mx-auto rounded bg-light border border-primary shadow my-4 px-4 py-3 pt-5">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-font-case"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="classname" placeholder="Enter class name" required>
                            </div>
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-font-case"></i>
                                    </span>
                                </div>
                                <input type="text" name="numclassname" class="form-control" placeholder="Enter numeric class name" required>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Add Class" name="create">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
    if(isset($_POST['create']))
    {
        include '../include/config.php';

        $class = mysqli_real_escape_string($conn, $_POST['classname']);
        $numclass = mysqli_real_escape_string($conn, $_POST['numclassname']);
        $query = "INSERT INTO `classes`(`ClassName`, `ClassNameNumeric`) VALUES ('$class','$numclass');";
        $result = mysqli_query($conn, $query);
        if($result)
        {
            $row = mysqli_fetch_array(mysqli_query($conn, "SELECT LAST_INSERT_ID();"));
            $cid = $row[0];
            $query = "INSERT INTO fees VALUES (NULL,'$cid','a:0:{}','0.00')";
            if(mysqli_query($conn, $query))
                echo "<script>successNotification('Class Added Successfully')</script>";
            else
                echo "<script>alert(\"Sql Error :: ".mysqli_error($conn)."\")</script>";
        }
            
        else
            echo "<script>alert(\"Sql Error :: ".mysqli_error($conn)."\")</script>";

        mysqli_close($conn);
    }
?>