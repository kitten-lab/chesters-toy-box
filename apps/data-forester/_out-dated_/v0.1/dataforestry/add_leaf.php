<?php
include 'db.php';

$parent_id = intval($_POST['parent_id']);
$content = $_POST['content'];

// reuse same log_id as parent
$stmt = $conn->prepare("SELECT log_id FROM timbers WHERE id = ?");
$stmt->bind_param("i", $parent_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$log_id = $row['log_id'];

// insert new timber
$stmt = $conn->prepare("
    INSERT INTO timbers 
    (log_id, content, order_index, speaker, block_id, parent_id)
    VALUES (?, ?, ?, ?, ?, ?)
");

$order_index = 0;
$speaker = 'user';
$block_id = 0;

$stmt->bind_param("isissi", $log_id, $content, $order_index, $speaker, $block_id, $parent_id);
$stmt->execute();

$new_id = $conn->insert_id;

// get log_code
$result = $conn->query("SELECT log_code FROM logs WHERE id = $log_id");
$log_code = $result->fetch_assoc()['log_code'];

echo json_encode([
    "id" => $new_id,
    "content" => $content,
    "log_code" => $log_code
]);