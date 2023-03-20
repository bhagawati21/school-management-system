<?php
    session_start();
    if($_SESSION['userid'] == "")
    {
        header("location:admin-login.php");
    }
    include "../include/config.php";
    if(isset($_GET['c']))
    {
        $category = $_GET['c'];
        if($category == "student")
        {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $query = "DELETE FROM students WHERE id=$id";
                $result = mysqli_query($conn,$query);
                if($result)
                {
                    array_map("unlink", glob("../photos/$id/*"));
                    rmdir("../photos/$id");
                    header("location:manage-students.php?T=error&NM=Student Deleted Successfully");
                }
                else
                {
                    echo "<script> alert('ERROR :: Could not delete the record');
                        document.location = 'manage-students.php';</script>";
                }
            }
            else
            {
                header("location:manage-students.php");
            }
        }
        else if($category == "subject")
        {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $query = "DELETE FROM subjects WHERE id='$id'";
                $result = mysqli_query($conn,$query);
                if($result)
                    header("location:manage-subjects.php?T=error&NM=Subject Deleted Successfully");
                else
                {
                    echo "<script> alert('ERROR :: Could not delete the record');
                        document.location = 'manage-subjects.php';</script>";
                }
            }
            else
            {
                header("location:manage-subjectss.php");
            }
        }
        else if ($category == "class")
        {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $query = "DELETE FROM classes WHERE id='$id'";
                $result = mysqli_query($conn,$query);
                if($result)
                    header("location:manage-classes.php?T=error&NM=Class Deleted Successfully");
                else
                {
                    echo "<script> alert('ERROR :: Could not delete the record');
                        document.location = 'manage-classes.php';</script>";
                }
            }
            else
            {
                header("location:manage-classes.php");
            }
        }
        else if($category == "result")
        {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $query = "DELETE FROM results WHERE id='$id'";
                $result = mysqli_query($conn,$query);
                if($result)
                    header("location:manage-results.php?T=error&NM=Result Deleted Successfully");
                else
                {
                    echo "<script> alert('ERROR :: Could not delete the record');
                        document.location = 'manage-results.php';</script>";
                }
            }
            else
            {
                header("location:manage-results.php");
            }
        }
        else if($category == "attendance")
        {
            if(isset($_GET['cid']) && isset($_GET['sid']) && isset($_GET['date']))
            {
                $cid = $_GET['cid'];
                $sid = $_GET['sid'];
                $date = $_GET['date'];

                $query = "DELETE FROM attendance WHERE ClassId='$cid' AND SubjectId='$sid' AND AttendanceDate='$date'";
                $result = mysqli_query($conn,$query);
                if($result)
                    header("location:manage-attendance.php?T=error&NM=Attendance Deleted Successfully");
                else
                {
                    echo "<script> alert('ERROR :: Could not delete the record');
                        document.location = 'manage-attendance.php';</script>";
                }
            }
            else
            {
                header("location:manage-attendance.php");
            }
        }
        else if($category == "image")
        {
            if(isset($_GET['name']))
            {
                $path = "../img/slider/".$_GET['name'];
                if(unlink($path))
                    header("location:manage-gallery.php?T=error&NM=Photo Deleted Successfully");
                else
                    echo "<script> alert('ERROR :: Could not delete the file.');
                    document.location = 'manage-gallery.php';</script>";
            }
        }
        else if($category == "announcement")
        {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];

                $query = "DELETE FROM announcements WHERE id='$id'";
                $result = mysqli_query($conn,$query);
                if($result)
                    header("location:news-announcements.php?T=error&NM=Record Deleted Successfully");
                else
                    echo "<script> alert('ERROR :: Could not delete the record.');
                    document.location = 'news-announcements.php';</script>";
            }
        }
        else if($category == "assignment")
        {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $result = mysqli_query($conn, "SELECT * FROM assignments WHERE id='$id'");
                $row = mysqli_fetch_array($result);
                if(unlink("../attachments/".$row[5]) || $row[5]=="")
                {
                    $query = "DELETE FROM assignments WHERE id='$id'";
                    $result = mysqli_query($conn, $query);
                }
                if($result)
                        header("location:assignments.php?T=error&NM=Assignment Deleted Successfully");
                else
                    echo "<script> alert('ERROR :: Could not delete the record.');
                    document.location = 'assignments.php';</script>";
            }
        }
        else if($category == "notes")
        {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $result = mysqli_query($conn, "SELECT * FROM notes WHERE id='$id'");
                $row = mysqli_fetch_array($result);
                if(unlink("../attachments/Notes/".$row[5]))
                {
                    $query = "DELETE FROM notes WHERE id='$id'";
                    $result = mysqli_query($conn, $query);
                }
                if($result)
                        header("location:notes.php?T=error&NM=Record Deleted Successfully");
                else
                    echo "<script> alert('ERROR :: Could not delete the record.');
                    document.location = 'notes.php';</script>";
            }
        }
        else if($category == "payment")
        {
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $query = "DELETE FROM payments WHERE id='$id'";
                $result = mysqli_query($conn, $query);
                if($result)
                        header("location:payments.php?T=error&NM=Record Deleted Successfully");
                else
                    echo "<script> alert('ERROR :: Could not delete the record.');
                    document.location = 'payments.php';</script>";
            }
        }
    }   
    else
    	header("location:dashboard.php");
?>