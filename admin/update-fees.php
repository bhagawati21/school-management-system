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
    <title>Update Fees</title>
    <?php
        include "includes/includes.php";
    ?>
    <style>
        [id*="amount"]::before, #total::before{
            content: "\20B9  ";
            font-size: 15pt;
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
                                <li class="breadcrumb-item"><a href="set-fees.php">Set Fees</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Update Fees</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-1 rounded">Update Fees</h3>
                    </div>
                    <div class="col-11 my-2 attendance-div border mx-auto border-primary rounded shadow px-5 pt-3 bg-light">
                        <div class="col-12 text-center">
                            <h5 class="font-weight-bold">Fee Structure Class : <?php echo "$classdata[5] ( $classdata[6] )" ?></h5>
                        </div>
                        <form action="" method="POST" id="feesForm" onsubmit="validation()">
                            <input type="hidden" name="class" value="<?php echo $classdata[1] ?>">
                            <div class="form-row mt-4 mb-3">
                                <div class="form-group col-md-5">
                                    <label>Fee Type</label>
                                    <input type="text" name="feetype" class="form-control" placeholder="Enter Fee Type">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Amount</label>
                                    <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                                </div>
                                <div id="dynamic-input">
                                </div>
                                <div class="form-group col-2 ml-auto mt-auto">
                                    <button class="btn btn-primary" type="button" onclick="updatefee()">Add to list</button>
                                </div>
                            </div>
                        </form>
                        <table class="table mt-5">
                            <tr class="bg-primary">
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th style="width: 100px;">Action</th>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table class="table">
                                        <tbody id="fees">
                                            <?php
                                            if(empty($fees))
                                            echo "<tr><td class='text-danger text-center font-weight-bold' colspan='3' style='font-size:18pt;'>There is no data to show</td></tr>";
                                            $sno = 1;
                                            foreach ($fees as $feetype => $amount) {
                                            ?>
                                                <tr id='row<?php echo $sno?>'>
                                                    <td id='fee<?php echo $sno?>'><?php echo $feetype ?></td>
                                                    <td id='amount<?php echo $sno?>' class='text-left'><?php echo $amount ?></td>
                                                    <td style='width:100px' class='text-center'>
                                                        <button type='button' class='btn text-danger' onclick='deleteRow("row<?php echo $sno?>","amount<?php echo $sno?>","fee<?php echo $sno?>")'><i class='fas fa-times'></i></button>
                                                    </td>
                                                </tr>
                                            <?php
                                                $sno++;
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th class="pl-4">Total</th>
                                <th class="text-left" colspan="2"><span id="total"><?php echo $classdata[3]?></span></th>
                            </tr>
                        </table>
                        <div class="form-group text-center my-4">
                            <input type="submit" form="feesForm" name="update" value="Update" class="btn btn-primary">
                        </div>
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
        var sno = <?php echo $sno;?>;
        var ft = [];
        var fa = [];
        <?php
            foreach ($fees as $feetype => $amount) {
        ?>
            ft.push("<?php echo $feetype?>");
            fa.push(<?php echo $amount?>);
        <?php
            }
        ?>
        const myForm = document.forms['feesForm'];
        var total = document.getElementById('total');
        var amount = myForm['amount'];
        var feeType = myForm['feetype'];
        var fees = document.getElementById('fees');

        function updatefee() {
            event.preventDefault();
            if (feeType.value === "" || amount.value === "") {
                warningNotification("Please fill all the fields.");
                return;
            }
            if (ft.indexOf(feeType.value) !== -1) {
                warningNotification("Added already");
                return;
            }
            ft.push(feeType.value);
            fa.push(parseFloat(amount.value));
            total.innerHTML = parseFloat(total.innerHTML) + parseFloat(amount.value);
            var output = `<tr id='row${sno}'><td id='fee${sno}'>${feeType.value}</td><td id='amount${sno}' class='text-left'>${amount.value}</td><td style='width:100px' class='text-center'><button type='button' class='btn text-danger' onclick='deleteRow("row${sno}","amount${sno}","fee${sno}")'><i class='fas fa-times'></i></button></td></tr>`;
            fees.innerHTML += output;
            sno++;
        }

        function deleteRow(rowId, amountId, feeTypeId) {
            var amt = parseFloat(document.getElementById(amountId).innerHTML);
            var fee = document.getElementById(feeTypeId).innerHTML;

            var index = ft.indexOf(fee);
            if (index !== -1) {
                ft.splice(index, 1);
                fa.splice(index, 1);
            }
            document.getElementById(rowId).remove();
            total.innerHTML = parseFloat(total.innerHTML) - amt;
        }

        function validation() {
            document.getElementById('dynamic-input').innerHTML = `<input type="hidden" name="feetype" value='${JSON.stringify(ft)}'><input type="hidden" name="feeamount" value='${JSON.stringify(fa)}'>`;
        }
    </script>
</body>
</html>

<?php
    if(isset($_POST['update'])) {
        $classid = $_POST['class'];
        $feetype = json_decode($_POST['feetype']);
        $amount = json_decode($_POST['feeamount']);
        $fees = array_combine($feetype, $amount);
        $serializedfees = serialize($fees);
        $total = array_sum($amount);

        $query = "UPDATE fees SET Fees='$serializedfees',Total='$total' WHERE ClassId='$classid'";
        $result = mysqli_query($conn, $query);
        if ($result)
            echo "<script>document.location = 'update-fees.php?cid=$classid&T=success&NM=Fees Updated Successfully'</script>";
        else
            echo "<script>alert(\"".mysqli_error($conn)."\")</script>";
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