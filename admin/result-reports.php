<?php
session_start();
if ($_SESSION['userid'] == "") {
    header("location:admin-login.php");
}
include "../include/config.php";
$query = "SELECT * FROM classes";
$classes = mysqli_query($conn, $query);
if (!$classes) {
    echo "<script>alert('There was some problem while fetching the data')</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result Reports</title>
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
                                <li class="breadcrumb-item active" aria-current="page">Result Reports</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12">
                        <h3 class="h3 text-center heading-2 text-primary py-2 mb-2 rounded">Result Reports</h3>
                    </div>
                    <div class="col-md-11 col-sm-7 my-2 mx-auto p-4 bg-white rounded shadow border border-primary">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                $percent = array();
                                $input = "";
                                while ($classdata = mysqli_fetch_array($classes)) {
                                    $cid = $classdata[0];
                                    $query = "SELECT Percent FROM results WHERE ClassId='$cid' ORDER BY Percent DESC LIMIT 1";
                                    $result = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_array($result);
                                        $input .= "['$classdata[1]', $row[0], '#4361ee', $row[0]],";
                                    }
                                }
                                ?>
                                <div id="container" style="width: 550px; height: 400px; margin: 0 auto"></div>
                                <div  id="pieChart" class="mx-auto text-center col-md-12 mb-2" style="height: 500px; width:100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--row-->
            </div>
            <!--container-fluid-->
        </div>
        <!--content-wrapper-->
    </div>
    <!--wrapper-->
    <script>
        google.charts.load('current', {packages: ['corechart']});
        // Define the chart to be drawn.
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Class', 'Percentage', {
                    role: 'style'
                }, {
                    role: 'annotation'
                }],
                <?php echo substr($input, 0, -1); ?>
            ]);

            var options = {
                title: 'Highest percentage in each Class',
                legend: 'none'
            };

            // Instantiate and draw the chart.
            var chart = new google.visualization.ColumnChart(document.getElementById('container'));
            chart.draw(data, options);

            <?php
                $result = mysqli_query($conn, "SELECT COUNT(id)passed,(SELECT COUNT(id) FROM results WHERE Result='Fail')Failed FROM results WHERE Result='Pass'");
                $row = mysqli_fetch_array($result);
            ?>

            var data = google.visualization.arrayToDataTable([
                ['Result', 'percent'],
                ['Passed', <?php echo $row[0] ?>],
                ['Failed', <?php echo $row[1] ?>]
            ]);

            var options = {
                title: 'Overall result',
                pieHole: 0.4,
                colors: ['#4d94ff', '#023E8A']
            };

            var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
            chart.draw(data, options);
        }
        google.charts.setOnLoadCallback(drawChart);
    </script>
</body>

</html>