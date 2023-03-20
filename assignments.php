<div class="row my-3 mt-5">
    <table class="table table-striped table-bordered">
        <tr class="bg-primary">
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Attachment</th>
            <th>Due Date</th>
            <th>Action</th>
        </tr>
        <?php
        $query = "SELECT * FROM assignments WHERE ClassId='$cid'";
        $assignments = mysqli_query($conn, $query);

        if (!$assignments)
            echo "<script>alert('There was some sql query error.')</script>";

        $sno = 1;
        while ($assignmentdata = mysqli_fetch_array($assignments)) {
        ?>
            <tr>
                <td><?php echo $sno ?></td>
                <td><?php echo $assignmentdata[1] ?></td>
                <td style="max-width: 500px;"><?php echo $assignmentdata[2] ?></td>
                <td style="max-width: 250px;"><?php echo $assignmentdata[5] == "" ? "<span class='text-danger'>No Attachment</span>" : "<a target='_blank' href='attachments/$assignmentdata[5]'>$assignmentdata[5]</a>" ?></td>
                <td><?php echo date("d-m-Y g:i A", strtotime($assignmentdata[4])) ?></td>
                <td class="text-center">
                    <button type="button" class="btn text-info" data-toggle="modal" data-target="#assignmentModal<?php echo $assignmentdata[0] ?>"><i class="far fa-lg fa-arrow-circle-right"></i></button>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="assignmentModal<?php echo $assignmentdata[0] ?>" tabindex="-1" role="dialog" aria-labelledby="assignmentModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">submit Assignment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="text-center"><b>Title : <?php echo $assignmentdata[1] ?></b></p>
                            <p class="text-justify"><b>Description : </b><?php echo $assignmentdata[2] ?></p>
                            <p class="text-justify"><b>Attachment : </b><?php echo $assignmentdata[5] == "" ? "<span class='text-danger'>No Attachment</span>" : "<a target='_blank' href='attachments/$assignmentdata[5]'>$assignmentdata[5]</a>" ?></p>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <label>Attatch a File</label>
                                <div class="custom-file mb-3">
                                    <input type="file" id="attachment<?php echo $assignmentdata[0]?>" name="attachment" class="custom-file-input" required>
                                    <label class="custom-file-label">Choose a file</label>
                                </div>
                                <div class="form-group">
                                    <label>Comments (Optional)</label>
                                    <input type="text" name="comments" placeholder="Add a comment (optional)" class="form-control">
                                </div>
                                <div class="mt-4 text-center">
                                <hr />
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times"></i> Close</button>
                                    <input type="submit" value="Submit" class="btn btn-primary mx-3" name="submit">
                                </div>
                                <input type="hidden" name="assignmentid" value="<?php echo $assignmentdata[0] ?>">
                            </form>
                        </div>
                        <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times"></i> Close</button>
                            <button type="submit" form="myForm" class="btn btn-primary" name="submit">Submit</button>
                        </div> -->
                    </div>
                </div>
            </div>
            <script>
                $('#attachment<?php echo $assignmentdata[0] ?>').change(function(e) {
                    var fileName = e.target.files[0].name;
                    $('.custom-file-label').html(fileName);
                });
            </script>
        <?php
            $sno++;
        }
        ?>
    </table>
</div>

<?php
if(isset($_POST['submit']))
{
    $comments = $_POST['comments'];
    $assignmentid = $_POST['assignmentid'];
    $studentid = $_SESSION['studentid'];

    if(isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0)
    {
        $path = "attachments/assignment_submissions/".$_FILES['attachment']['name'];
        $r = move_uploaded_file($_FILES['attachment']['tmp_name'],$path);
        $filename = $_FILES['attachment']['name'];
        if($r)
        {
            $query = "INSERT INTO assignment_submissions VALUES(NULL,'$assignmentid','$studentid','$cid','$comments','$filename',NULL)";   
            $r = mysqli_query($conn, $query);

            if($r)
                echo "<script>successNotification('Assignment Submitted.')</script>";
            else
                echo "<script>errorNotification(\"SQL Error :: ".mysqli_error($conn)."\")</script>";
        }
        else
            echo "<script>errorNotification('There was some problem while uploading file.')</script>";
    }
    
}
?>