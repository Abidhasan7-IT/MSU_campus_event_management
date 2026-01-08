<?php
include_once 'classes/db1.php';

// Process login if form is submitted
if (isset($_POST["update"]))
{
    $myusername = $_POST['name'];
    $mypassword = $_POST['password'];
    
    // Query the admin table for the user
    $stmt = $conn->prepare("SELECT id, username, password, role FROM admin WHERE username = ?");
    $stmt->bind_param("s", $myusername);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Check if password is hashed or plain text
        $password_verified = false;
        
        // First, try to verify as hashed password
        if (password_verify($mypassword, $row['password'])) {
            $password_verified = true;
        }
        // If that fails, check if it's a plain text match
        elseif ($row['password'] === $mypassword) {
            $password_verified = true;
        }
        
        if ($password_verified) {
            // Login successful
            session_start();
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            echo "<script>
            alert('Login Successful');
            window.location.href='adminPage.php';
            </script>";
            exit; // Important: stop execution after redirect
        } else {
            // Invalid password
            $error_message = "Invalid credentials";
        }
    } else {
        // User not found
        $error_message = "Invalid credentials";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login MSU</title>
        <link rel='icon' href='images/logo.png' type='image/x-icon'/ >
        <style>
            span.error{
                color: red;
            }            
        </style>  
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
    </head>
    <body>
        <?php require 'utils/header.php'; ?><!--header content. file found in utils folder-->
        <div class = "content"><!--body content holder-->
            <div class = "container">
                <div class ="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                  
                    <form method="POST"><!--form-->
                      
                            <!--username field-->
                            <label>UserName:</label><br>
        <input type="text" name="name" class="form-control" required><br>
                            
                    
        <label>Password</label><br>
        <input type="password" name="password" class="form-control" required><br>
                        <button type = "submit" name="update" class = "btn btn-default">Login</button>
                    </form>
                    <?php
                    if (isset($error_message)) {
                        echo "<div class='error'><span class='error'>" . htmlspecialchars($error_message) . "</span></div>";
                    }
                    ?>
                </div><!--col md 6 div-->
            </div><!--container div-->
        </div><!--content div-->
        <?php require 'utils/footer.php'; ?><!--footer content. file found in utils folder-->


</body>
</html>
