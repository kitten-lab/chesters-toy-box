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
        logs.log_code,
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

<!-- OPENING DOCUMENT -->
<!DOCTYPE html>
<html>
<head>
    <title>Timbers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- INSERT HEADER -->
<?php include 'header.php'; ?>

<!-- PAGINATION -->
<?php include 'paginator.php'; ?>

<!-- FILTER RESULTS -->
<span class="filters">
<button onclick="setFilter('all')">All</button>
<button onclick="setFilter('tagged')">Tagged</button>
<button onclick="setFilter('untagged')">Untagged</button>
</span>

<!--BEGIN GRID -->
<div class="timber-grid">
<?php while($row = $result->fetch_assoc()): ?>
    <?php 
    // skip children, only render roots
    if ($row['parent_id']) continue; 
    
    // determine speaker prefix
    $prefix = ($row['speaker'] === 'user') ? 'U' : 'A'; 
    ?>

<!--BEGIN ROWS of TIMBER -->
    <div 
    id="timber-<?php echo $row['id']; ?>" 
    class="timber"
    data-tagged="<?php echo !empty($row['tag_data']) ? 'true' : 'false'; ?>"
    >

<!--begin content output here-->
<!--#######################-->

    <div class="timber-box">
    <div style="position: absolute; right: 0; margin-top: -7px;">
        <span style="font-size: 12px; padding-right: 4px;">  

    <a 
        href="delete_timber.php?id=<?php echo $row['id']; ?>" 
        onclick="return confirm('Delete this timber?<br> <?php echo $row['content'] ?>');"
        class="delete_timber_x" class="positon: relative;">🗑️</a> 
        </span>

    </div> 
    <span class="small"> 

    <button onclick="showManageInput(<?php echo $row['id']; ?>)" style="width: 30px; margin-left: -4px; position: relative; background: none; border: none;">⚙️
    </button>
        <?php echo $prefix ?> | 
        <?php echo $row['log_code']; ?>-
        <?php echo $prefix . $row['block_id']; ?>-
        <?php echo $row['order_index'] + 1; ?> 
    
    </span>
    </div>

    <div class="leaf">
        <?php echo htmlspecialchars($row['content']); ?>
    </div>

<!--#######################-->
<!--end content output-->
    </div>
<!-- END ROWS OF TIMBERS -->
<!-- BEGIN CHAMBER OF EDITS -->

    <div id="manage-input-<?php echo $row['id']; ?>" 
        style="display:none; margin-top:5px;" class="tool-box">
        <div id="overlay" class="active"></div>

    <div class="tools-panel">
    <div class="tools-body">
    <button onclick="showManageInput(<?php echo $row['id']; ?>)">
    Close Manager
    </button>

    <a href="delete_timber.php?id=<?php echo $row['id']; ?>" 
    onclick="return confirm('Delete this timber?<br> <?php echo $row['content'] ?>');"
    class="btn delete_timber_x">Delete</a>

    <div style="background: white; padding: 12px; border: 1px solid white;">

    <h1>Record Keeper</h1>
    <span class="branch">
        Log Yard Code: <?php echo $row['log_code']; ?>-
        <?php echo $prefix . $row['block_id']; ?>-
        <?php echo $row['order_index'] + 1; ?>
    </span>

    <br>
    
    <span class="branch all-caps">
        Speaker: <?php echo $row['speaker'] ?> 
    </span>

    <h1>Timber Content</h1>
    <div class="leaf">
        <?php echo htmlspecialchars($row['content']); ?>
    </div>

    <h1>Tags</h1>
    <input 
    type="text" 
    placeholder="add tags..." 
    onkeydown="handleTagKeydown(event, <?php echo $row['id']; ?>)"
    oninput="handleTagAutocomplete(event, <?php echo $row['id']; ?>)"
    style="margin-top:5px;"
    > 
    <div class="tag-suggestions" id="suggestions-<?php echo $row['id']; ?>"></div><br>
    <span id="tags-<?php echo $row['id']; ?>"></span>
    <?php
    if (!empty($row['tag_data'])) {
    $tag_items = explode("||", $row['tag_data']);

    foreach ($tag_items as $item) {
        if (!$item || strpos($item, '::') === false) continue;

        list($tag, $type) = explode("::", $item, 2);

        $tag = htmlspecialchars($tag);
        $type = htmlspecialchars($type ?: 'none');

        echo "
        <span class='tag tag-$type' data-tag='$tag' data-id='{$row['id']}'>
        <a href='tag.php?tag=" . urlencode($tag) . "'>$tag</a>
        <span class='remove'>×</span>
        </span>";
    }

}
    ?>
    </div>
    </div>
    </div>
