<?php
session_start();
include "include/config.php";
if ($_SESSION['studentid'] == "") {
    header("location:student-login.php");
}

$id = intval($_SESSION['studentid']);

$query = "SELECT `results`.*, `students`.*, `classes`.* FROM `results` LEFT JOIN `students` ON `results`.`StudentId` = `students`.`id` LEFT JOIN `classes` ON `results`.`ClassId` = `classes`.`id` WHERE results.StudentId='$id'";

$result = mysqli_query($conn, $query);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $allmarks = unserialize($row['MarksAll']);
    } else {
        $msg = "Your result isn't declared yet.";
        $query = "SELECT `students`.*, `classes`.* FROM `students` LEFT JOIN `classes` ON `students`.`ClassId` = `classes`.`id` WHERE students.id='$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
        } else {
            echo "<script>alert('There was some sql error')</script>";
        }
    }
    $cid = $row['ClassId'];
    $query = "SELECT * FROM subjects WHERE ClassId='$cid'";
    $result = mysqli_query($conn, $query);
} else
    echo "<script>alert('There was some sql error')</script>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include "include/includes.php"; ?>
    <style>
        .btn-logout {
            border: none;
        }

        .btn-logout:hover {
            color: white !important;
        }

        .schoolname {
            font-size: 2.2rem;
        }

        table,
        tr,
        td,
        th {
            border-color: #999 !important;
        }

        #image-div {
            width: 200px;
            height: 200px;
            margin: 25px auto 5px;
        }

        #image {
            width: 200px;
            height: 200px;
            border-radius: 5px;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #section-to-print,
            #section-to-print * {
                visibility: visible;
            }
        }

        #footer {
            position: fixed;
            bottom: 0;
            left: 0;
        }
    </style>
</head>

