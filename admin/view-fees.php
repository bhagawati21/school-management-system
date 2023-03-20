<?php
    session_start();
    if ($_SESSION['userid'] == "") {
        header("location:admin-login.php");
    }
    include "../include/config.php";
    
    if (!isset($_GET['cid']))
        header("location:set-fees.php");

    $cid = $_GET['cid'];
    $query = "SELECT `fees`.*, `classes`.* FROM `fees` LEFT JOIN `classes` ON `fees`.`ClassId` = `classes`.`id` WHERE ClassId='$cid'";
    $result = mysqli_query($conn, $query);
    $classdata = mysqli_fetch_array($result);
    $fees = unserialize($classdata[2]);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Fees</title>
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
                            <li class="breadcrumb-item"><a href="set-fees.php">Set Fees</a></li>
                            <li class="breadcrumb-item active" aria-current="page">View Fees</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-1 rounded">View Fees</h3>
                    </div>
                    <div class="col-11 my-2 attendance-div border mx-auto border-primary rounded shadow px-5 pt-4 bg-light">
                        <div class="col-12 text-center">
                            <h5 class="font-weight-bold">Fee Structure Class : <?php echo "$classdata[5] ( $classdata[6] )" ?></h5>
                        </div>
                        <table class="table table-striped my-4">
                            <tr class="bg-primary">
                                <th>#</th>
                                <th>Fee Type</th>
                                <th style="width: 20%;">Amount</th>
                            </tr>
                            <?php
                                $sno = 1;
                                if(empty($fees))
                                    echo "<tr><td class='text-danger text-center font-weight-bold' colspan='3' style='font-size:18pt;'>There is no data to show</td></tr>";
                                foreach ($fees as $feetype => $amount) {
                                    echo "<tr>
                                            <td>$sno</td>
                                            <td>$feetype</td>
                                            <td><i class='far fa-rupee-sign'></i> $amount</td>
                                          </tr>";
                                    $sno++;    
                                }
                            ?>
                            <tr>
                                <th colspan="2" class="p-3 pl-5">Total</th>
                                <th><i class='far fa-rupee-sign'></i> <?php echo $classdata[3]?></th>
                            </tr>
                        </table>
                    </div>
                </div> <!--row-->
            </div> <!--container-fluid-->
        </div> <!--wrapper-content-->
    </div> <!--wrapper-->
</body>
</html>