<!--END CHAMBER OF EDITS -->
</div>


<?php endwhile; ?>
</div>
<!-- END GRID -->



<div class="timber-grid">
<?php while($row = $result->fetch_assoc()): ?>
<?php if ($row['parent_id']) continue; ?>
<?php $prefix = ($row['speaker'] === 'user') ? 'U' : 'A'; ?>
<div 
    id="timber-<?php echo $row['id']; ?>" 
    class="timber"
    data-tagged="<?php echo !empty($row['tag_data']) ? 'true' : 'false'; ?>">

    <div class="timber-box">

    <div class="leaf">
    
    <span class="small"> 
    <?php echo $prefix ?> | <?php echo $row['log_code']; ?>-<?php echo $prefix . $row['block_id']; ?>-<?php echo $row['order_index'] + 1; ?>
    </span> 
    
    <div style="background: white; padding: 10px; border: 1px dashed lightgray;">
    <?php echo htmlspecialchars($row['content']); ?>
    </div>
    
    <?php
    if (!empty($row['tag_data'])) {
    echo "<span class='label-block'>TAGGED<br>";
    $tag_items = explode("||", $row['tag_data']);

    foreach ($tag_items as $item) {
        if (!$item || strpos($item, '::') === false) continue;

        list($tag, $type) = explode("::", $item, 2);

        $tag = htmlspecialchars($tag);
        $type = htmlspecialchars($type ?: 'none');

        echo "<span class='tag tag-$type' data-tag='$tag' data-id='{$row['id']}'>
        <a href='tag.php?tag=" . urlencode($tag) . "'>$tag</a>
        <span class='remove'>×</span>
        </span>";
    }
    echo "</span>";

}
    ?>
    </div>
    <div id="leaf-input-<?php echo $row['id']; ?>" 
        style="display:none; margin-top:5px;">
        <textarea id="leaf-text-<?php echo $row['id']; ?>" 
        rows="3" style="width:95%;"></textarea>
        <br>
        <button onclick="submitLeaf(<?php echo $row['id']; ?>)">Add</button>
    </div>
    <!-- TAGS + INPUT etc -->

 
<!-- remaining tags print -->


<span id="tags-<?php echo $row['id']; ?>"></span>

    <span class="small action">
        <button onclick="showLeafInput(<?php echo $row['id']; ?>)">
        + Add Leaf
        </button> 
        
        
    
        <a href="delete_timber.php?id=<?php echo $row['id']; ?>" 
        onclick="return confirm('Delete this timber?');"
        class="btn" style="color:red; text-decoration:none;">
        🗑️ Delete
        </a>&nbsp;
<input 
    type="text" 
    placeholder="add tags..." 
    onkeydown="handleTagKeydown(event, <?php echo $row['id']; ?>)"
    oninput="handleTagAutocomplete(event, <?php echo $row['id']; ?>)"
    style="margin-top:5px; width:200px;"
> 
 <div class="tag-suggestions" id="suggestions-<?php echo $row['id']; ?>"></div>         
        </span>
    </span>

   <!-- LEAVES WILL GO HERE -->
    <div id="leaf-container-<?php echo $row['id']; ?>" class="leaf-container">