<body>
    <?php include "include/top-bar.php"; ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 bg-light rounded m-3 p-3 shadow">
                <nav>
                    <div class="nav nav-pills nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true"><i class="fa fa-user"></i> Profile</a>
                        <a class="nav-link" id="nav-assignment-tab" data-toggle="tab" href="#nav-assignment" role="tab" aria-controls="nav-assignment" aria-selected="false"><i class="far fa-clipboard-list"></i> Assignments</a>
                        <a class="nav-link" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab" aria-controls="nav-notes" aria-selected="false"><i class="far fa-books"></i> Notes</a>
                        <a class="nav-link" id="nav-attendance-tab" data-toggle="tab" href="#nav-attendance" role="tab" aria-controls="nav-attendance" aria-selected="false"><i class="far fa-chalkboard-teacher"></i> Attendance</a>
                        <a class="nav-link" id="nav-result-tab" data-toggle="tab" href="#nav-result" role="tab" aria-controls="nav-result" aria-selected="false"><i class="far fa-file-spreadsheet"></i> Result</a>
                        <a class="nav-link" id="nav-password-tab" data-toggle="tab" href="#nav-password" role="tab" aria-controls="nav-password" aria-selected="false"><i class="far fa-key"></i> Change Password</a>
                        <a class="nav-link btn btn-outline-danger btn-logout" href="logout.php"> <i class="fa fa-sign-out"></i> Logout</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="row">
                            <div class="col-md-6 mr-3 ml-auto my-4 shadow rounded bg-light pt-4 px-3 border border-primary">
                                <form action="" method="post" id="myForm" enctype="multipart/form-data" name="myForm" onreset="clearPhoto()">
                                    <div class="form-group">
                                        <label>Roll Number</label>
                                        <input type="text" class="form-control" value="<?php echo $row['RollNumber'] ?>" disabled required>
                                    </div>
                                    <div class="form-group">
                                        <label>Enrollment Number</label>
                                        <input type="text" class="form-control" name="enrollnumber" placeholder="Enter Enrollment Number" value="<?php echo $row['EnrollmentNumber'] ?>" disabled required>
                                    </div>
                                    <div class="form-group">
                                        <label>Student Name</label>
                                        <input type="text" class="form-control" name="sname" placeholder="Enter Student Name" value="<?php echo $row['Name'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Mother's Name</label>
                                        <input type="text" name="mname" class="form-control" placeholder="Enter Mother's Name" value="<?php echo $row['MotherName'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Father's Name</label>
                                        <input type="text" name="fname" class="form-control" placeholder="Enter Father's Name" value="<?php echo $row['FatherName'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="<?php echo $row['PhoneNumber'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Parent's Phone Number</label>
                                        <input type="text" name="parentphone" class="form-control" placeholder="Enter Parent's Phone Number" value="<?php echo $row['ParentPhoneNumber'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Birth Date</label>
                                        <input type="date" name="dob" class="form-control" value="<?php echo $row['DOB'] ?>" disabled required>
                                    </div>
                                    <div class="form-group">
                                        <label>Age</label>
                                        <input type="text" name="age" class="form-control" placeholder="Enter Age" value="<?php echo $row['Age'] ?>" disabled required>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" name="address" class="form-control" placeholder="Enter Address" value="<?php echo $row['Address'] ?>" disabled required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $row['Email'] ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Class</label>
                                        <select name="classid" class="custom-select" disabled required>
                                            <option value="<?php echo $row['ClassId'] ?>"><?php echo $row['ClassName'] . " (" . $row['ClassNameNumeric'] . ")" ?></option>
                                        </select>
                                    </div>
                                    <div class="my-3 mt-4 text-center">
                                        <input type="submit" name="update" class="btn btn-primary" value="update Details">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-4 ml-3 my-4 mr-auto">
                                <div class="image-container shadow bg-light rounded border border-primary">
                                    <div id="image-div">
                                        <img id="image" src="photos/<?php echo $id . '/' . $row['Photo'] ?>" alt="student image">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" form="myForm" name="photo" class="custom-file-input" accept=".jpg,.png,.jpeg" onchange="show()" id="photo">
                                        <label class="custom-file-label" for="photo">Choose Photo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-assignment" role="tabpanel" aria-labelledby="nav-assignment-tab">
                        <?php include "assignments.php" ?>
                    </div>
                    <div class="tab-pane fade" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                        <?php include "notes.php" ?>
                    </div>
                    <div class="tab-pane fade" id="nav-password" role="tabpanel" aria-labelledby="nav-password-tab">
                        <?php include "change-password.php"; ?>
                    </div>
                    <div class="tab-pane fade" id="nav-attendance" role="tabpanel" aria-labelledby="nav-attendance-tab">
                        <table class="table table-bordered my-4">
                            <tr>
                                <th>Sr. no</th>
                                <th>Subject Name</th>
                                <th>Total Classes</th>
                                <th>Classes attended</th>
                                <th>Percentage</th>
                            </tr>

                            <?php
                                $sno = 1;
                                while ($subjects = mysqli_fetch_array($result)) {
                                    $subject = $subjects[0];
                                    $query = "SELECT COUNT(DISTINCT AttendanceDate) FROM attendance WHERE Subjectid='$subject'";
                                    $r = mysqli_query($conn, $query);
                                    $total = mysqli_fetch_array($r);
                                    $query = "SELECT COUNT(DISTINCT AttendanceDate) FROM attendance WHERE Subjectid='$subject' AND StudentId='$id' AND Attendance='1'";
                                    $r = mysqli_query($conn, $query);
                                    $attended = mysqli_fetch_array($r);
                                    if ($total[0] != 0)
                                        $percent = number_format($attended[0] / $total[0] * 100, 2);
                                    else
                                        $percent = 0;
                                    echo "<tr>
                                                <td>$sno</td>
                                                <td>$subjects[2] ( $subjects[1] )</td>
                                                <td>$total[0]</td>
                                                <td>$attended[0]</td>";
                                    if ($percent < 75)
                                        echo "<td>
                                                    <div class='progress'>
                                                        <div class='progress-bar bg-danger rounded' style='width:" . $percent . "%'>$percent%</div>
                                                    </div>
                                                </td>
                                            </tr>";
                                    else
                                        echo "<td>
                                                    <div class='progress'>
                                                        <div class='progress-bar bg-success rounded' style='width:" . $percent . "%'>$percent%</div>
                                                    </div>
                                                </td>
                                            </tr>";
                                    $sno++;
                                }
                            ?>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="nav-result" role="tabpanel" aria-labelledby="nav-result-tab">
                        <div class="row">
                            <?php
                            if (isset($msg)) {
                                echo "<div class='col-12 text-center m-4 p-4'>
                                        <h4 class='text-danger'>$msg</h4>
                                    </div>";
                            } else {
                            ?>
                                <div id="section-to-print" class="col-md-10 mx-auto p-4 my-5 bg-light">
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
                                            <td><?php echo date("d-m-Y", strtotime($row['DOB'])) ?></td>
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
                                                    $cid = $row['ClassId'];
                                                    $query = "SELECT * FROM subjects WHERE ClassId='$cid'";
                                                    $result = mysqli_query($conn, $query);
                                                    while ($row1 = mysqli_fetch_array($result)) {
                                                        echo "<tr>
                                                            <td>$sno</td>
                                                            <td>$row1[1]</td>
                                                            <td>$row1[2]</td>";
                                                        if ($row1[0] == $allmarks[0][$i]) {
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
                                                        <th colspan="3">Total (<?php echo $row['TotalMaximum'] ?>)</th>
                                                        <th colspan="2"><?php echo $row['TotalObtainedHYE'] ?></th>
                                                        <th colspan="2"><?php echo $row['TotalObtainedYE'] ?></th>
                                                        <th><?php echo $row['TotalObtained'] ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3">Percent</th>
                                                        <th colspan="5"><?php echo $row['Percent'] . " %"; ?></th>
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
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "include/footer.php"; ?>
    <script>
        if (location.hash) {
            $('a[href=\'' + location.hash + '\']').tab('show');
        }
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('a[href="' + activeTab + '"]').tab('show');
        }

        $('body').on('click', 'a[data-toggle=\'tab\']', function(e) {
            e.preventDefault()
            var tab_name = this.getAttribute('href')
            if (history.pushState) {
                history.pushState(null, null, tab_name)
            } else {
                location.hash = tab_name
            }
            localStorage.setItem('activeTab', tab_name)

            $(this).tab('show');
            return false;
        });
        $(window).on('popstate', function() {
            var anchor = location.hash ||
                $('a[data-toggle=\'tab\']').first().attr('href');
            $('a[href=\'' + anchor + '\']').tab('show');
        });
        $('#photo').change(function(e) {
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    $sname = mysqli_real_escape_string($conn, $_POST['sname']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    // $roll = mysqli_real_escape_string($conn, $_POST['rollnumber']);
    // $enroll = mysqli_real_escape_string($conn, $_POST['enrollnumber']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $parentphone = mysqli_real_escape_string($conn, $_POST['parentphone']);
    // $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    // $address = mysqli_real_escape_string($conn, $_POST['address']);
    // $age = mysqli_real_escape_string($conn, $_POST['age']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // $cid = mysqli_real_escape_string($conn, $_POST['classid']);

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

        $filename = $_FILES["photo"]["name"];
        $path = "photos/$id/";

        if (!file_exists($path)) {
            mkdir($path);
        }
        if ($p = move_uploaded_file($_FILES['photo']['tmp_name'], $path . $filename) == 1) {
            $query = "UPDATE `students` SET `Name`='$sname',`FatherName`='$fname',`MotherName`='$mname',`Email`='$email',`PhoneNumber`='$phone',`ParentPhoneNumber`='$parentphone',`Photo`='$filename' WHERE `id`='$id'";
            $result = mysqli_query($conn, $query);
            if ($result)
                echo "<script>document.location.href = 'dashboard.php?T=success&NM=Record Updated Successfully'</script>";
            else {
                echo "<script>alert(\"Error : " . mysqli_error($conn) . "\");";
                echo "window.history.back();</script>";
            }
        } else
            echo "<script>errorNotification('Could not upload file');</script>";
    }
    if(!isset($p))
    {
        $query = "UPDATE `students` SET `Name`='$sname',`FatherName`='$fname',`MotherName`='$mname',`Email`='$email',`PhoneNumber`='$phone',`ParentPhoneNumber`='$parentphone' WHERE `id`='$id'";
        $result = mysqli_query($conn, $query);
        if ($result)
            echo "<script>document.location.href = 'dashboard.php?T=success&NM=Record Updated Successfully'</script>";
        else 
        {
            echo "<script>window.alert(\"Erorr : " . mysqli_error($conn) . "\");";
            echo "window.history.back();</script>";
        }
    }
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