<?php
require("conn.php"); 

try {
    $query = "SELECT * FROM exam WHERE displayAction != 'Completed' ORDER BY id ASC ";
    $stmt = $conn->query($query);
    $paintjobs = $stmt->fetchAll(PDO::FETCH_ASSOC); // querying the database to fetch paint job data where the displayAction is not 'Completed' and ordering the results by id in ascending order.

    $paintjobsCount = count($paintjobs);
    $paintjobsSlice = array_slice($paintjobs, 0, min(5, $paintjobsCount));
    $paintjobsRemaining = array_slice($paintjobs, 5);   //Slicing the array to separate the first 5 paint jobs ($paintjobsSlice) from the rest ($paintjobsRemaining).

    // Check if there are fewer than or equal to 5 processed jobs
    if ($paintjobsCount <= 5) {
        // Move jobs from the queue to the process list
        $queueQuery = "SELECT * FROM exam WHERE displayAction != 'Completed' ORDER BY id ASC LIMIT 5 OFFSET :offset";
        $queueStmt = $conn->prepare($queueQuery);
        
        // Set the offset parameter
        $offset = 5;
        $queueStmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $queueStmt->execute();
        $queueJobs = $queueStmt->fetchAll(PDO::FETCH_ASSOC);

        // Merge the processed jobs with the newly fetched queue jobs
        $paintjobsSlice = array_merge($paintjobsSlice, $queueJobs);
        // Update the remaining jobs
       
    }   //Checking if there are fewer than or equal to 5 paint jobs. If so, you fetch additional jobs from the queue using OFFSET and LIMIT in the SQL query.
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Paint Jobs</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>


<div id="statistics">
    <p>Paint Job Performance</p>
    <p>Total Cars Painted: <span id="totalCarsPainted"></span></p>
    <p>Red: <span id="redCount"></span></p>
    <p>Green: <span id="greenCount"></span></p>
    <p>Blue: <span id="blueCount"></span></p>
</div>





    <p>Paint Job in Process</p>
    <table class="paintJobTable">
        <thead>
            <tr class="theader">
                <th>Plate No.</th>
                <th>Current Color</th>
                <th>Target Color</th>
                <th>Action</th>
            </tr>
        </thead>
       <tbody class="t-body">
    <?php if (!empty($paintjobsSlice)) : ?>
        <?php foreach ($paintjobsSlice as $paintjob) : ?>
            <?php if ($paintjob['displayAction'] !== 'Completed') : ?>
                <tr>
    <td><?= $paintjob['plateno'] ?></td>
    <td><?= $paintjob['currentcolor'] ?></td>
    <td><?= $paintjob['targetcolor'] ?></td>
    <td>
        <!-- Use label element with data attributes for plateno and class for AJAX trigger -->
        <label class="actioButton mark-completed" data-plateno="<?= $paintjob['plateno'] ?>">
            <?= $paintjob['displayAction'] ?>
        </label>
    </td>
</tr>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="4">No paint jobs found.</td>
        </tr>
    <?php endif; ?>
</tbody>
    </table> <br>

    <p>Paint Job Queue</p>
<table class="paintQueue">
    <thead>
        <tr class="theader">
            <th>Plate No.</th>
            <th>Current Color</th>
            <th>Target Color</th>
        </tr>
    </thead>
    <tbody class="t-body">
        <?php $queueJobs = array_slice($paintjobsRemaining, 0, 5); ?>
        <?php foreach ($queueJobs as $queueJob) : ?>
            <!-- Displaying only the first 5 jobs in the queue -->
            <tr>
                <td><?= $queueJob['plateno'] ?></td>
                <td><?= $queueJob['currentcolor'] ?></td>
                <td><?= $queueJob['targetcolor'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Add this script for AJAX -->
<script>
$(document).ready(function() {
    // AJAX call when label with class 'mark-completed' is clicked
    $('.mark-completed').click(function() {
        // Get plateno from data attribute
        var plateno = $(this).data('plateno');
        
        // Store reference to the clicked label
        var label = $(this);
        
        // AJAX POST request to mark_completed.php
        $.ajax({
            type: 'POST',
            url: 'mark_completed.php',
            data: { plateno: plateno },
            success: function(response) {
                // Remove the parent tr if request was successful
                label.closest('tr').remove();
                
                // Reload the paintjob.php page
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    });
});





// -------------------Sum of Data--------------------
$(document).ready(function() {
    // Function to update the paint job statistics
    function updatePaintJobStatistics() {
        $.ajax({
            type: 'GET',
            url: 'dataComplete.php',
            dataType: 'json',
            success: function(data) {
                // Update the DOM with the fetched data
                $('#totalCarsPainted').text(data['Total Cars Painted']);
                $('#redCount').text(data['Red']);
                $('#greenCount').text(data['Green']);
                $('#blueCount').text(data['Blue']);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    }

    // Initial call to update statistics when the page loads
    updatePaintJobStatistics();

    // Set interval to update the statistics every 5 seconds
    setInterval(updatePaintJobStatistics, 5000);
});
</script>