<?php
    include "include/config.php";
    if(isset($_GET['id']))
    {
        $id = intval($_GET['id']);

        $query = "SELECT `results`.*, `students`.*, `classes`.* FROM `results` LEFT JOIN `students` ON `results`.`StudentId` = `students`.`id` LEFT JOIN `classes` ON `results`.`ClassId` = `classes`.`id` WHERE results.StudentId='$id'";

        $result = mysqli_query($conn, $query);
        if($result)
        {
            if(mysqli_num_rows($result) > 0)
            {
                $row = mysqli_fetch_array($result);
                $cid = $row['ClassId'];
                $query = "SELECT * FROM subjects WHERE ClassId='$cid'";
                $result = mysqli_query($conn, $query);
                $allmarks = unserialize($row['MarksAll']);
            }
            else
                header("location:results.php");
        }
        else
            echo mysqli_error($conn);
    }
    else
        header("location:results.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Result</title>
    <?php include "include/includes.php"; ?>
    <style>
        .schoolname{
            font-size: 2.2rem;
        }
        table,tr,td,th{
            border-color: #999!important;
        }
        @media print {
            body * {
                visibility: hidden;
            }
            #section-to-print, #section-to-print * {
                visibility: visible;
            }
        }
    </style>
</head>
<body>
    <?php include "include/top-bar.php"; ?>
    <div class="container-fluid">
        <div class="row mt-5">
            <div id="section-to-print" class="col-md-9 mx-auto p-4 mb-4 rounded shadow bg-light">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="2" class="text-center font-weight-bold schoolname">Bright Academy school</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td><?php echo $row['Name'] ?></td>
                    </tr>
                    <tr>
                        <td>Roll No.</td>
                        <td><?php echo $row['RollNumber'] ?></td>
                    </tr>
                    <tr>
                        <td>Enrollment No.</td>
                        <td><?php echo $row['EnrollmentNumber'] ?></td>
                    </tr>
                    <tr>
                        <td>Father's Name</td>
                        <td><?php echo $row['FatherName'] ?></td>
                    </tr>
                    <tr>
                        <td>Mother's Name</td>
                        <td><?php echo $row['MotherName'] ?></td>
                    </tr>
                    <tr>
                        <td>DOB</td>
                        <td><?php echo date("d-m-Y",strtotime($row['DOB'])) ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="font-weight-bold text-center" style="font-size:1.3rem;">Statement of Marks</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="margin:0!important; padding:0!important;">
                            <table class="table text-center" style="margin-bottom: 0!important;">
                                <tr>
                                    <th rowspan="2" class="align-middle">#</th>
                                    <th rowspan="2" class="align-middle">Subject Code</th>
                                    <th rowspan="2" class="align-middle">Subject Name</th>
                                    <th colspan="2">Half Yearly Exam</th>
                                    <th colspan="2">Yearly Exam</th>
                                    <th rowspan="2" class="align-middle">Total Marks</th>
                                </tr>
                                <tr>
                                    <th>marks (100)</th>
                                    <th>grade</th>
                                    <th>marks (100)</th>
                                    <th>grade</th>
                                </tr>
                                <?php
                                    $sno = 1;
                                    $i = 0;
                                    while($row1 = mysqli_fetch_array($result))
                                    {
                                        echo "<tr class='text-center'>
                                                <td>$sno</td>
                                                <td>$row1[1]</td>
                                                <td>$row1[2]</td>";
                                        if($row1[0] == $allmarks[0][$i])
                                        {
                                            echo "<td>" . $allmarks[1][0][$i] . "</td>";
                                            echo "<td>" . $allmarks[1][1][$i] . "</td>";

                                            echo "<td>" . $allmarks[2][0][$i] . "</td>";
                                            echo "<td>" . $allmarks[2][1][$i] . "</td>";

                                            echo "<td>" . $allmarks[3][$i] . "</td></tr>";
                                            $i++;
                                        }
                                        $sno++;
                                    }
                                ?>
                                <tr>
                                    <th colspan="3">Total (<?php echo $row['TotalMaximum']?>)</th>
                                    <th colspan="2"><?php echo $row['TotalObtainedHYE'] ?></th>
                                    <th colspan="2"><?php echo $row['TotalObtainedYE'] ?></th>
                                    <th><?php echo $row['TotalObtained'] ?></th>
                                </tr>
                                <tr>
                                    <th colspan="3">Percent</th>
                                    <th colspan="5"><?php echo $row['Percent']." %"; ?></th>
                                </tr>
                                <tr>
                                    <th colspan="3">Result</th>
                                    <th colspan="5"><?php echo $row['Result']; ?></th>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class="text-center">
                    <button onclick="window.print()" class="btn btn-primary"> Print </button>
                </div>
            </div>
        </div>
    </div>
    <?php include "include/footer.php"; ?>
</body>
</html>