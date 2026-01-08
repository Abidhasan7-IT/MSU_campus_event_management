<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create Event Form</title>
        <link rel="icon" href="images/logo.png" type="image/x-icon">
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
    </head>
    <body>
    <?php require 'utils/adminHeader.php'; ?>
  <form method="POST" enctype="multipart/form-data">
  
  <div class="w3-container"> 
  
  <div class ="content"><!--body content holder-->
            <div class = "container">
                <div class ="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                <label>Event ID:</label><br>
    <input type="number" name="event_id" required class="form-control"><br><br>
    
    <label>Event Name:</label><br>
    <input type="text" name="event_title" required class="form-control"><br><br>

    <label>Event Price:</label><br>
    <input type="number" name="event_price" required class="form-control"><br><br>

    <label>Upload Event Image:</label><br>
    <input type="file" name="event_image" required class="form-control" accept="image/*"><br><br>

    <label>Type_ID </label><br>
    <input type="number" name="type_id" required class="form-control"><br><br>

    <label>Event Date</label><br>
    <input type="date" name="Date" required class="form-control"><br><br>

     <label>Event Time</label><br>
    <input type="text" name="time" required class="form-control"><br><br>

    <label>Event Location</label><br>
    <input type="text" name="location" required class="form-control"><br><br>
    <label>Staff co-ordinator name</label><br>
    <input type="text" name="sname" required class="form-control"><br><br>
    <label>Student co-ordinator name</label><br>
    <input type="text" name="st_name" required class="form-control"><br><br>

    <button type="submit" name="update" class = "btn btn-default pull-right">Create Event <span class="glyphicon glyphicon-send"></span></button>

    <a class="btn btn-default navbar-btn" href = "adminPage.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>

  
  </div></div></div>
  </form>
    

    
    </body>

  <?php require 'utils/footer.php'; ?>
</html>

<?php

  if (isset($_POST["update"]))
  {
  $event_id=$_POST["event_id"];
    $event_title=$_POST["event_title"];
    $event_price=$_POST["event_price"];

    $type_id=$_POST["type_id"];
    $name=$_POST["sname"];
    $st_name=$_POST["st_name"];
    $Date=$_POST["Date"];
    $time=$_POST["time"];
    $location=$_POST["location"];
    
    // Handle file upload
    $img_link = "";
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] == 0) {
        $allowed = array('jpg' => 'image/jpg', 'jpeg' => 'image/jpeg', 'gif' => 'image/gif', 'png' => 'image/png');
        $filename = $_FILES['event_image']['name'];
        $filetype = $_FILES['event_image']['type'];
        $filesize = $_FILES['event_image']['size'];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Error: Please select a valid file format.");
        }
        
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            die("Error: File size is larger than the allowed limit (5MB).");
        }
        
        // Verify MYME type of the file
        if (in_array($filetype, $allowed)) {
            // Sanitize filename
            $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
            
            // Create upload directory if it doesn't exist
            $upload_dir = "images/uploads/";
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            // Generate unique filename to prevent conflicts
            $new_filename = "event_" . $event_id . "_" . uniqid() . "." . $ext;
            $target = $upload_dir . $new_filename;
            
            // Move the uploaded file to the target location
            if (move_uploaded_file($_FILES['event_image']['tmp_name'], $target)) {
                $img_link = $target;
            } else {
                die("Error: There was a problem uploading your file. Please try again.");
            }
        } else {
            die("Error: Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.");
        }
    } else {
        die("Error: File upload error - " . $_FILES['event_image']['error']);
    }
    
    if(!empty($event_id) && !empty($event_title) && !empty($event_price) && !empty($img_link) && !empty($type_id) )
    {
      include 'classes/db1.php';
        
        
   
        // Prepare and execute the statements separately to handle potential errors better
        $stmt1 = $conn->prepare("INSERT INTO events(event_id,event_title,event_price,img_link,type_id) VALUES(?,?,?,?,?)");
        $stmt1->bind_param("isdsi", $event_id, $event_title, $event_price, $img_link, $type_id);
                
        $stmt2 = $conn->prepare("INSERT INTO event_info (event_id,Date,time,location) VALUES(?,?,?,?)");
        $stmt2->bind_param("isss", $event_id, $Date, $time, $location);
                
        $stmt3 = $conn->prepare("INSERT INTO student_coordinator(sid,st_name,phone,event_id) VALUES(?,?,NULL,?)");
        $stmt3->bind_param("isi", $event_id, $st_name, $event_id);
                
        $stmt4 = $conn->prepare("INSERT INTO staff_coordinator(stid,name,phone,event_id) VALUES(?,?,NULL,?)");
        $stmt4->bind_param("isi", $event_id, $name, $event_id);
                
        // Execute all statements in a transaction
        $conn->autocommit(FALSE);
                
        $success = true;
        if (!$stmt1->execute()) {
            $success = false;
        }
        if (!$stmt2->execute()) {
            $success = false;
        }
        if (!$stmt3->execute()) {
            $success = false;
        }
        if (!$stmt4->execute()) {
            $success = false;
        }
                
        if ($success) {
            $conn->commit();
            echo "<script>
            alert('Event Inserted Successfully!');
            window.location.href='adminPage.php';
            </script>";
        } else {
            $conn->rollback();
            echo"<script>
            alert('Event already exists or error occurred!');
            window.location.href='createEventForm.php';
            </script>";
        }
                
        // Close statements
        $stmt1->close();
        $stmt2->close();
        $stmt3->close();
        $stmt4->close();
     
        $conn->close();
      
    }
    else
    {
      echo"<script>
      alert('All fields are required');
      window.location.href='createEventForm.php';
      </script>";
    }
  }
?>