<?php 
// OIX NOTE: ADDRESS OF STORE (produces $storeMark for files)
$houseMark = "OIX"; // Jack's Crossing (Atavens)
$proprietorMark = 'CC'; // Carl Core (Executive Function)
$deptMark = "TEMPLATE";
$storeTitle = "the Carl Core Template";

// OIX NOTE: pageCaller definitions >|==============================
// "$initiates" = init includes initiates to prepare the page (FOR ANY LOGIC)
// "$scriptures" = js scripts for bottom loading
// "$page_title" = Title of the page. Keep $storeTitle to keep identity in tact
// "$page_slug" = filename of a content file (NO LOGIC)
// "$page_ext" = the file type of the slug. 
// "$page_logic" = load functional logic (!!!loaded after $page_slug currently!!!)
// "$deptStyle" = use in case of changes for Dept specific needs
// ===============================================================|>

$initiates = "";
$scriptures = "";
$page_logic = "";
$page_title = $storeTitle . ' Home';
$page_slug = 'index';
$page_ext = 'md';
$deptStyle = false;

include 'includes/shell.php';
?>

