<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";
    
    $query = "SELECT * FROM `classes`";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0)
    {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
    <style>
        .table-div{
            overflow-y: scroll;
            height: 480px;
        }
        .dataTables_scrollHeadInner{
            width: 100%!important;
        }
        table{
            width: 100%!important;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .del-btn:hover{
            color:red!important;
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
    <?php 
        include "includes/includes.php";
    ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <?php include "includes/navbar.php" ?>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="pt-1">
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb my-0">
                        <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Classes</li>
                    </ol>
                    </nav>
                </div>
                <h3 class="h3 text-center heading-2 text-primary rounded" style="background-color: #E9ECEF">Manage Classes</h3>
                <div id="table-div" class="table-div rounded table-responsive">
                    <table id="table" class="table bg-light table-striped display text-center">
                        <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Class Name</th>
                            <th scope="col">Class Name Numeric</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                    <?php
                        $sno = 1;
                        while($row = mysqli_fetch_array($result))
                        {
                    ?>
                            <tr>
                                <td><?php echo $sno ?></td>
                                <td><?php echo $row[1] ?></td>
                                <td><?php echo $row[2] ?></td>
                                <td>
                                    <a href='<?php echo "edit-class.php?ClassId=$row[0]" ?>'><i class="fa fa-edit"></i></a>
                                    <button class="btn del-btn ml-3 text-danger" onclick="if(confirm('are you sure?'))document.location = 'delete.php?c=class&id=<?php echo $row[0];?>'"><i class="fa fa-trash-alt"></i></button>
                                </td>
                            </tr>
                    <?php
                            $sno++;    
                        }
                        echo "</tbody></table>";
                        }
                    ?>
                </div>
            </div> <!--Container-fluid-->
        </div> <!--content-wrapper-->
    </div>  <!--wrapper-->
    <script>
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
                    "targets": [3]
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
                                    columns: [0, 1, 2]
                                }
                            },
                            {
                                extend: "pdfHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2]
                                }

                            },
                            {
                                extend: "excelHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2]
                                }
                            },
                            {
                                extend: "csvHtml5",
                                className: "bg-primary",
                                exportOptions: {
                                    columns: [0, 1, 2]
                                }
                            }
                        ]
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2],
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
        $('#table-div').overlayScrollbars({
            scrollbars : {
                visibility : 'hidden',    //visible || hidden || auto || v || h || a
                // autoHide : 'leave',     //never || scroll || leave || n || s || l
                // autoHideDelay : 200,    //number
                // dragScrolling : true,   //true || false
                // clickScrolling : false, //true || false
                // touchSupport : true,     //true || false
                // snapHandle: true     //true || false
            }
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