<?php
require("connect.php");

try {
    $query = "SELECT              
        COALESCE(SUM(CASE WHEN displayAction = 'Completed' THEN 1 ELSE 0 END), 0) AS TotalCarsPainted,
        COALESCE(SUM(CASE WHEN targetcolor = 'red' AND displayAction = 'Completed' THEN 1 ELSE 0 END), 0) AS Red,
        COALESCE(SUM(CASE WHEN targetcolor = 'green' AND displayAction = 'Completed' THEN 1 ELSE 0 END), 0) AS Green,
        COALESCE(SUM(CASE WHEN targetcolor = 'blue' AND displayAction = 'Completed' THEN 1 ELSE 0 END), 0) AS Blue
        
        FROM exam WHERE displayAction = 'Completed'";

    $statement = $pdo->query($query);
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    // Rename the key for TotalCarsPainted and reorder keys
    $result = [
        'Total Cars Painted' => $result['TotalCarsPainted'],
        'Red' => $result['Red'],
        'Green' => $result['Green'],
        'Blue' => $result['Blue'],
    ];

    // Output JSON data
    header('Content-Type: application/json');
    echo json_encode($result);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}


?>