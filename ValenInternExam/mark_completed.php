<?php
require("conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['plateno'])) {
    try {
        $plateno = $_POST['plateno'];

        // Your code to update the paint job status and displayAction to 'Completed'
        $updateQuery = "UPDATE exam SET displayAction = 'Completed' WHERE plateno = :plateno";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bindParam(':plateno', $plateno);
        $stmt->execute();

        // Send a success response

    } catch (PDOException $e) {
        // Send an error response
        echo "Error: " . $e->getMessage();
    }
}
?>
