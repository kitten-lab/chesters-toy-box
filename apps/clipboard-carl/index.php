

<?php 
// OIX NOTE: ADDRESS OF STORE (produces $storeMark for files)
$houseMark = "JX"; // Jack's Crossing (Atavens)
$proprietorMark = 'CC'; // Carl Core (Executive Function)
$deptMark = "CLIPBOARD";
$storeTitle = "the Clipboard";

// OIX NOTE: pageCaller definitions >|==============================
// "$initiates" = init includes initiates to prepare the page
// "$page_insert" = markdown text (loaded in body first)
// "$content_insert" = load php logic (loaded after $page_insert)
// "$scriptures" = js scripts for bottom loading
// "$deptStyle" = use in case of changes for Dept specific needs
// ===============================================================|>

$initiates = "";
$page_insert = "";
$scriptures = "";
$content_insert = "";
$page_title = $storeFrontTitle . 'Home';
$page_slug = 'index.md';
$deptStyle = false;
include 'includes/iox-shell.php';
?>