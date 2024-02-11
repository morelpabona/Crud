<?php
require("conn.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plateno = $_POST["plateno"];
    $currentColor = $_POST["current"];
    $targetColor = $_POST["target"];
    $action = "Mark as Completed";

    $sql = "INSERT INTO exam (plateno, currentcolor, targetcolor, displayAction) VALUES (:plateno, :currentColor, :targetColor, :displayAction)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':plateno', $plateno);
        $stmt->bindParam(':currentColor', $currentColor);
        $stmt->bindParam(':targetColor', $targetColor);
        $stmt->bindParam(':displayAction', $action);

    if ($stmt->execute()) {
        header("Location: paintjob.php");
        exit();
    } else {
        echo "Failed!";
    }
} else {
    echo "No data fetched";
}
?>