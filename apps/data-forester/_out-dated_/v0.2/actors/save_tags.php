<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$timber_id = intval($_POST['timber_id']);
$tags_input = $_POST['tags'];

$tags = preg_split('/\s+/', trim($tags_input));

foreach ($tags as $tag) {
    $tag = strtolower(trim($tag));
    if ($tag == "") continue;

    // INSERT or get existing tag
    $stmt = $conn->prepare("
        INSERT INTO tags (name) VALUES (?)
        ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)
    ");
    $stmt->bind_param("s", $tag);
    $stmt->execute();

    $tag_id = $conn->insert_id;

    // LINK to timber
    $stmt = $conn->prepare("
        INSERT IGNORE INTO timber_tags (timber_id, tag_id)
        VALUES (?, ?)
    ");
    $stmt->bind_param("ii", $timber_id, $tag_id);
    $stmt->execute();
}