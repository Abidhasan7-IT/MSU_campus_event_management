
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MSU Event Register</title>
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
    </head>
    <body>
    <?php require 'utils/header.php'; ?>
    <div class ="content"><!--body content holder-->
            <div class = "container">
                <div class ="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
    <form method="POST">

   
        <label>Student ID:</label><br>
        <input type="text" name="usn" class="form-control" required><br><br>

        <label>Student Name:</label><br>
        <input type="text" name="name" class="form-control" required><br><br>

        <label>Dept:</label><br>
        <input type="text" name="branch" class="form-control" required><br><br>

        <label>Semester:</label><br>
        <input type="text" name="sem" class="form-control" required><br><br>

        <label>Email:</label><br>
        <input type="text" name="email"  class="form-control" required ><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"  class="form-control" required><br><br>

        <label>Address:</label><br>
        <input type="text" name="address"  class="form-control" required><br><br>

        <button type="submit" name="update" required>Submit</button><br><br>
        <a href="usn.php" ><u>Already registered ?</u></a>

    </div>
    </div>
    </div>
    </form>
    

    <?php require 'utils/footer.php'; ?>
    </body>
</html>

<?php
$event_id=$_GET['id'];

    if (isset($_POST["update"]))
    {
        $usn=$_POST["usn"];
        $name=$_POST["name"];
        $branch=$_POST["branch"];
        $sem=$_POST["sem"];
        $email=$_POST["email"];
        $phone=$_POST["phone"];
        $college=$_POST["address"];
        

        if( !empty($usn) || !empty($name) || !empty($branch) || !empty($sem) || !empty($email) || !empty($phone) || !empty($college) )
        {
            include 'classes/db1.php';     
            
            // Check if student is already registered for this event
            $check_sql = "SELECT * FROM registered WHERE usn = ? AND event_id = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("ss", $usn, $event_id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            
            if ($result->num_rows > 0) {
                // Student is already registered for this event
                echo "<script>
                alert('You are already registered for this event!');
                window.location.href='usn.php';
                </script>";
            } else {
                // Check if student already exists in participent table
                $check_participent = "SELECT * FROM participent WHERE usn = ?";
                $stmt_participent = $conn->prepare($check_participent);
                $stmt_participent->bind_param("s", $usn);
                $stmt_participent->execute();
                $participent_result = $stmt_participent->get_result();
                
                if ($participent_result->num_rows == 0) {
                    // Student doesn't exist, insert into participent table first
                    $INSERT="INSERT INTO participent (usn,name,branch,sem,email,phone,address) VALUES(?,?,?,?,?,?,?)";
                    $stmt_insert = $conn->prepare($INSERT);
                    $stmt_insert->bind_param("sssssss", $usn, $name, $branch, $sem, $email, $phone, $college);
                    
                    if($stmt_insert->execute()) {
                        // Now insert into registered table
                        $INSERT_REGISTERED = "INSERT INTO registered (usn, event_id) VALUES (?, ?)";
                        $stmt_reg = $conn->prepare($INSERT_REGISTERED);
                        $stmt_reg->bind_param("ss", $usn, $event_id);
                        
                        if($stmt_reg->execute()) {
                            echo "<script>
                            alert('Registered Successfully!');
                            window.location.href='usn.php';
                            </script>";
                        } else {
                            echo "<script>
                            alert('Registration failed for event');
                            window.location.href='usn.php';
                            </script>";
                        }
                        $stmt_reg->close();
                    } else {
                        echo"<script>
                        alert('Error registering student details');
                        window.location.href='usn.php';
                        </script>";
                    }
                    $stmt_insert->close();
                } else {
                    // Student already exists in participent table, just register for the event
                    $INSERT_REGISTERED = "INSERT INTO registered (usn, event_id) VALUES (?, ?)";
                    $stmt_reg = $conn->prepare($INSERT_REGISTERED);
                    $stmt_reg->bind_param("ss", $usn, $event_id);
                    
                    if($stmt_reg->execute()) {
                        echo "<script>
                        alert('Registered Successfully!');
                        window.location.href='usn.php';
                        </script>";
                    } else {
                        echo "<script>
                        alert('Registration failed for event');
                        window.location.href='usn.php';
                        </script>";
                    }
                    $stmt_reg->close();
                }
                $stmt_participent->close();
            }
            $check_stmt->close();
            $conn->close();
        }
        else
        {
            echo"<script>
            alert('All fields are required');
            window.location.href='register.php';
            </script>";
        }
    }
    
?>