<?php
$leaf_result = $conn->query("
    SELECT 
        timbers.*,
        logs.log_code,
        GROUP_CONCAT(
            CONCAT(tags.name, '::', IFNULL(tags.type, 'none'))
            SEPARATOR '||'
        ) AS tag_data

    FROM timbers

    LEFT JOIN logs ON timbers.log_id = logs.id
    LEFT JOIN timber_tags ON timbers.id = timber_tags.timber_id
    LEFT JOIN tags ON timber_tags.tag_id = tags.id

    WHERE timbers.parent_id = {$row['id']}

    GROUP BY timbers.id
");
?>

<?php while($leaf = $leaf_result->fetch_assoc()): ?>

<div 
    class="timber-leaf leaf"
    data-tagged="<?php echo !empty($leaf['tag_data']) ? 'true' : 'false'; ?>"
    
>
    
    <div class="small">
        YOU | <?php echo $leaf['log_code']; ?>-L<?php echo $leaf['id']; ?> 
   
    </div>

    <div style="background: white; padding: 10px; border: 1px dashed lightgray;">
        <?php echo htmlspecialchars($leaf['content']); ?>
    </div>
<?php

    if (!empty($leaf['tag_data'])) {

    $tag_items = explode("||", $leaf['tag_data']);
    echo "<span class='label-block'>TAGGED <br> ";
    foreach ($tag_items as $item) {
        if (!$item || strpos($item, '::') === false) continue;

        list($tag, $type) = explode("::", $item, 2);

        $tag = htmlspecialchars($tag);
        $type = htmlspecialchars($type ?: 'none');

        echo "<span class='tag tag-$type' data-tag='$tag' data-id='{$leaf['id']}'>
    <a href='tag.php?tag=" . urlencode($tag) . "'>$tag</a>
    <span class='remove'>×</span>
</span>";
    }
    echo "</span>";

}
 ?>
    <!-- TAG INPUT -->
    <div class="small action">
    <!-- TAG DISPLAY -->


    <span id="tags-<?php echo $leaf['id']; ?>"><span id="leaf-input-<?php echo $leaf['id']; ?>" style="display:none;">
        <textarea id="leaf-text-<?php echo $leaf['id']; ?>"></textarea>
        <button onclick="submitLeaf(<?php echo $leaf['id']; ?>)">Add</button>
    </span>

    
        
    </span></div>
</div>
<!-- LEAF BUTTON (THIS IS WHAT ENABLES RECURSION) -->
    <button onclick="showLeafInput(<?php echo $leaf['id']; ?>)">+ Leaf Edge</button> 

    <a href="delete_timber.php?id=<?php echo $leaf['id']; ?>" 
    onclick="return confirm('Delete this timber?');"
    class="btn" style="color:red; text-decoration:none;">
    🗑️ Delete
    </a>&nbsp;
    <input 
        type="text" 
        placeholder="add tags..." 
        onkeydown="handleTagKeydown(event, <?php echo $leaf['id']; ?>)"
        oninput="handleTagAutocomplete(event, <?php echo $leaf['id']; ?>)">

    <div class="tag-suggestions" id="suggestions-<?php echo $leaf['id']; ?>"></div>

    
<?php endwhile; ?>
</div>
    </div>

</div>
<?php endwhile; ?>
</div>
<a href="index.php">Back</a>


<script>
let activeIndex = -1;

// KEYDOWN = arrows + enter
function handleTagKeydown(e, timberId) {
    let box = document.getElementById("suggestions-" + timberId);
    let items = box.querySelectorAll("div");

    // DOWN
    if (e.key === "ArrowDown") {
        e.preventDefault();
        activeIndex++;
        if (activeIndex >= items.length) activeIndex = 0;
        updateActive(items);
        return;
    }

    // UP
    if (e.key === "ArrowUp") {
        e.preventDefault();
        activeIndex--;
        if (activeIndex < 0) activeIndex = items.length - 1;
        updateActive(items);
        return;
    }

    // ENTER
    if (e.key === "Enter") {
        e.preventDefault();

        // If selecting suggestion
        if (activeIndex >= 0 && items[activeIndex]) {
            items[activeIndex].click();
            activeIndex = -1;
            return;
        }

        // Otherwise: add tag
        let input = e.target;
        let value = input.value.trim();
        if (!value) return;

        let formData = new URLSearchParams();
        formData.append("timber_id", timberId);
        formData.append("tags", value);

        fetch("save_tags.php", {
            method: "POST",
            body: formData
        }).then(() => {
            let container = document.getElementById("tags-" + timberId);

            value.split(/\s+/).forEach(tag => {
                if (!tag) return;

                let tagEl = createTagElement(tag, timberId);
                container.appendChild(tagEl);
            });

            input.value = "";
            box.innerHTML = "";
            activeIndex = -1;
        });
    }
}

// INPUT = suggestions
function handleTagAutocomplete(e, timberId) {
    let value = e.target.value.trim();
    let box = document.getElementById("suggestions-" + timberId);

    activeIndex = -1;

    if (value.length < 2) {
        box.innerHTML = "";
        return;
    }

    fetch("search_tags.php?term=" + encodeURIComponent(value))
        .then(res => res.json())
        .then(data => {
            box.innerHTML = "";

            data.forEach(tag => {
                let div = document.createElement("div");
                div.textContent = tag;

                div.onclick = function () {
                    e.target.value = tag;
                    box.innerHTML = "";
                };

                box.appendChild(div);
            });
        });
}

// highlight selection
function updateActive(items) {
    items.forEach(el => el.style.background = "");
    if (items[activeIndex]) {
        items[activeIndex].style.background = "#e0e7ff";
    }
}

// create tag UI
function createTagElement(tag, timberId) {
    let span = document.createElement("span");
    span.className = "tag";
    span.setAttribute("data-tag", tag);
    span.setAttribute("data-id", timberId);

    span.innerHTML = `
        ${tag} <span class="remove" style="cursor:pointer;">×</span>
    `;

    span.querySelector(".remove").onclick = function () {
        removeTag(timberId, tag, span);
    };

    return span;
}

// remove tag
function removeTag(timberId, tag, element) {
    let formData = new URLSearchParams();
    formData.append("timber_id", timberId);
    formData.append("tag", tag);

    fetch("remove_tag.php", {
        method: "POST",
        body: formData
    }).then(() => {
        element.remove();
    });
}

document.addEventListener("click", function(e) {
    if (e.target.classList.contains("remove")) {
        let tagEl = e.target.closest(".tag");
        if (!tagEl) return;

        let tag = tagEl.dataset.tag;
        let id = tagEl.dataset.id;

        if (!tag || !id) {
            console.log("Missing tag or id", tag, id);
            return;
        }

        removeTag(id, tag, tagEl);
    }
});
</script>


<script>

function showManageInput(timberId) {
   
    let el = document.getElementById("manage-input-" + timberId);
     if (el.style.display === "none") {
        el.style.display = "block";

    } else {
        el.style.display = "none";
    }
}

function closeManageInput(timberId) {
    let el = document.getElementById("manage-input-" + timberId);
    el.style.display = el.style.display === "none" ? "block" : "none";
}


function showLeafInput(timberId) {
    let el = document.getElementById("leaf-input-" + timberId);
    el.style.display = el.style.display === "none" ? "block" : "none";
}



function submitLeaf(parentId) {
    let text = document.getElementById("leaf-text-" + parentId).value.trim();
    if (!text) return;

    let formData = new URLSearchParams();
    formData.append("parent_id", parentId);
    formData.append("content", text);

    fetch("add_leaf.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        addLeafToUI(parentId, data);
    });
}

function addLeafToUI(parentId, data) {
    let container = document.getElementById("leaf-container-" + parentId);

    if (!container) {
        console.error("No container found for parent:", parentId);
        return;
    }

    let div = document.createElement("div");
    div.style = "margin-left:20px; padding:6px; border-left:2px solid #ddd; margin-top:5px;";

    div.innerHTML = `
        <div style="font-size:11px; color:#aaa;">
            YOU | ${data.log_code}-L${data.id}
        </div>
        <div>${data.content}</div>

        <input 
    type="text"
    placeholder="add tags..."
    onkeydown="handleTagKeydown(event, <?php echo $row['id']; ?>)"
    oninput="handleTagAutocomplete(event, <?php echo $row['id']; ?>)"
>
        <div id="tags-${data.id}"></div>
    `;

    container.appendChild(div);
}
</script>
<div class="pagination">

    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>">← Previous</a>
    <?php endif; ?>

    <span>Page <?php echo $page; ?> of <?php echo $total_pages; ?></span>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next →</a>
    <?php endif; ?>

</div>
<?php include 'footer.php'; ?>
</body>
</html>