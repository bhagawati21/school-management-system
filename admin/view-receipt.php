<?php
session_start();
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
include "../include/config.php";
if(!isset($_GET['id']))
    header("location: payments.php");
$id = $_GET['id'];
$query = "SELECT `payments`.*, `students`.*, `classes`.* FROM `payments` LEFT JOIN `students` ON `payments`.`StudentId` = `students`.`id` LEFT JOIN `classes` ON `payments`.`ClassId` = `classes`.`id` WHERE payments.id='$id'";
$r = mysqli_query($conn, $query);
if (!$r) {
    echo "<script>alert('There was some problem while fetching the data')</script>";
}
$row = mysqli_fetch_array($r);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Receipt</title>
    <?php
    include "includes/includes.php";
    ?>
    <style>
        @media print {
            .btn{
                visibility: hidden!important;
            }
            body *{
                visibility: hidden;
            }
            #section-to-print, #section-to-print * {
                visibility: visible;
            }
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
                                <li class="breadcrumb-item"><a href="payments.php">Payments</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Receipt</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-2 rounded">View Receipt</h3>
                    </div>
                    <div id="section-to-print" class="col-md-11 col-sm-7 my-2 mx-auto p-4 bg-white rounded shadow border border-primary">
                        <div class="row">
                            <div class="col-6 mt-4 mx-auto">
                                <h4 class="text-center text-primary font-weight-bold">Personal Details</h4>
                                <table class="table table-borderless table-sm">
                                    <tr>
                                        <th>Name</th>
                                        <th style="width: 15%;">:</th>
                                        <td><?php echo $row['Name']?></td>
                                    </tr>
                                    <tr>
                                        <th>Class</th>
                                        <th>:</th>
                                        <td><?php echo $row['ClassName']." ( ".$row['ClassNameNumeric']." )"?></td>
                                    </tr>
                                    <tr>
                                        <th>Mother's Name</th>
                                        <th>:</th>
                                        <td><?php echo $row['MotherName']?></td>
                                    </tr>
                                    <tr>
                                        <th>Father's Name</th>
                                        <th>:</th>
                                        <td><?php echo $row['FatherName']?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number</th>
                                        <th>:</th>
                                        <td><?php echo $row['PhoneNumber']?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <th>:</th>
                                        <td><?php echo $row['Email']?></td>
                                    </tr>
                                </table>
                            </div>
                            <?php
                                $cid = $row['ClassId'];
                                $result = mysqli_query($conn, "SELECT * FROM fees WHERE ClassId='$cid'");
                                $row1 = mysqli_fetch_array($result);
                                $fees = unserialize($row1[2]);
                            ?>
                            <div class="col-6 mt-4 mx-auto">
                                <h4 class="text-center text-primary font-weight-bold">Fee Details</h4>
                                <table class="table table-borderless table-sm">
                                    <tr class="bg-primary">
                                        <th>#</th>
                                        <th>Fee Type</th>
                                        <th>Amount</th>
                                    </tr>
                                    <?php
                                        $sno = 1;
                                        foreach ($fees as $feetype => $amount) {
                                    ?>
                                        <tr>
                                            <td><?php echo $sno; ?></td>
                                            <td><?php echo $feetype; ?></td>
                                            <td><i class="far fa-rupee-sign"></i> <?php echo $amount; ?></td>
                                        </tr>
                                    <?php
                                        $sno++;}
                                    ?>
                                    <tr>
                                        <th colspan="2" >Total</th>
                                        <th><i class="far fa-rupee-sign"></i> <?php echo $row1[3]?></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-11 mx-auto">
                                <h4 class="text-center text-primary font-weight-bold">Payment Details</h4>
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Amount Paid</th>
                                        <th>:</th>
                                        <td><i class="far fa-rupee-sign"></i> <?php echo $row['Amount']?></td>
                                    </tr>
                                    <tr>
                                        <th>Outstanding Balance</th>
                                        <th>:</th>
                                        <td><i class="far fa-rupee-sign"></i> <?php echo $row['Outstanding']?></td>
                                    </tr>
                                    <tr>
                                        <th>Payment Date</th>
                                        <th>:</th>
                                        <td><?php echo date("d-m-Y h:i A",strtotime($row['Date']))?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="text-center col-md-12">
                                <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                            </div>
                        </div>
                    </div>
                </div><!--row-->
            </div><!--container-fluid-->
        </div><!--content-wrapper-->
    </div><!--wrapper-->
</body>
</html>