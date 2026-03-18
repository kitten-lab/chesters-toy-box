<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM timbers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: view_timbers.php");
exit;
?>