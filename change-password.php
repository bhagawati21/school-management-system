<div class="row my-3 mt-5">
    <style>
        .showbtn{
            border: 1px solid #ced4da!important;
            border-left: 0!important;
            color: #0c6abd;
        }
    </style>
    <div class="col-md-8 col-sm-7 my-5 mx-auto p-3 pt-5 rounded shadow border border-primary">
        <form action="" method="POST" name="passForm">
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-key"></i>
                    </span>
                </div>
                <input type="password" class="form-control border-right-0" name="currentpass" placeholder="Enter Current Password" autocomplete="off" required />
                <div class="input-group-append">
                    <button type="button" onclick="showPass()" tabindex="-1" id="showbtn" class="btn rounded-right showbtn"><i class="fas fa-eye"></i></button>
                </div>
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <i class="fa fa-key"></i>
                    </span>
                </div>
                <input type="password" name="newpass" class="form-control border-right-0" placeholder="Enter New Password" autocomplete="off" required />
                <div class="input-group-append">
                    <button type="button" onclick="showPass1()" tabindex="-1" id="showbtn1" class="btn showbtn rounded-right"><i class="fas fa-eye"></i></button>
                </div>
            </div>
            <div class="text-center">
                <input type="submit" class="btn btn-primary mt-4" value="Change" name="change">
            </div>
        </form>
    </div>

    <script>
        function showPass() {
            if (document.forms['passForm']['currentpass'].type == "password") {
                document.forms['passForm']['currentpass'].type = "text";
                document.getElementById('showbtn').innerHTML = '<i class="fas fa-eye-slash">';
            } else {
                document.forms['passForm']['currentpass'].type = "password";
                document.getElementById('showbtn').innerHTML = '<i class="fas fa-eye">';
            }
        }

        function showPass1() {
            if (document.forms['passForm']['newpass'].type == "password") {
                document.forms['passForm']['newpass'].type = "text";
                document.getElementById('showbtn1').innerHTML = '<i class="fas fa-eye-slash">';
            } else {
                document.forms['passForm']['newpass'].type = "password";
                document.getElementById('showbtn1').innerHTML = '<i class="fas fa-eye">';
            }
        }
    </script>
</div>

<?php
    if(isset($_POST['change']))
    {
        $cpass = $_POST['currentpass'];
        $npass = $_POST['newpass'];
        $studentid = $_SESSION['studentid'];

        $query = "SELECT * FROM `students` WHERE id='$studentid' AND `Password`='$cpass'";

        $user = mysqli_query($conn, $query);

        if(mysqli_num_rows($user) == 1)
        {
            $student = mysqli_fetch_array($user);
            $id = $student[0];
            $query = "UPDATE `students` SET `Password`='$npass' WHERE id='$id'";
            $r = mysqli_query($conn, $query);
            if($r)
                echo "<script>successNotification('Password Changed')</script>";
            else
                echo mysqli_error($conn);
        }
        else
            echo "<script>infoNotification('Current Password Wrong')</script>";
    }
?>