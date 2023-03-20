<?php
session_start();
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
include "../include/config.php";
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $class = $_POST['class'];
    $subject = $_POST['subject'];

    if ($_FILES['attachment'] && $_FILES['attachment']['error'] == 0) {
        $path = "../attachments/Notes/" . $_FILES['attachment']['name'];
        $r = move_uploaded_file($_FILES['attachment']['tmp_name'], $path);

        if ($r)
        {
            $attachment = $_FILES['attachment']['name'];
            $query = "INSERT INTO notes VALUES(NULL,'$title','$description','$class','$subject','$attachment')";
            $result = mysqli_query($conn, $query);
            if ($result)
            {
                header("location: notes.php?T=success&NM=Notes Added Successfully");
            }
            else
                echo "<script>errorNotification(\"". mysqli_error($conn) ."\")</script>";
        }
        else
            echo "<script>errorNotification('There was some problem in uploading the file.')</script>";
    }
}
$query = "SELECT `notes`.*, `classes`.*, `subjects`.* FROM `notes` LEFT JOIN `classes` ON `notes`.`ClassId` = `classes`.`id` LEFT JOIN `subjects` ON `notes`.`SubjectId` = `subjects`.`id`;";
$result = mysqli_query($conn, $query);
$query = "SELECT * FROM classes";
$classes = mysqli_query($conn, $query);
if (!$result || !$classes) {
    echo "<script>alert('There was some problem while fetching the data')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes</title>
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
                                <li class="breadcrumb-item active" aria-current="page">Notes</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-2 rounded">Notes</h3>
                    </div>
                    <div class="col-md-11 col-sm-7 my-2 mx-auto p-4 bg-white rounded shadow border border-primary">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#fileselector"> <i class="fas fa-plus"></i> Add New</button>

                                <div class="modal fade" id="fileselector" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Add Notes</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST" enctype="multipart/form-data" id="myForm">
                                                    <div class="form-group">
                                                        <label>Class</label>
                                                        <select name="class" onchange="attendanceGetSubjects(this)" class="custom-select" required>
                                                            <option value="">Select Class</option>
                                                            <?php
                                                            while ($row = mysqli_fetch_array($classes)) {
                                                                echo "<option value='$row[0]'>$row[1] ($row[2])</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Subject</label>
                                                        <select name="subject" id="subjects" class="custom-select" required>
                                                            <option value="">Select Subject</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" name="title" placeholder="Enter Title" class="form-control" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea name="description" cols="10" rows="5" class="form-control" placeholder="Enter Description" required></textarea>
                                                    </div>
                                                    <label>Attachment</label>
                                                    <div class="mb-3 custom-file">
                                                        <input type="file" id="attachment" name="attachment" class="custom-file-input" required>
                                                        <label class="custom-file-label">Choose a file</label>
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
                                <table class="table table-striped table-bordered">
                                    <tr class="bg-primary text-center">
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Attachment</th>
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
                                            <td><?php echo $row[7] ?></td>
                                            <td><?php echo "$row[11] ($row[10])"?></td>
                                            <td class="text-center" style="max-width:200px; word-wrap:break-word;">
                                                <?php
                                                if ($row[5] == "")
                                                    echo "<span class='text-danger'>No Attachment</span>";
                                                else
                                                    echo "<a href='../attachments/Notes/$row[5]'>$row[5]</a>";
                                                ?>
                                            </td>
                                            <td style="width:150px;" class="text-center">
                                                <a href='edit-notes.php?id=<?php echo $row[0]; ?>' class="mx-2"><i class='fas fa-edit'></i></a>
                                                <button class="btn text-danger" onclick="if(confirm('are you sure?'))document.location = 'delete.php?c=notes&id=<?php echo $row[0]; ?>'"><i class="fa fa-trash-alt"></i></button>
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
    <script>
        $('#attachment').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>
</body>
</html>

<?php
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