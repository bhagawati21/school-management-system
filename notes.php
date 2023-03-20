<div class="row my-3 mt-5">
    <table class="table table-striped table-bordered">
        <tr class="bg-primary">
            <th>#</th>
            <th>Title</th>
            <th>Description</th>
            <th>Subject</th>
            <th>Attachment</th>
        </tr>
        <?php
        $query = "SELECT notes.*, subjects.* FROM notes LEFT JOIN subjects ON notes.SubjectId = subjects.id WHERE notes.ClassId='$cid'";
        $notes = mysqli_query($conn, $query);

        if (!$notes)
            echo "<script>alert('There was some sql query error.')</script>";

        $sno = 1;
        while ($notesdata = mysqli_fetch_array($notes)) {
        ?>
            <tr>
                <td><?php echo $sno ?></td>
                <td><?php echo $notesdata[1] ?></td>
                <td style="max-width: 500px;"><?php echo $notesdata[2] ?></td>
                <td><?php echo "$notesdata[8] ($notesdata[7])"?></td>
                <td style="max-width: 250px;"><?php echo $notesdata[5] == "" ? "<span class='text-danger'>No Attachment</span>" : "<a target='_blank' href='attachments/Notes/$notesdata[5]'>$notesdata[5]</a>" ?></td>
            </tr>
        <?php
            $sno++;
        }
        ?>
    </table>
</div>