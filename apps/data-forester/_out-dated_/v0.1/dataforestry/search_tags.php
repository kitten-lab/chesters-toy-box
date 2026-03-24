<?php
include 'db.php';

$term = $_GET['term'] ?? '';

$stmt = $conn->prepare("
    SELECT name 
    FROM tags 
    WHERE name LIKE CONCAT(?, '%')
    ORDER BY name ASC
    LIMIT 10
");

$stmt->bind_param("s", $term);
$stmt->execute();

$result = $stmt->get_result();

$tags = [];

while ($row = $result->fetch_assoc()) {
    $tags[] = $row['name'];
}

echo json_encode($tags);