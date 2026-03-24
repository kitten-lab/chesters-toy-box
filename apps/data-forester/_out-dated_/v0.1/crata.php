<?php
include 'db.php';

$result = $conn->query("
    SELECT tags.id, tags.name, tags.type, COUNT(timber_tags.timber_id) as count
    FROM tags
    LEFT JOIN timber_tags ON tags.id = timber_tags.tag_id
    GROUP BY tags.id
    ORDER BY count DESC
");
?>

    <link rel="stylesheet" href="style.css">
<?php include 'header.php'; ?>

<h2>Tags</h2>

<div class="tag-list">

<?php while($tag = $result->fetch_assoc()): ?>

    <div class="tag-row">

        <!-- clickable tag -->
        <span class="tag-name">
    <?php echo htmlspecialchars($tag['name']); ?>
</span>

<a class="tag-view-btn" href="tag.php?tag=<?php echo urlencode($tag['name']); ?>">
    View →
</a>

        <!-- count -->
        <span class="tag-count">
            (<?php echo $tag['count']; ?>)
        </span>

        <!-- dropdown -->
        <select onchange="updateTagType(<?php echo $tag['id']; ?>, this.value)">
            <option value="">-- type --</option>
            <option value="archetype" <?php if ($tag['type']=='archetype') echo 'selected'; ?>>Archetype</option>
            <option value="emotion" <?php if ($tag['type']=='emotion') echo 'selected'; ?>>Emotion</option>
            <option value="character" <?php if ($tag['type']=='character') echo 'selected'; ?>>Character</option>
            <option value="theme" <?php if ($tag['type']=='theme') echo 'selected'; ?>>Theme</option>
            <option value="object" <?php if ($tag['type']=='object') echo 'selected'; ?>>Object</option>
        </select>

    </div>

<?php endwhile; ?>

</div>
<script>
function updateTagType(tagId, type) {
    console.log("Sending:", tagId, type);  // 👈 ADD THIS

    let formData = new URLSearchParams();
    formData.append("tag_id", tagId);
    formData.append("type", type);

    fetch("update_tag_type.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        console.log("Response:", data);  // 👈 ADD THIS
    });
}
</script>
<?php include 'footer.php'; ?>