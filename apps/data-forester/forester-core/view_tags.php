<?php
include '/dataforestry/db.php';

$tag = $_GET['tag'];

$stmt = $conn->prepare("
    SELECT 
        timbers.content,
        timbers.order_index,
        timbers.speaker,
        timbers.block_id,
        logs.log_code
    FROM timbers
    JOIN logs ON timbers.log_id = logs.id
    JOIN timber_tags ON timbers.id = timber_tags.timber_id
    JOIN tags ON timber_tags.tag_id = tags.id
    WHERE tags.name = ?
    ORDER BY timbers.id DESC
");

$stmt->bind_param("s", $tag);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Tag: <?php echo htmlspecialchars($tag); ?></h2>

<?php while($row = $result->fetch_assoc()): ?>

<div style="margin-bottom:10px; padding:10px; border:1px solid #ccc;">

<div style="font-size:12px; color:#aaa;">
<?php echo $row['log_code']; ?> | 
<?php echo strtoupper($row['speaker'][0]); ?> |
Block <?php echo $row['block_id']; ?>
</div>

<div>
<?php echo htmlspecialchars($row['content']); ?>
</div>

</div>

<?php endwhile; ?>

<a href="/dataforestry/view_timbers.php">← Back</a>