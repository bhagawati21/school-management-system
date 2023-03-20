<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php"; 

    if(isset($_POST['addresult']) || isset($_POST['updateresult']))
    {
        $studentid = $_POST['studentid'];
        $cid = $_POST['classid'];
        $totalobtainedmarks=0;
        $subcount=0;
        $i=1;
        $subid = array();
        $submarks_hye = array();
        $submarks_ye = array();
        $submarks_total = array();
        $grade_hye = array();
        $grade_ye = array();
        //Getting subject ids and calculating total obtained marks;
        foreach ($_POST as $key => $value) {
            if($key == "sub".$i)
            {
                array_push($subid, $value);
                array_push($submarks_hye, $_POST[$value."_HYE"]);
                array_push($submarks_ye, $_POST[$value."_YE"]);
                array_push($submarks_total, ($submarks_hye[$i-1] + $submarks_ye[$i-1]));

                //calculating grades for half yearly exam
                if($submarks_hye[$i-1] < 33)
                    array_push($grade_hye, 'F');
                else if($submarks_hye[$i-1] >= 33 && $submarks_hye[$i-1] < 50)
                    array_push($grade_hye, 'D');
                else if($submarks_hye[$i-1] >= 50 && $submarks_hye[$i-1] < 60)
                    array_push($grade_hye, 'C');
                else if($submarks_hye[$i-1] >= 60 && $submarks_hye[$i-1] < 70)
                    array_push($grade_hye, 'B');
                else if($submarks_hye[$i-1] >= 70 && $submarks_hye[$i-1] < 80)
                    array_push($grade_hye, 'A');
                else if($submarks_hye[$i-1] >= 80)
                    array_push($grade_hye, 'A+');

                //calculating grades for yearly exam
                if($submarks_ye[$i-1] < 33)
                    array_push($grade_ye, 'F');
                else if($submarks_ye[$i-1] >= 33 && $submarks_ye[$i-1] < 50)
                    array_push($grade_ye, 'D');
                else if($submarks_ye[$i-1] >= 50 && $submarks_ye[$i-1] < 60)
                    array_push($grade_ye, 'C');
                else if($submarks_ye[$i-1] >= 60 && $submarks_ye[$i-1] < 70)
                    array_push($grade_ye, 'B');
                else if($submarks_ye[$i-1] >= 70 && $submarks_ye[$i-1] < 80)
                    array_push($grade_ye, 'A');
                else if($submarks_ye[$i-1] >= 80)
                    array_push($grade_ye, 'A+');

                $totalobtainedmarks += ($submarks_hye[$i-1] + $submarks_ye[$i-1]);
                $subcount++;
                $i++;
            }
        }
        $totalmaximummarks = $subcount*200;
        $percent = number_format(($totalobtainedmarks/$totalmaximummarks)*100,2); //calculating percent
        $sresult = $percent < 33 ? "Fail":"Pass";
        $totalobtainedhye = array_sum($submarks_hye);
        $totalobtainedye = array_sum($submarks_ye);
        $submarks_hye = array( $submarks_hye, $grade_hye);
        $submarks_ye = array( $submarks_ye, $grade_ye);

        //storing all marks and grades into single array
        $allmarks = array($subid, $submarks_hye, $submarks_ye, $submarks_total);
        $serialized_allmarks = serialize($allmarks); //converting array to string
        if(isset($_POST['addresult']))
        {
            $query = "INSERT INTO results VALUES(NULL,'$studentid','$cid','$totalobtainedhye','$totalobtainedye','$totalobtainedmarks','$totalmaximummarks','$serialized_allmarks','$percent','$sresult')";
            $result = mysqli_query($conn, $query);
            if($result)
                echo "<script>document.location = 'add-result.php?T=success&NM=Result Added Successfully';</script>";
            else
                echo "<script>alert(\"".mysqli_error($conn)."\")</script>";
        }
        if(isset($_POST['updateresult']))
        {
            $id = $_REQUEST['resultid'];

            $query = "UPDATE `results` SET `TotalObtainedHYE`='$totalobtainedhye',`TotalObtainedYE`='$totalobtainedye',`TotalObtained`='$totalobtainedmarks',`TotalMaximum`='$totalmaximummarks',`MarksAll`='$serialized_allmarks',`Percent`='$percent',`Result`='$sresult' WHERE id='$id'";

            $result = mysqli_query($conn, $query);
            if($result)
                echo "<script>document.location = 'manage-results.php?T=success&NM=Result Updated Successfully';</script>";
            else
                echo "<script>alert(\"".mysqli_error($conn)."\")</script>";
        }
    }
?>