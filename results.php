<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Result</title>
    <?php include "include/includes.php"; ?>
    <style>
        #footer{
            position: fixed;
            bottom: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <?php include "include/top-bar.php"; ?>
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="h1 text-center heading-2 text-primary py-2 mb-1 rounded">View Result</h3>
            </div>
            <div class="col-md-5 mx-auto m-4 p-4 rounded bg-light p-5 m-5">
                <form action="" method="post">
                    <div class="form-group">
                        <input type="text" name="rollnumber" placeholder="Enter Roll Number" class="form-control" required>
                    </div>
                    <div class="text-center">
                        <input type="submit" value="View Result" name="viewresult" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php include "include/footer.php"; ?>
</body>
</html>

<?php
    include "include/config.php";
    if(isset($_POST['viewresult']))
    {
        $rollnumber = $_POST['rollnumber'];

        $query = "SELECT id FROM students WHERE RollNumber='$rollnumber'";

        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);
            header("location:showresult.php?id=$row[0]");
        }
        else
        {
            echo "<script>infoNotification(\"Either your roll number is incorrect or your result isn't declared yet\")</script>";
        }
    }
?>