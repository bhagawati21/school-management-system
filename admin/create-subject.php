<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include '../include/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Create Subject</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Add Subject</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Add Subjects</h3>
                    </div>
                    <div class="col-md-8 bg-light mx-auto px-4 pt-4 mt-4 rounded shadow border border-primary">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-font-case"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="subname" placeholder="Enter Subject Name" required>
                            </div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-code"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" name="subcode" placeholder="Enter Subject code" required>
                            </div>
                            <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-users-class"></i>
                                    </span>
                                </div>
                                <select class="custom-select" name="classid" required>
                                    <option value="">Select Class</option>
                                    <?php
                                        $query = "SELECT * FROM classes WHERE 1";

                                        $result = mysqli_query($conn, $query);
                                    
                                        if(mysqli_num_rows($result) > 0)
                                        {
                                            while($row = mysqli_fetch_array($result))
                                                echo "<option value='".$row['id']."'>".$row['ClassName']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Add Subject" name="create">
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
        $subname = mysqli_real_escape_string($conn, $_POST['subname']);
        $subcode = mysqli_real_escape_string($conn, $_POST['subcode']);
        $classid = mysqli_real_escape_string($conn, $_POST['classid']);
        $query = "INSERT INTO `subjects`(`SubjectName`, `SubjectCode`, `ClassId`) VALUES ('$subname','$subcode','$classid')";
        if(mysqli_query($conn, $query))
            echo "<script>successNotification('Subject Created')</script>";
        else
        {
            echo "<script>alert(\"Sql Error :: ". mysqli_error($conn) ."\");";
            echo "window.history.back();</script>";
        }
    }
?>