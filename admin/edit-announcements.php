<?php
    session_start();
    if ($_SESSION['userid'] == "") {
        header("location:admin-login.php");
    }
    include "../include/config.php";

    if(isset($_GET['id']) && $_GET['id'] != "")
    {
        $id = $_GET['id'];

        $query = "SELECT * FROM announcements WHERE id='$id'";

        $result = mysqli_query($conn, $query);
        if($result)
        {
            $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement</title>
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
                            <li class="breadcrumb-item"><a href="news-announcements.php">Announcements</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Announcements</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-1 rounded">Edit Announcements</h3>
                    </div>
                    <div class="col-9 pt-5 my-2 attendance-div border mx-auto border-primary rounded shadow px-5 bg-light">
                        <form action="" method="POST">
                            <div class="form-gorup">
                                <label>Title</label>
                                <input type="text" name="title" value="<?php echo $row[1]?>" class="form-control" placeholder="Enter Title">
                            </div>
                            <div class="form-gorup">
                                <label>Description</label>
                                <textarea name="description" cols="10" rows="5" placeholder="Enter Description" class="form-control"><?php echo $row[2]?></textarea>
                            </div>
                            <div class="text-center mt-4 mb-3">
                                <input type="submit" value="Update" class="btn btn-primary my-2" name="update">
                            </div>
                        </form>
                    </div>
                </div> <!--row-->
            </div> <!--container-fluid-->
        </div> <!--wrapper-content-->
    </div> <!--wrapper-->
</body>
</html>
<?php
        }
        else
        {
            echo "<script>alert('ERROR :: some sql query error.');";
            echo "document.location = 'news-announcements.php'<script>";
        }
    }
    else
        header("location: news-announcements.php");
    
    if(isset($_POST['update']))
    {
        $title = $_POST['title'];
        $description = $_POST['description'];

        $query = "UPDATE announcements SET Title='$title',`Description`='$description' WHERE id='$id'";
        $result = mysqli_query($conn, $query);

        if($result)
            echo "<script>document.location = 'news-announcements.php?T=success&NM=Record Updated Successfully';</script>";
        else
            echo "<script>alert(\"" . mysqli_error($conn) . "\")</script>";
    }
?>
