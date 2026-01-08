<?php
require 'classes/db1.php';
$id=$_GET['id'];
$result = mysqli_query($conn,"SELECT events.event_id, events.event_title, events.event_price, events.img_link, events.type_id, ef.Date, ef.time, ef.location, s.sid, s.st_name, s.phone as student_phone, s.event_id as student_event_id, st.stid, st.name as staff_name, st.phone as staff_phone, st.event_id as staff_event_id FROM events LEFT JOIN event_info ef ON events.event_id = ef.event_id LEFT JOIN student_coordinator s ON events.event_id = s.event_id LEFT JOIN staff_coordinator st ON events.event_id = st.event_id WHERE events.event_id = $id");
?>


<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Events MSU</title>
        <link rel='icon' href='images/logo.png' type='image/x-icon'/ >
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
    </head>

    <body>
   
    
        <?php require 'utils/header.php'; ?><!--header content. file found in utils folder-->
       
        <div class = "content"><!--body content holder-->
            <div class = "container">
                <div class = "col-xs-12 col-sm-12 col-md-12"><!--body content title holder with 12 grid columns-->
                   

            </div>
       
         
            <?php
                if (!$result) {
                    echo "Error: " . mysqli_error($conn);
                } else if (mysqli_num_rows($result) > 0) {

                 $i=0;
                while($row = mysqli_fetch_array($result)) {
             
                ?>
                <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12">
            <hr>
            </div>

<div class="row">
                <section>
                    <div class="container">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                              

                          <img src=" <?php  echo $row['img_link'];?>" class="img-responsive">
                        </div>
                        <div class="subcontent col-xs-12 col-sm-12 col-md-6">                        
                            <h1 style="color:#003300 ; font-size:28px ; text-align: center;" ><u><strong><?php echo '<td>' . $row['event_title'] . '</td>';?></strong></u></h1><!--title-->
                            <p style="color:#003300  ;font-size:16px; text-align: left;" ><!--content-->
                            <?php
                            
                            // Display all available event data
                            echo 'Event ID: ' . $row['event_id'] . '<br>';
                            echo 'Event Title: ' . $row['event_title'] . '<br>';
                            echo 'Date:' . $row['Date'] .'<br>'; 
                            echo 'Time:' . $row['time'] .'<br>'; 
                            echo 'Location:' . $row['location'] .'<br>'; 
                            echo 'Student Co-ordinator Name: ' . $row['st_name'] . '<br>';
                            echo 'Student Co-ordinator Phone: ' . $row['student_phone'] . '<br>';
                            echo 'Student Co-ordinator Event ID: ' . $row['student_event_id'] . '<br>';
                            echo 'Staff Co-ordinator Name: ' . $row['staff_name'] . '<br>';
                            echo 'Staff Co-ordinator Phone: ' . $row['staff_phone'] . '<br>';
                            echo 'Staff Co-ordinator Event ID: ' . $row['staff_event_id'] . '<br>';
                            echo 'Event Price: ' . $row['event_price'] . '<br>' ;
                            echo 'Type ID: ' . $row['type_id'] . '<br>';
                        
                        ?>
                            </p>
                            
                            <br><br>
                        <?php 
                        $id= $row['event_id'];
                        echo '<a class="btn btn-default" href="register.php?id='.$id.'"> <span class="glyphicon glyphicon-circle-arrow-right"></span>Register</a>'
                            ?>
                         </div><!--subcontent div-->
                    </div><!--container div-->
                </section>
</div>
 </div><!--row div-->
                <?php
                $i++;
                    }
                } else {
                    echo "<div class='container'><p>No events found for this type.</p></div>";
                }
           ?>
<div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12">
            <hr>
            </div>
            </div>
        <?php 
        ?>
            <a class="btn btn-default" href="index.php"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a>
            

        </div><!--body content div-->

        <?php require 'utils/footer.php'; ?><!--footer content. file found in utils folder-->
    </body>
    
</html>
