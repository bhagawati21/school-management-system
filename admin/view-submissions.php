<?php
session_start();
error_reporting(0);
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
if (!isset($_GET['cid']) || !isset($_GET['id']))
    header("location: assignments.php");
else {
    $cid = $_GET['cid'];
    $id = $_GET['id'];
}
include "../include/config.php";
$query = "SELECT * FROM students WHERE ClassId = '$cid'";
$result = mysqli_query($conn, $query);
$query = "SELECT * FROM assignment_submissions WHERE AssignmentId = '$id'";
$r = mysqli_query($conn, $query);
$assignment = mysqli_query($conn, "SELECT * FROM assignments WHERE id='$id'");
$assignmentdata = mysqli_fetch_array($assignment);
if (!$result || !$assignment || !$r) {
    echo "<script>alert(\"SQL Error :: " . mysqli_error($conn) . "\")</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submissions</title>
    <?php
    include "includes/includes.php";
    ?>
    <style>
        .dataTables_scrollHeadInner {
            width: 100% !important;
        }

        .table {
            width: 100% !important;
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
                                <li class="breadcrumb-item"><a href="assignments.php">Assignments</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Submissions</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-2 rounded">View Submissions</h3>
                    </div>
                    <div class="col-md-11 col-sm-7 my-2 mx-auto p-4 bg-white rounded shadow border border-primary">
                        <div class="row">
                            <div class="col-12 mx-auto">
                                <table class="table table-secondary text-center">
                                    <tr>
                                        <th>Assignment Title : </td>
                                        <td class="text-left"><?php echo $assignmentdata[1] ?></td>
                                        <th>Due Date : </td>
                                        <td class="text-left"><?php echo date("d-m-Y h:i A", strtotime($assignmentdata[4])) ?></td>
                                    </tr>
                                </table>
                                <table id="table" class="table table-striped table-bordered text-center display">
                                    <thead>
                                        <tr class="bg-primary text-center">
                                            <th>#</th>
                                            <th>Roll No.</th>
                                            <th>Student Name</th>
                                            <th>Submission Status</th>
                                            <th>Submission Time</th>
                                            <th>Attachment</th>
                                            <th>Comments</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sno = 1;
                                    while ($students = mysqli_fetch_array($result)) {
                                        $submissions = mysqli_fetch_array($r);
                                    ?>
                                        <tr>
                                            <td><?php echo $sno ?></td>
                                            <td><?php echo $students[1] ?></td>
                                            <td class="text-left"><?php echo $students[3] ?></td>
                                            <td>
                                                <?php
                                                if ($submissions[0])
                                                    echo "<span style='color:#00a100' class='text-bold'>Submitted</span>";
                                                else if (date("Y-m-d H:i:s") > $assignmentdata[4])
                                                    echo "<span style='color:#e00000;' class='text-bold'>Missing!</sapn>";
                                                else
                                                    echo "<span class='text-info text-bold'>Assigned</sapn>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $submissions[6] == "" ? "-" : date("d-m-Y h:i A", strtotime($submissions[6]));
                                                if ($submissions[6] > $assignmentdata[4])
                                                    echo "<br><span style='color:#faa307; font-weight:bolder;'>Done Late</span>";
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                echo $submissions[5] == "" ? "-" : "<a href='../attachments/$submissions[5]'>$submissions[5]</a>";
                                                ?>
                                            </td>
                                            <td><?php echo $submissions[4] == "" ? "-" : "$submissions[4]"; ?></td>
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
            $('#table').DataTable({
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
                    "targets": [5, 6]
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
                                    columns: [0, 1, 2, 3, 4, 5, 6]
                                }
                            },
                            {
                                extend: "pdfHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6]
                                }

                            },
                            {
                                extend: "excelHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6]
                                }
                            },
                            {
                                extend: "csvHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6]
                                }
                            }
                        ]
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6],
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