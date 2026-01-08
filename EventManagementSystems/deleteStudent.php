<?php
include_once 'classes/db1.php';

if (isset($_GET['usn'])) {
    $usn = $_GET['usn'];
    
    // Begin transaction for data consistency
    mysqli_autocommit($conn, FALSE);
    
    try {
        // Delete from registered table first (due to foreign key constraint)
        $delete_registered = "DELETE FROM registered WHERE usn = ?";
        $stmt_registered = $conn->prepare($delete_registered);
        $stmt_registered->bind_param("s", $usn);
        $stmt_registered->execute();
        
        // Delete from participent table
        $delete_participent = "DELETE FROM participent WHERE usn = ?";
        $stmt_participent = $conn->prepare($delete_participent);
        $stmt_participent->bind_param("s", $usn);
        $result = $stmt_participent->execute();
        
        if ($result) {
            mysqli_commit($conn);
            echo "<script>
                alert('Student deleted successfully!');
                window.location.href='Stu_details.php';
            </script>";
        } else {
            mysqli_rollback($conn);
            echo "<script>
                alert('Error deleting student!');
                window.location.href='Stu_details.php';
            </script>";
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>
            alert('Error deleting student!');
            window.location.href='Stu_details.php';
        </script>";
    }
} else {
    header('Location: Stu_details.php');
    exit();
}

mysqli_close($conn);
?>