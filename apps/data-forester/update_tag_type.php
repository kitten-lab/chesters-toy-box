<?php
include 'db.php';

$tag_id = intval($_POST['tag_id']);
$type = $_POST['type'];

$stmt = $conn->prepare("UPDATE tags SET type = ? WHERE id = ?");
$stmt->bind_param("si", $type, $tag_id);
$stmt->execute();

echo "OK";