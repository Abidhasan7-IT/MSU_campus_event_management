<?php

include_once 'classes/db1.php';

// Check if user is logged in
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['username'])) {
    header('Location: login_form.php');
    exit();
}

// Pagination variables
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 7; // Number of records per page
$offset = ($page - 1) * $records_per_page;

// Count total records for pagination
$count_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM events e JOIN event_info ef ON e.event_id = ef.event_id JOIN staff_coordinator s ON e.event_id = s.event_id JOIN student_coordinator st ON e.event_id = st.event_id");
$total_records = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_records / $records_per_page);

// Fetch records for current page with participant count
$result = mysqli_query($conn, "SELECT e.*, ef.*, s.*, st.*, COALESCE(r.participant_count, 0) as participents FROM events e JOIN event_info ef ON e.event_id = ef.event_id JOIN staff_coordinator s ON e.event_id = s.event_id JOIN student_coordinator st ON e.event_id = st.event_id LEFT JOIN (SELECT event_id, COUNT(*) as participant_count FROM registered GROUP BY event_id) r ON e.event_id = r.event_id LIMIT $offset, $records_per_page");
?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page MSU</title>
    <link rel='icon' href='images/logo.png' type='image/x-icon' />
</head>

<body>
    <?php include 'utils/adminHeader.php' ?>


    <div class="content">
        <div class="container-fluid">

            <h1 class="text-center">Event details</h1>
            <div class="text-center">
                <a class="btn btn-success mb-4" href="createEventForm.php">Create Event</a><!--register button-->
            </div>
            <?php
            if (mysqli_num_rows($result) > 0) {
            ?>
                <div class="table-responsive" style="margin-top: 15px;">
                    <table class="table table-hover table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>

                                <th>Event Name</th>
                                <th>No. of Participants</th>
                                <th>Price</th>
                                <th>Student Co-ordinator</th>
                                <th>Staff Co-ordinator</th>

                                <th>Date</th>

                                <th>Time</th>
                                <th>Location</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<tr>';


                                echo '<td>' . htmlspecialchars($row['event_title']) . '</td>';
                                echo '<td class="text-center"><span class="badge badge-primary">' . $row['participents'] . '</span></td>';
                                echo '<td>RM ' . htmlspecialchars($row['event_price']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['st_name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['Date']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['location']) . '</td>';

                                echo '<td>'

                                    . '<a class="btn btn-danger btn-sm" href="deleteEvent.php?id=' . $row['event_id'] . '" onclick="return confirm(\'Are you sure you want to delete this event?\')">Delete</a> '
                                    . '</td>';
                                echo '</tr>';


                                $i++;
                            }

                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination controls -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php
                        // Previous button
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
                        }

                        // Page numbers
                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                        }

                        // Next button
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            <?php
            }

            ?>
        </div>
    </div>

    <?php require 'utils/footer.php'; ?>
</body>

</html>