<?php
    session_start();
    include "include/config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
        #footer{
            position: fixed;
            bottom: 0;
            left: 0;
        }
    </style>
    <?php include "include/includes.php"; ?>
</head>
<body>
    <?php include "include/top-bar.php"; ?>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="h1 text-center heading-2 text-primary py-2 mb-1 rounded">Student Login</h3>
            </div>
            <div class="col-md-6 mx-auto rounded bg-light m-4 p-4 mt-5">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="stu_enroll" class="form-control" placeholder="Enter Enrollment number" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                    </div>
                    <div class="text-center">
                        <input type="submit" value="login" class="btn btn-primary" name="login">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include "include/footer.php"; ?>
</body>
</html>

<?php
    if(isset($_POST['login']))
    {
        $enrollmentnum = $_POST['stu_enroll'];
        $password = $_POST['password'];

        $query = "SELECT * FROM students WHERE EnrollMentNumber = '$enrollmentnum' AND `Password` = '$password'";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_array($result);
            $_SESSION['studentid'] = $row[0];
            $_SESSION['studentname'] = $row[3];
            header("location:dashboard.php");
        }
        else
            echo "<script>infoNotification('Enrollment number or password wrong.');</script>";
    }
?>