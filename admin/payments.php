<?php
session_start();
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
include "../include/config.php";
$query = "SELECT `payments`.*, `students`.*, `classes`.* FROM `payments` LEFT JOIN `students` ON `payments`.`StudentId` = `students`.`id` LEFT JOIN `classes` ON `payments`.`ClassId` = `classes`.`id` ORDER BY `Date` DESC";
$r = mysqli_query($conn, $query);
if (!$r) {
    echo "<script>alert('There was some problem while fetching the data')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <?php
    include "includes/includes.php";
    ?>
    <script src="js/moment.min.js"></script>
    <style>
        .dataTables_scrollHeadInner {
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

        table {
            width: 100% !important;
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
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb my-0 ">
                                <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Payments</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 rounded">Payments</h3>
                    </div>
                    <div class="col-md-11 col-sm-7 my-2 mx-auto p-4 bg-white rounded shadow border border-primary">
                        <div class="row">
                            <div class="col-5">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#paymentModal"> <i class="fas fa-plus"></i> Take Payment</button>

                                <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Take Payment</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST" enctype="multipart/form-data" id="myForm">
                                                    <div class="form-group">
                                                        <select name="classid" class="custom-select" onchange="getStudents(this);getFees(this);" required>
                                                            <option value="">Select Class</option>
                                                            <?php
                                                            $query = "SELECT * FROM classes";

                                                            $result = mysqli_query($conn, $query);
                                                            if ($result) {
                                                                if (mysqli_num_rows($result) > 0) {
                                                                    while ($row = mysqli_fetch_array($result))
                                                                        echo "<option value='$row[0]'>$row[1] ( $row[2] )</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-goup">
                                                        <select name="studentid" class="custom-select" onchange="getBalance(this)" id="sname" required>
                                                            <option value="">Select name</option>
                                                            <!-- student names will be automatically fetched. -->
                                                        </select>
                                                    </div>
                                                    <div class="my-3">
                                                        <table class="table table-striped table-borderless table-sm">
                                                            <tr class="text-center">
                                                                <th colspan="3">Fee Structure</th>
                                                            </tr>
                                                            <tr class="bg-primary">
                                                                <th>#</th>
                                                                <th>Fee Type</th>
                                                                <th>Amount</th>
                                                            </tr>
                                                            <tbody id="feesDiv">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="form-group" id="balance">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Amount</label>
                                                        <input type="number" onkeyup="updateOutstanding(this)" name="amount" class="form-control" placeholder="Enter Amount">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Remarks</label>
                                                        <textarea name="remarks" rows="3" class="form-control" placeholder="Enter Remarks"></textarea>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times"></i> Close</button>
                                                <button type="submit" form="myForm" class="btn btn-primary" name="add">Take Payment</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7">
                                <form>
                                    <div class="form-row">
                                        <div class="col-3 text-center">
                                            <label class="my-0 mt-1">Filter By Date :</label>
                                        </div>
                                        <div class="col">
                                            <input class="form-control" type="text" id="min" name="min" placeholder="To">
                                        </div>
                                        <div class="col">
                                            <input class="form-control" type="text" id="max" name="max" placeholder="From">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 mt-4 mx-auto">
                                <table id="table" class="table display table-striped">
                                    <thead>
                                        <tr class="bg-primary">
                                            <th style="width: 3%;">#</th>
                                            <th style="width: 15%;">Student Name</th>
                                            <th style="width: 11%;">Class</th>
                                            <th style="width: 19%;">Payment Date</th>
                                            <th style="width: 10%;">Amount</th>
                                            <th style="width: 10%;">Outstanding Balance</th>
                                            <th>Remarks</th>
                                            <th style="width: 10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sno = 1;
                                        while ($row = mysqli_fetch_array($r)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $sno ?></td>
                                                <td><?php echo $row['Name'] ?></td>
                                                <td><?php echo $row['ClassName'] . " (" . $row['ClassNameNumeric'] . ")" ?></td>
                                                <td><?php echo date("Y-m-d h:i A", strtotime($row['Date'])) ?></td>
                                                <td><i class="far fa-rupee-sign"></i> <?php echo $row['Amount'] ?></td>
                                                <td><i class="far fa-rupee-sign"></i> <?php echo $row['Outstanding'] ?></td>
                                                <td class="text-center"><?php echo $row['Remarks'] == "" ? "-" : $row['Remarks'] ?></td>
                                                <td class="text-center">
                                                    <a href="view-receipt.php?id=<?php echo $row[0] ?>"><i class="fa fa-eye"></i></a>
                                                    <button class="btn text-danger" onclick="if(confirm('are you sure?'))document.location = 'delete.php?c=payment&id=<?php echo $row[0]; ?>'"><i class="fa fa-trash-alt"></i></button>
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
        function updateOutstanding(amount) {
            let amt = $("#outstandingduplicate").val();
            $("#outstanding").val(amt - amount.value);
        }
        
        var minDate, maxDate;

        // Custom filtering function which will search data in column four between two values
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date(data[3]);
                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );

        $(document).ready(function() {
            // Create date inputs
            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });

            // DataTables initialisation
            var table = $('#table').DataTable({
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
                    "targets": [7]
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

            // Refilter the table
            $('#min, #max').on('change', function() {
                table.draw();
            });
        });
    </script>
</body>

</html>

<?php
if (isset($_POST['add'])) {
    $classid = $_POST['classid'];
    $studentid = $_POST['studentid'];
    $remarks = $_POST['remarks'];
    $amount = $_POST['amount'];
    $outstanding = $_POST['outstanding'];

    $query = "INSERT INTO payments VALUES(NULL,'$studentid','$classid','$amount','$outstanding','$remarks',NULL)";
    $result = mysqli_query($conn, $query);

    if ($result)
        echo "<script>document.location = 'payments.php?T=success&NM=Payment Recieved'</script>";
    else
        echo "<script>alert(\"". mysqli_error($conn) ."\")</script>";
}
if (isset($_GET['NM']) && $_GET['T']) {
    $msg = $_GET['NM'];
    if ($_GET['T'] == "error")
        echo "<script>errorNotification('" . $msg . "')</script>";
    else if ($_GET['T'] == "success")
        echo "<script>successNotification('" . $msg . "')</script>";
    else if ($_GET['T'] == "warning")
        echo "<script>warningNotification('" . $msg . "')</script>";
    else if ($_GET['T'] == "info")
        echo "<script>infoNotification('" . $msg . "')</script>";
}
?>