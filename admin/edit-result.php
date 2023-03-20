<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";

    $id = $_REQUEST['id'];

    $query = "SELECT `results`.`MarksAll`, `results`.`StudentId`, `students`.`Name`, `classes`.* FROM `results` LEFT JOIN `students` ON `results`.`StudentId` = `students`.`id` LEFT JOIN `classes` ON `results`.`ClassId` = `classes`.`id` WHERE `results`.id = '$id';";

    $result = mysqli_query($conn, $query);
    if($result)
    {
        if(mysqli_num_rows($result) == 1)
        {
            $row = mysqli_fetch_array($result);
        }
        else
        {
            header("location:manage-results.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Result</title>
    <?php include "includes/includes.php"; ?>
    <style>
        .form-div{
            overflow-y: scroll;
            height: 430px;           
        }
        .input-group-text{
            width: 45px!important;
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
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php"><i class="fa fa-home-lg"></i> Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="manage-results.php">Manage Results</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Result</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Edit Result</h3>
                    </div>
                    <div id="form-div" class="col-md-8 rounded bg-light mx-auto border border-primary shadow py-3 pt-5 px-4 form-div">
                        <form action="calculate-result.php" method="post">
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-users class"></i>
                                    </span>
                                </div>
                                <select class="custom-select" required disabled>
                                    <option value="<?php echo $row[3] ?>"><?php echo $row[4]." (" . $row[5] . ")"; ?></option>
                                </select>
                                <input type="hidden" name="classid" value="<?php echo $row[3] ?>">
                                <input type="hidden" name="studentid" value="<?php echo $row[1] ?>">
                            </div>
                            <div class="input-group form-goup">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user"></i>
                                    </span>
                                </div>
                                <select class="custom-select" disabled required>
                                    <option value="<?php echo $row[1]; ?>"><?php echo $row[2]; ?></option>
                                </select>
                            </div>
                            <div class="form-row my-3">
                                <div class="col-md-6 text-center my-3 py-2 bg-primary rounded-left border-right">
                                    <span class="font-weight-bold">Half Yearly exam marks MM (100)</span>
                                </div>
                                <div class="col-md-6 text-center my-3 py-2 bg-primary rounded-right border-left">
                                    <span class="font-weight-bold">Yearly exam marks  MM (100)</span>
                                </div>
                                <?php
                                    $cid = $row[3];
                                    $result = mysqli_query($conn, "SELECT * FROM subjects WHERE ClassId='$cid'");
                                    $row1 = mysqli_fetch_all($result);
                                    $allmarks = unserialize($row[0]);
                                    for($i=0; $i < count($allmarks[0]); $i++)
                                    {
                                ?>
                                        <div class="col-md-6 mb-3">
                                            <label><?php echo $row1[$i][2] . " (" . $row1[$i][1] . ")"; ?></label>
                                            <input type="Number" min=0 max=100 class="form-control" name="<?php echo $row1[$i][0]; ?>_HYE" placeholder="Half Yearly Marks" value="<?php echo $allmarks[1][0][$i] ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label><?php echo $row1[$i][2] . " (" . $row1[$i][1] . ")"; ?></label>
                                            <input type="Number" min=0 max=100 class="form-control" name="<?php echo $row1[$i][0]; ?>_YE" placeholder="Yearly Marks" value="<?php echo $allmarks[2][0][$i] ?>" required>
                                            <input type="hidden" name="sub<?php echo $i+1;?>" value="<?php echo $row1[$i][0]; ?>">
                                        </div>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="form-group text-center py-4">
                                <input type="hidden" name="resultid" value="<?php echo $id; ?>">
                                <input type="submit" class="btn btn-primary" value="Update Result" name="updateresult">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#form-div').overlayScrollbars({
            scrollbars : {
                visibility : 'auto',    //visible || hidden || auto || v || h || a
                autoHide : 'leave',     //never || scroll || leave || n || s || l
                autoHideDelay : 200,    //number
                dragScrolling : true,   //true || false
                clickScrolling : false, //true || false
                touchSupport : true,     //true || false
                snapHandle: true     //true || false
            }
        }); 
    </script>
</body>
</html>