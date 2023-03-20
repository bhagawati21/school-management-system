<?php
session_start();
if ($_SESSION['userid'] == "") {
  header("location:admin-login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <?php include "includes/includes.php"; ?>
</head>

<?php
include '../include/config.php';

$query = "SELECT COUNT(id)students,(SELECT COUNT(id) FROM subjects)subjects,(SELECT COUNT(id) FROM classes)classes,(SELECT COUNT(id) FROM results)results FROM students";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$query = "SELECT COUNT(id)Female,(SELECT COUNT(id) FROM students WHERE Gender='Male')Male FROM students WHERE Gender='Female'";
$result = mysqli_query($conn, $query);
$row1 = mysqli_fetch_array($result);
mysqli_close($conn);
?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php include "includes/navbar.php"; ?>
    <!-- Content Wrapper-->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="py-4">
            <h1 class="h1 text-primary font-weight-bold heading-1 py-2 text-center rounded">Dashboard</h1>
          </div>
          <div class="row">

            <div class="col-md-5 mt-2 mx-auto">
              <a class="dashboard-stat blue" href="manage-students.php">
                <div class="visual">
                  <i class="fa fa-users"></i>
                </div>
                <div class="details">
                  <div class="number">
                    <span><?php echo $row['students'] ?></span>
                  </div>
                  <div class="desc">Total Students</div>
                </div>
              </a>
            </div>

            <div class="col-md-5 mt-2 mx-auto">
              <a class="dashboard-stat blue" href="manage-subjects.php">
                <div class="visual">
                  <i class="fa fa-book"></i>
                </div>
                <div class="details">
                  <div class="number">
                    <span><?php echo $row['subjects'] ?></span>
                  </div>
                  <div class="desc">Total Subjects</div>
                </div>
              </a>
            </div>

            <div class="col-md-5 mt-2 mx-auto">
              <a class="dashboard-stat blue" href="manage-classes.php">
                <div class="visual">
                  <i class="fa fa-users-class"></i>
                </div>
                <div class="details">
                  <div class="number">
                    <span><?php echo $row['classes'] ?></span>
                  </div>
                  <div class="desc">Total Classes</div>
                </div>
              </a>
            </div>

            <div class="col-md-5 mt-2 mx-auto">
              <a class="dashboard-stat blue" href="manage-results.php">
                <div class="visual">
                  <i class="fa fa-file-spreadsheet"></i>
                </div>
                <div class="details">
                  <div class="number">
                    <span><?php echo $row['results'] ?></span>
                  </div>
                  <div class="desc">Total Results</div>
                </div>
              </a>
            </div>
            <div class="col-md-12 text-primary text-center mt-5">
              <h2 class="font-weight-bold m-0 pt-4" style="background-color: #ddd;">Student Gender Ratio</h2>
            </div>
            <div  id="pieChart" class="mx-auto text-center col-md-12 mb-2" style="height: 500px; width:100%;"></div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Gender', 'percent'],
          ['Female', <?php echo $row1[0]?>],
          ['Male', <?php echo $row1[1]?>]
        ]);

        var options = {
          pieHole: 0.4,
          backgroundColor: '#ddd',
          colors: ['#ff4d94', '#4d94ff']
        };

        var chart = new google.visualization.PieChart(document.getElementById('pieChart'));
        chart.draw(data, options);
      }
    </script>

</body>

</html>