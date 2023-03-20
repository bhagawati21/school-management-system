<!DOCTYPE html>
<html>

<head>
    <title>Bright Academy | Home</title>
    <?php
    include "include/includes.php";
    include "include/config.php";
    ?>

    <style>
        img {
            height: 70vh !important;
        }

        .bg-custom {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("img/home-background.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .lead {
            color: #FF6347 !important;
            color: green!important;
        }
        .marquee{
            position: absolute;
            top: 49px;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .news-div{
            overflow: hidden;
        }
    </style>
</head>

<body>
    <?php
    include "include/top-bar.php";
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="jumbotron jumbotron-fluid col-12 bg-custom">
                <div class="container text-center">
                    <h1 class="display-5 font-weight-bold text-white">Welcome to <br /></h1>
                    <h1 class="display-5 font-weight-bold text-white">Bright Academy School</h1>
                    <p class="lead bg-light col-lg-5 rounded mx-auto font-weight-bold">Education is the key to the door of success.</p>
                </div>
            </div>

            <div class="col-md-8 my-3 mb-5">
                <div id="carouselExampleInterval" class="carousel slide col-md-12 mx-auto" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php
                        $path = "img/slider";
                        $files = array_diff(scandir($path), array(".", ".."));

                        $activeFlag = true;
                        foreach ($files as $value) {
                            if ($activeFlag)
                                echo "<div class='carousel-item active' data-interval='5000'>
                                        <img src='img/slider/" . $value . "' class='rounded d-block w-100' alt='...'>
                                      </div>";
                            else
                                echo "<div class='carousel-item' data-interval='5000'>
                                        <img src='img/slider/" . $value . "' class='rounded d-block w-100' alt='...'>
                                      </div>";
                            $activeFlag = false;
                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleInterval" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleInterval" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
            <div class="col-md-4 news-div mx-auto text-center my-3 mb-5 border border-dark border-top-0 rounded p-0">
                <?php
                $query = "SELECT * FROM announcements ORDER BY `announcements`.`Date` DESC";
                $result = mysqli_query($conn, $query);

                if (!$result)
                    echo "<script>alert('some sql query error')</script>";
                ?>
                <table class="table table-striped">
                    <tr class="bg-dark">
                        <th colspan="3">News and Notifications</th>
                    </tr>
                </table>
                <marquee direction="up" onmouseover="this.stop()" onmouseout="this.start()" scrolldelay="5" class="marquee">
                    <div class="row">
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<p class='col-4 bg-light p-2'>" . date("d/n/y h:i a", strtotime($row[3])) . "</p>
                                  <p class='col-6 bg-light p-2'>$row[1]</p>
                                  <p class='col-2 bg-light p-2'>
                                    <button type='button' class='btn' data-toggle='modal'data-target='#modal$row[0]'><i class='fas fa-arrow-alt-circle-right'></i></button>
                                  </p>";
                        }
                        ?>
                    </div>
                </marquee>
                <?php
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result)) {
                ?>
                    <div class="modal fade" id="<?php echo 'modal',$row[0] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">News and Announcements</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <b>Title : <?php echo $row[1]?></b> <br /><br />
                                    <p class="text-justify"><?php echo $row[2]?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <?php include "include/footer.php"; ?>
    <script>
        $("body").overlayScrollbars({});
    </script>
</body>

</html>