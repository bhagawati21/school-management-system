<?php
session_start();
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
include "../include/config.php";

$query = "SELECT `assignments`.*, `classes`.* FROM `assignments` LEFT JOIN `classes` ON `assignments`.`ClassId` = `classes`.`id`";
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
    <title>Assignments</title>
    <?php
    include "includes/includes.php";
    ?>
    <style>
        .dataTables_scrollHeadInner{
            width: 100%!important;
        }
        table{
            width: 100%!important;
        }
        .dropdown-menu {
            background-color: #007bff !important;
        }
        .dataTables_length,
        .dataTables_filter {
            margin-left: 10px;
            float: right;
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
                                <li class="breadcrumb-item active" aria-current="page">Assignments</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-2 rounded">Assignments</h3>
                    </div>
                    <div class="col-md-11 col-sm-7 my-2 mx-auto p-4 bg-white rounded shadow border border-primary">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#fileselector"> <i class="fas fa-plus"></i> Add New</button>

                                <div class="modal fade" id="fileselector" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Add Assignment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST" enctype="multipart/form-data" id="myForm">
                                                    <div class="form-group">
                                                        <label>Class</label>
                                                        <select name="class" class="custom-select" required>
                                                            <option value="">Select Class</option>
                                                            <?php
                                                                while ($row = mysqli_fetch_array($classes)) {
                                                                    echo "<option value='$row[0]'>$row[1] ($row[2])</option>";
                                                                }
                                                            ?>
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
                                                    <label>Attachment (optional)</label>
                                                    <div class="mb-3 custom-file">
                                                        <input type="file" id="attachment" name="attachment"  class="custom-file-input">
                                                        <label class="custom-file-label">Choose a file</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Due Date</label>
                                                        <input type="datetime-local" name="date" class="form-control" required>
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
                                <table class="table table-striped table-bordered display">
                                    <thead>
                                        <tr class="bg-primary text-center">
                                            <th>#</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Due Date</th>
                                            <th>Class</th>
                                            <th>Attachment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sno = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $sno?></td>
                                            <td><?php echo $row[1]?></td>
                                            <td style="max-width:500px"><?php echo $row[2]?></td>
                                            <td><?php echo date("d-m-Y h:i A",strtotime($row[4]))?></td>
                                            <td><?php echo $row[7]?></td>
                                            <td class="text-center">
                                                <?php
                                                    if($row[5] == "")
                                                        echo "<span class='text-danger'>No Attachment</span>";
                                                    else
                                                        echo "<a href='../attachments/$row[5]'>$row[5]</a>";
                                                ?>
                                            </td>
                                            <td style="width:150px;" class="text-center">
                                                <a href='edit-assignment.php?id=<?php echo $row[0];?>' class="mx-2"><i class='fas fa-edit'></i></a>
                                                <button class="btn text-danger" onclick="if(confirm('are you sure?'))document.location = 'delete.php?c=assignment&id=<?php echo $row[0];?>'"><i class="fa fa-trash-alt"></i></button>
                                                <a href="view-submissions.php?cid=<?php echo $row[3];?>&id=<?php echo $row[0];?>" class="btn text-primary"><i class="fa fa-arrow-right"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        $sno++;
                                    }
                                    ?>
                                    </tbody>
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

        $(document).ready(function() {
            $('.table').DataTable({
                "scrollY": "340px",
                "scrollCollapse": false,
                "infoEmpty": "No records available",
                "sProcessing": "DataTables is currently busy",
                "processing": true,
                "paging": true,
                "info": false,
                "responsive": true,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [6]
                }],
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'collection',
                        className: "bg-primary",
                        text: 'Export',
                        buttons: [{
                                extend: "copyHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }
                            },
                            {
                                extend: "pdfHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }

                            },
                            {
                                extend: "excelHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }
                            },
                            {
                                extend: "csvHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5]
                                }
                            }
                        ]
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                            stripHtml: false
                        }
                    }
                ],
                initComplete: function() {
                    var btns = $('.btn-group *');
                    btns.addClass('btn-primary');
                    btns.removeClass('btn-secondary');
                }
            });
        });
    </script>
</body>
</html>

<?php
    if (isset($_POST['add'])) 
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $class = $_POST['class'];
    
        if($_FILES['attachment'] && $_FILES['attachment']['error'] == 0)
        {
            $path = "../attachments/".$_FILES['attachment']['name'];
            $r = move_uploaded_file($_FILES['attachment']['tmp_name'],$path);
    
            if($r)
                $attachment = $_FILES['attachment']['name'];
            else
                echo "<script>errorNotification('There was some problem in uploading the file.')</script>";
        }
        if(!isset($attachment))
            $attachment = NULL;
        $query = "INSERT INTO assignments VALUES(NULL,'$title','$description','$class','$date','$attachment')";
        $result = mysqli_query($conn, $query);
    
        if ($result)
            echo "<script>document.location = 'assignments.php?T=success&NM=Assignment Added Successfully'</script>";
        else
            echo "<script>alert(\"". mysqli_error($conn) ."\")</script>";
        
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