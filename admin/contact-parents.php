<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Parents</title>
    <?php
        include "includes/includes.php";
    ?>
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
                            <li class="breadcrumb-item active" aria-current="page">Contact Parents</li>
                        </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-3 rounded">Contact Parents</h3>
                    </div>
                    <div class="col-md-9 col-sm-7 mb-2 mx-auto bg-white p-3 pt-5 rounded shadow border border-primary">
                        <form action="" method="POST" name="myForm">
                            <div class="form-group">
                                <label>Class</label>
                                <select name="classid" class="custom-select" onchange="getStudents(this);">
                                    <option value="">Select Class</option>
                                    <?php
                                        $query = "SELECT * FROM classes";

                                        $result = mysqli_query($conn, $query);
                                        if($result)
                                        {
                                            if(mysqli_num_rows($result) > 0)
                                            {
                                                while($row = mysqli_fetch_array($result))
                                                    echo "<option value='$row[0]'>$row[1] ( $row[2] )</option>";
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Student</label>
                                <select name="studentid" onchange="getEmail(this)" class="custom-select" id="sname">
                                    <option value="">Select name</option>
                                    <!-- student names will be automatically fetched. -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mediam</label>
                                <div class="custom-control custom-radio custom-control-inline ml-5 pl-5">
                                    <input type="radio" id="emailInput" onclick="showEmail()" name="mediam" value="email" class="custom-control-input" required>
                                    <label class="custom-control-label" for="emailInput">Email</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline pl-5">
                                    <input type="radio" id="sms" name="mediam" onclick="showSms()" value="sms" class="custom-control-input" required>
                                    <label class="custom-control-label" for="sms">SMS</label>
                                </div>
                            </div>
                            <div class="form-group" id="div-email" style="display:none;">
                                <label>Email</label>
                                <input type="email" id="email" name="email" placeholder="Enter Parents Email" class="form-control">
                            </div>
                            <div class="form-group" id="div-mobile" style="display:none;">
                                <label>Mobile Number</label>
                                <input type="number" id="mnumber" name="mnumber" placeholder="Enter Parents Mobile Number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" name="subject" placeholder="Enter Subjects" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Message</label>
                                <textarea name="msg" cols="10" rows="5" class="form-control" placeholder="Enter Message" required></textarea>
                            </div>
                            <div class="text-center">
                                <input type="submit" class="btn btn-primary mt-4" value="Send" name="send">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showEmail()
        {
            document.getElementById('div-email').style.display = 'block';
            document.getElementById('email').required = true;
            document.getElementById('mnumber').required = false;
            document.getElementById('div-mobile').style.display = 'none';
        }
        function showSms()
        {
            document.getElementById('div-email').style.display = 'none';
            document.getElementById('div-mobile').style.display = 'block';
            document.getElementById('mnumber').required = true;
            document.getElementById('email').required = false;
        }
    </script>
</body>
</html>

<?php
    if(isset($_POST['send']))
    {
        require_once "sendmail.php";

        exec("ping -c 1 google.com", $response);
        if (empty($response)) 
        {
            echo "<script>errorNotification('Not Connected to Internet')</script>";
        }
        else
        {
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $msg = $_POST['msg'];
            $mobilenumber = $_POST['mnumber'];

            if($_POST['mediam'] == "email")
            {
                $result = sendmail($email, $msg, $subject);
                if($result)
                    echo "<script>successNotification('Email Sent')</script>";
                else
                    echo "<script>errorNotification('There was some error while seding mail')</script>";
            }
            if($_POST['mediam'] == "sms")
            {
                $result = sendsms($mobilenumber, $msg, $subject);
                if($result)
                    echo "<script>successNotification('SMS Sent')</script>";
                else
                    echo "<script>errorNotification('There was some error while sending sms')</script>";
            }
        }
    }
?>