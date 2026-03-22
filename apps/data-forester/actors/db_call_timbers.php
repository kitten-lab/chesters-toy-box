<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "DB CALLED\n";
?>
<?php 
include 'db.php';
$limit = 20;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;
$result = $conn->query("
    SELECT 
        timbers.id,
        timbers.content,
        timbers.order_index,
        timbers.speaker,
        timbers.block_id,
        timbers.parent_id,
        logs.title,
        logs.source,
    GROUP_CONCAT(CONCAT(tags.name, '::', IFNULL(tags.type, 'none')) SEPARATOR '||') as tag_data
    FROM timbers
    JOIN logs ON timbers.log_id = logs.id
    LEFT JOIN timber_tags ON timbers.id = timber_tags.timber_id
    LEFT JOIN tags ON timber_tags.tag_id = tags.id
    WHERE timbers.parent_id IS NULL
    GROUP BY timbers.id
    ORDER BY timbers.id DESC
    LIMIT $limit OFFSET $offset
");
$total_result = $conn->query("SELECT COUNT(*) as total FROM timbers WHERE parent_id IS NULL");
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];

$total_pages = ceil($total / $limit);
?>
