<?php
    session_start();
    if ($_SESSION['userid'] == "") {
        header("location:admin-login.php");
    }
    include "../include/config.php";
    
    $query = "SELECT `fees`.*, `classes`.* FROM `fees` LEFT JOIN `classes` ON `fees`.`ClassId` = `classes`.`id`;";
    $classes = mysqli_query($conn, $query);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Fees</title>
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
                            <li class="breadcrumb-item active" aria-current="page">Set Fees</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-1 rounded">Set Fees</h3>
                    </div>
                    <div class="col-11 my-2 attendance-div border mx-auto border-primary rounded shadow px-5 pt-4 bg-light">
                        <table class="table table-striped">
                            <tr class="bg-primary">
                                <th>#</th>
                                <th>Class</th>
                                <th>Total Fees</th>
                                <th class="text-center" style="width:30%;">Action</th>
                            </tr>
                            <?php
                                $sno = 1;
                                while ($classdata = mysqli_fetch_array($classes)) 
                                {
                                    echo "<tr>
                                            <td>$sno</td>
                                            <td>$classdata[5] ($classdata[6])</td>
                                            <td><i class='far fa-rupee-sign'></i> $classdata[3]</td>
                                            <td class='text-center'>
                                                <button class='btn btn-outline-primary' onclick=\"document.location = 'update-fees.php?cid=$classdata[1]'\"><i class='far fa-edit'></i></button>
                                                <button class='btn btn-outline-secondary' onclick=\"document.location = 'view-fees.php?cid=$classdata[1]'\"><i class='far fa-arrow-alt-right'></i></button>
                                            </td>
                                          </tr>";    
                                    $sno++;
                                 }
                            ?>
                        </table>
                    </div>
                </div> <!--row-->
            </div> <!--container-fluid-->
        </div> <!--wrapper-content-->
    </div> <!--wrapper-->
</body>
</html>