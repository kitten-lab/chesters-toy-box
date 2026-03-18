<?php
include 'db.php';

$timber_id = intval($_POST['timber_id']);
$tag = $_POST['tag'];

$stmt = $conn->prepare("
    DELETE tt FROM timber_tags tt
    JOIN tags t ON tt.tag_id = t.id
    WHERE tt.timber_id = ? AND t.name = ?
");

$stmt->bind_param("is", $timber_id, $tag);
$stmt->execute();

echo "OK";