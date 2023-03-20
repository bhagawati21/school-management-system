<?php
session_start();
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
include "../include/config.php";

$query = "SELECT * FROM announcements ORDER BY `Date` DESC";
$result = mysqli_query($conn, $query);
if (!$result) {
    echo "<script>alert('There was some problem while fetching the data')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News and Announcements</title>
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
                                <li class="breadcrumb-item active" aria-current="page">News and Announcements</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-2 rounded">News and Announcements</h3>
                    </div>
                    <div class="col-md-11 col-sm-7 my-2 mx-auto p-4 bg-white rounded shadow border border-primary">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#fileselector"> <i class="fas fa-plus"></i> Add New</button>

                                <div class="modal fade" id="fileselector" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">News and Announcements</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST" enctype="multipart/form-data" id="myForm">
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" name="title" placeholder="Enter Title" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea name="description" cols="10" rows="5" class="form-control" placeholder="Enter Description" required></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times"></i> Close</button>
                                                <button type="submit" form="myForm" class="btn btn-primary" name="add">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4 mx-auto">
                                <table class="table table-striped ">
                                    <tr class="bg-primary">
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php
                                    $sno = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $sno ?></td>
                                            <td><?php echo $row[1] ?></td>
                                            <td style="max-width:500px"><?php echo $row[2] ?></td>
                                            <td><?php echo date("d-m-Y h:i A", strtotime($row[3])) ?></td>
                                            <td style="width:110px;" class="text-center">
                                                <a href='edit-announcements.php?id=<?php echo $row[0]; ?>' class="mx-2"><i class='fas fa-edit'></i></a>
                                                <button class="btn text-danger" onclick="if(confirm('are you sure?'))document.location = 'delete.php?c=announcement&id=<?php echo $row[0]; ?>'"><i class="fa fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                        $sno++;
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--row-->
            </div>
            <!--container-fluid-->
        </div>
        <!--content-wrapper-->
    </div>
    <!--wrapper-->
</body>
</html>

<?php
    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
    
        $query = "INSERT INTO announcements VALUES(NULL,'$title','$description',NULL)";
        $result = mysqli_query($conn, $query);
    
        if ($result)
            echo "<script>document.location = 'news-announcements.php?T=success&NM=Added Successfully'</script>";
        else
            echo "<script>alert(\"". mysqli_error($conn) ."\")</script>";
        // if($_FILES['photo'] && $_FILES['photo']['error'] == 0)
        // {
        //     $path = "../img/slider/".$_FILES['photo']['name'];
        //     $r = move_uploaded_file($_FILES['photo']['tmp_name'],$path);
    
        //     if($r)
        //         echo "<script>alert('Image uploaded')</script>";
        //     else
        //         echo "<script>alert('There was some problem in uploading the file.')</script>";
        // }
    }
    if(isset($_GET['NM']) && $_GET['T'])
    {
        $msg = $_GET['NM'];
        if($_GET['T'] == "error")
            echo "<script>errorNotification('".$msg."')</script>";
        else if($_GET['T'] == "success")
            echo "<script>successNotification('".$msg."')</script>";
        else if($_GET['T'] == "warning")
            echo "<script>warningNotification('".$msg."')</script>";
        else if($_GET['T'] == "info")
            echo "<script>infoNotification('".$msg."')</script>";
    }
?>