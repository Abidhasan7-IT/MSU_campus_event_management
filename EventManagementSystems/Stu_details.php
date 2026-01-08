<?php
include_once 'classes/db1.php';

$result = mysqli_query($conn,"SELECT DISTINCT p.usn, p.name, p.branch, p.sem, p.email, p.phone, p.address, e.event_title FROM events e JOIN registered r ON e.event_id = r.event_id JOIN participent p ON r.usn = p.usn ORDER BY p.name");
?>
<!DOCTYPE html>
<html>

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Student Details MSU</title>
        <link rel='icon' href='images/logo.png' type='image/x-icon'/ >
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
        
    </head>

<body><?php include 'utils/adminHeader.php'?>
<div class = "content">
<div class = "container">
<h1>Student details</h1>
<?php
if (mysqli_num_rows($result) > 0) {
?>
 <table class="table table-hover table-striped table-bordered">
        <thead class="thead-dark">
        <tr>
        <th>USN</th>
            <th>Name</th>
            <th>Department</th>
            <th>Semester</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Event</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $i=0;
        while($row = mysqli_fetch_array($result)) {
        ?>
        <tr>
        <td><?php echo htmlspecialchars($row["usn"]); ?></td>
            <td><?php echo htmlspecialchars($row["name"]); ?></td>
            <td><?php echo htmlspecialchars($row["branch"]); ?></td>
            <td><?php echo htmlspecialchars($row["sem"]); ?></td>
            <td><?php echo htmlspecialchars($row["email"]); ?></td>
            <td><?php echo htmlspecialchars($row["phone"]); ?></td>
            <td><?php echo htmlspecialchars($row["address"]); ?></td>
            <td><?php echo htmlspecialchars($row["event_title"]); ?></td>
            <td>
                <a class="btn btn-danger btn-sm" href="deleteStudent.php?usn=<?php echo urlencode($row['usn']); ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
            </td>
           
        </tr>
        <?php
        $i++;
        }
        ?>
        </tbody>
    </table>
 <?php
}
else{
    echo "No result found";
}
?>
</div>
</div>
<?php include 'utils/footer.php'?>;
 </body>
</html>
