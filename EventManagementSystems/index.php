<?php
include_once 'classes/db1.php';

// Pagination logic
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5;
$offset = ($page - 1) * $records_per_page;

// Get total records count
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM events");
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

// Fetch events for current page
$result = mysqli_query($conn, "SELECT e.*, COALESCE(r.participant_count, 0) as participents FROM events e LEFT JOIN (SELECT event_id, COUNT(*) as participant_count FROM registered GROUP BY event_id) r ON e.event_id = r.event_id ORDER BY e.event_id DESC LIMIT $records_per_page OFFSET $offset");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MSU Events</title>
        <link rel="icon" href="images/logo.png" type="image/png">
        <?php require 'utils/styles.php';?>
    </head>
    <body>
        <?php require 'utils/header.php'; ?><!--header content. file found in utils folder-->
        <div class = "content"><!--body content holder-->
            <div class = "container">
                <div class = "col-xs-12 col-sm-12 col-md-12"><!--body content title holder with 12 grid columns-->
                    <h1 style="color:#000080 ; font-size:30px ; font-style:bold; text-align: center;"><strong>  Register your Favourite events:</strong></h1><!--body content title-->

            </div>
            
            
            <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12">
            <hr>
            </div>
            </div>
            
            <div class="row">
                <section>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_array($result)) {
                ?>  
                    <div class="container">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <img src="<?php echo $row['img_link'];?>" class="img-responsive">
                        </div>
                        <div class="subcontent col-xs-12 col-sm-12 col-md-6">
                            <h1 style="color:#003300 ; font-size:28px ;" ><u><strong><?php echo $row['event_title']; ?></strong></u></h1>
                            <p style="text-align: left;">
                                <strong>Price:</strong> <?php echo $row['event_price']; ?><br>
                                <strong>Participants:</strong> <?php echo $row['participents']; ?><br>
                                <strong>Type ID:</strong> <?php echo $row['type_id']; ?><br>
                            </p>
                            <br><br>
                            <?php 
                            $id = $row['event_id'];
                            echo '<a class="btn btn-default" href="viewEvent.php?id='.$id.'"> <span class="glyphicon glyphicon-circle-arrow-right"></span>View Event</a>';
                            ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <hr>
                    </div>
                <?php
                    }
                } else {
                    echo "<p>No events available at the moment.</p>";
                }
                ?>
                </section>
            </div>
            
            <!-- Pagination Controls -->
            <?php if ($total_records > $records_per_page): ?>
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=1" aria-label="First">
                                            <span aria-hidden="true">&laquo;&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php
                                // Show page numbers
                                $start = max(1, $page - 2);
                                $end = min($total_pages, $page + 2);
                                
                                for ($i = $start; $i <= $end; $i++):
                                ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $total_pages; ?>" aria-label="Last">
                                            <span aria-hidden="true">&raquo;&raquo;</span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <hr>
            </div>
            </div>
          
        </div><!--body content div-->
  
        <?php require 'utils/footer.php'; ?><!--footer content. file found in utils folder-->
    </body>
</html>