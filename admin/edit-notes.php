<?php
session_start();
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
include "../include/config.php";

if (isset($_GET['id']) && $_GET['id'] != "") {
    $id = $_GET['id'];

    $query = "SELECT `notes`.*, `classes`.*, `subjects`.* FROM `notes` LEFT JOIN `classes` ON `notes`.`ClassId` = `classes`.`id` LEFT JOIN `subjects` ON `notes`.`SubjectId` = `subjects`.`id` WHERE `notes`.`id`='$id'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Notes</title>
    <?php include "includes/includes.php"; ?>
    <style>
        select:disabled {
            color: #111 !important;
        }
    </style>
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
                                <li class="breadcrumb-item"><a href="notes.php">Notes</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Notes</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-1 rounded">Edit Notes</h3>
                    </div>
                    <div class="col-9 pt-5 my-2 attendance-div border mx-auto border-primary rounded shadow px-5 bg-light">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Class</label>
                                <select name="class" class="custom-select" disabled>
                                    <option value=""><?php echo $row[7]; ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <select name="subject" class="custom-select" disabled>
                                    <option value=""><?php echo "$row[11] ($row[10])"?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" value="<?php echo $row[1] ?>" placeholder="Enter Title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" cols="10" rows="5" class="form-control" placeholder="Enter Description" required><?php echo $row[2] ?></textarea>
                            </div>
                            <label>Attachment</label>
                            <div class="mb-3 custom-file">
                                <input type="file" name="attachment" id="attachment" class="custom-file-input">
                                <label class="custom-file-label"><?php echo ($row[5] == "") ? "No file selected" : $row[5] ?></label>
                            </div>
                            <div class="text-center mt-4 mb-3">
                                <input type="submit" value="Update" class="btn btn-primary my-2" name="update">
                            </div>
                        </form>
                    </div>
                </div>
                <!--row-->
            </div>
            <!--container-fluid-->
        </div>
        <!--wrapper-content-->
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
    } else {
        echo "<script>alert('ERROR :: some sql query error.');";
        echo "document.location = 'notes.php'</script>";
    }
} else
    header("location: notes.php");

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if ($_FILES['attachment'] && $_FILES['attachment']['error'] == 0) {
        $path = "../attachments/Notes/" . $_FILES['attachment']['name'];
        $r = move_uploaded_file($_FILES['attachment']['tmp_name'], $path);

        if ($r)
            $attachment = $_FILES['attachment']['name'];
        else
            echo "<script>alert('There was some problem in uploading the file.')</script>";
    }

    if (isset($attachment)) {
        unlink("../attachments/Notes/" . $row[5]);
        $query = "UPDATE notes SET Title='$title',`Description`='$description',attachment='$attachment' WHERE id='$id'";
    } else
        $query = "UPDATE notes SET Title='$title',`Description`='$description' WHERE id='$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>document.location = 'notes.php?T=success&NM=Record Updated Successfully';</script>";
    } else
        echo "<script>alert(\"" . mysqli_error($conn) . "\")</script>";
}
?>