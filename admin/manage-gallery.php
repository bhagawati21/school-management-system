<?php
session_start();
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gallery</title>
    <?php
    include "includes/includes.php";
    ?>
    <style>
        .custom-btn:hover {
            background-color: #ddd !important;
        }

        .custom-img {
            height: 200px !important;
        }

        #image-div {
            width: 300px;
            height: 300px;
            margin: 55px auto 5px;
        }

        #image {
            width: 300px;
            border-radius: 5px;
        }
    </style>
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
                                <li class="breadcrumb-item active" aria-current="page">Manage Gallery</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-2 rounded">Manage Gallery</h3>
                    </div>
                    <div class="col-md-11 col-sm-7 my-2 mx-auto p-4 bg-white rounded shadow border border-primary">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#fileselector"> <i class="fas fa-plus"></i> Add New Photo</button>

                                <div class="modal fade" id="fileselector" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Choose file</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" id="myForm" method="POST" enctype="multipart/form-data">
                                                    <div class="custom-file">
                                                        <input type="file" id="photo" name="photo" class="custom-file-input" onchange="show()" accept=".jpg,.png,.jpeg" required>
                                                        <label class="custom-file-label">Choose image</label>
                                                    </div>
                                                    <div id="image-div">
                                                        <img id="image" src="../img/image.png" alt="image">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger mr-5" data-dismiss="modal"><i class="far fa-times"></i> Close</button>
                                                <button type="submit" name="upload" form="myForm" class="btn btn-primary"><i class="far fa-upload"></i> Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $path = '../img/slider';
                            $images = array_diff(scandir($path), array('.', '..'));
                            $sno = 1;
                            foreach ($images as $value) {
                                echo "<div class='col-md-4'>
                                            <div class='card my-4' style='width: 18rem;'>
                                            <img class='custom-img card-img-top img-thumbnail' src='../img/slider/" . $value . "' alt='slider img'>
                                            <div class='card-body text-center'>
                                                <button role='button' data-toggle='modal' data-target='#img" . $sno . "' class='custom-btn btn btn-primary bg-white border-0 mr-5'><i class='fas fa-eye text-dark'></i> View</button>
                                                <a href='delete.php?c=image&name=" . $value . "' class='custom-btn btn btn-primary bg-white border-0'><i class='fas fa-trash text-danger'></i><span class='text-danger'> Delete</span></a>
                                            </div>
                                        </div>
                                    </div>";
                            ?>
                                <!-- Modal -->
                                <div class="modal fade" id="img<?php echo $sno ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img src="../img/slider/<?php echo $value ?>" width="100%">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $sno++;
                            }
                            ?>
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
        $('#photo').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>
</body>
</html>

<?php
    if (isset($_POST['upload'])) {
        if ($_FILES['photo'] && $_FILES['photo']['error'] == 0) {
            $path = "../img/slider/" . $_FILES['photo']['name'];
            $r = move_uploaded_file($_FILES['photo']['tmp_name'], $path);
    
            if ($r)
                echo "<script>document.location = 'manage-gallery.php?T=success&NM=Photo Uploaded Successfully'</script>";
            else
                echo "<script>errorNotification('There was some problem in uploading the file.')</script>";
        }
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