<?php
    ob_start();
    session_start();
    include '../include/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- linking fonts, bootstrap, fontawesome files. -->
    <!-- <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome/all.css">
    <link rel="stylesheet" href="../fonts/Ubuntu.css"> -->
    <?php include 'includes/includes.php'; ?>
    <style>
        /* overriding some of bootstrap style and adding new styles */
        body {
            font-family: 'Ubuntu', sans-serif !important;
            background-image: url("img/login-background.jpg");
            background-size: cover;
        }
        #showbtn{
            /* border-radius: 0 5px 5px 0;*/
            box-shadow: none; 
        }
        #showbtn:hover,#showbtn:focus{
            background-color: white !important;
        }
        input{
            box-shadow: none !important;
        }
        h1{
            font-size: 3rem !important;
        }
    </style>
    <title>Admin Login</title>
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <button type="button" tabindex="-1" onclick="document.location = '../'" class="btn btn-primary">Back to Home</button>
            </div>
            <div class="col-md-6 mx-auto">
                <form method="post" action="" class="needs-validation" name="login" novalidate>
                    <h1 class="h1 font-weight-bold text-primary text-center my-5">Admin Login</h1>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>
                        <input type="text" name="userid" placeholder="Enter user id" class="form-control form-control-lg rounded-right" required>
                        <div class="invalid-feedback">
                            Please enter valid userid
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </span>
                        </div>
                        <input type="password" name="password" placeholder="Enter password" class="form-control form-control-lg border-right-0" required autocomplete="off">
                        <div class="input-group-append">
                            <button type="button" id="showbtn" onclick="show()" class="btn bg-light rounded-right"><i class="fas fa-eye-slash"></i></button>
                        </div>
                        <div class="invalid-feedback">
                            Please enter valid password
                        </div>
                    </div>
                    <div class="text-center">
                        <input type="submit" class="btn btn-primary w-25 btn-lg mt-4" value="Login" name="login">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        //function for form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        // Function to show and hide password
        function show(){
            var btn = document.getElementById("showbtn");
            var pass = document.forms['login']['password'];

            if(pass.type === "password")
            {
                pass.type = "text";
                btn.innerHTML = '<i class="fas fa-eye">';
            }
            else
            {
                pass.type = "password";
                btn.innerHTML = '<i class="fas fa-eye-slash">';
            }
        }
    </script>
</body>
</html>

<?php
    if (isset($_POST['login'])) {
        $userid = $_POST['userid'];
        $password = $_POST['password'];

        $query = "SELECT `UserId`,`Password` FROM `admin` WHERE `UserId`='$userid' AND `Password`='$password'";

        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $_SESSION['userid'] = $userid;
            header("location:dashboard.php");
        } else
            echo "<script>infoNotification('User name or password wrong','Wrong credentials');</script>";

        mysqli_close($conn);
    }
?>