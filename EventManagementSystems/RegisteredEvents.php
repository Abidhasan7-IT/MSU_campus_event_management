<?php
require_once 'utils/header.php';
require_once 'utils/styles.php';

$usn = $_POST['usn'];

include_once 'classes/db1.php';

// First check if the student exists in the participent table using prepared statement
try {
    $stmt = $conn->prepare("SELECT * FROM participent WHERE usn = ?");
    if ($stmt) {
        $stmt->bind_param("s", $usn);
        $stmt->execute();
        $student_result = $stmt->get_result();
    } else {
        // Handle case where table doesn't exist
        echo '<div class="container"><h2>Error: Database table not found. Please contact administrator.</h2></div>';
        include 'utils/footer.php';
        exit();
    }
} catch (Exception $e) {
    // Handle case where table doesn't exist
    echo '<div class="container"><h2>Error: Database table not found. Please contact administrator.</h2></div>';
    include 'utils/footer.php';
    exit();
}

if ($student_result->num_rows == 0) {
    // Student not found
    echo '<div class="container"><h2>Student with USN: ' . htmlspecialchars($usn) . ' not found!</h2></div>';
    include 'utils/footer.php';
    exit();
}

// Student exists, now get registered events
try {
    $stmt2 = $conn->prepare("SELECT * FROM registered r,staff_coordinator s ,event_info ef ,student_coordinator st,events e where e.event_id= ef.event_id and e.event_id= s.event_id and e.event_id= st.event_id and r.usn= ? and r.event_id=e.event_id");
    if ($stmt2) {
        $stmt2->bind_param("s", $usn);
        $stmt2->execute();
        $result = $stmt2->get_result();
    } else {
        // Handle case where registered table doesn't exist
        echo '<div class="container"><h2>Error: Registration database not found. Please contact administrator.</h2></div>';
        include 'utils/footer.php';
        exit();
    }
} catch (Exception $e) {
    // Handle case where registered table doesn't exist
    echo '<div class="container"><h2>Error: Registration database not found. Please contact administrator.</h2></div>';
    include 'utils/footer.php';
    exit();
}
?>

<div class = "content">
            <div class = "container">
            <h1> Registered Events</h1>
             <?php
if ($result->num_rows > 0) {
?> 
                <table class="table table-hover" >
                    <thead>
                        <tr>
                            
                            <th>Event_name</th>             
                           <th>Student Co-ordinator</th>
                            <th>Staff Co-ordinator</th>
                           
                            <th>Date</th>
                        
                            <th>Time</th>
                            <th>location </th>
                          
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=0;
                    while($row = $result->fetch_assoc()) {

                            echo '<tr>';
                            echo '<td>' . $row['event_title'] . '</td>';                    
                            echo '<td>' . $row['st_name'] . '</td>';
                            echo '<td>' . $row['name'] . '</td>';
                           
                            echo '<td>'.$row['Date'].'</td>';
                            echo '<td>'.$row['time'].'</td>';
                            echo '<td>'.$row['location'].'</td>';
                            
                         
                            echo '</tr>';  

                            $i++;
                        }
                      
                        ?>
                    </tbody>
                </table>
                    <?php }
                    else{
                    echo 'Not Yet Rgistered any events';
                    
                    }?>
                
                
               
            </div>
        </div>
        <?php include 'utils/footer.php'; ?> 