<?php
    define('DB_HOST','localhost');
    define('DB_USER','root');
    define('DB_PASS','Root@23');
    define('DB_NAME','sms');

    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($conn === false)
    {
        die("ERROR: Could not connect. ".mysqli_connect_error());
    }

?>	