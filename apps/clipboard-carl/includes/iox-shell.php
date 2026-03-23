
<!-- WELCOME THE INITIATES. PLEASE INCLUDE IF APPLICABLE -->
<?php require_once __DIR__ . '/../includes/php/oix-common.php'; ?>
<?php 
if (!empty($initiates) && file_exists($initiates)) {
    require_once $initiates; 
} ?>

<!-- THE STANDARD OPENING PRAYER FOR THE PROVINENCE -->
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $page_title ?></title>
        <link rel="stylesheet" href="/styles/<?php echo $storeMark ?>.css">
        <link rel="stylesheet" href="/styles/iox-core.css">
        <link rel="stylesheet" href="/styles/fonts.css">
    </head>
<body>

<!-- ENTER THE HEAD OF THE OIX which opens the room -->
    <?php include __DIR__ . '/../includes/oix-mast.php'; ?>
    <div class="iox_coreContainer">

<!-- THE NAVIGATION OF THE VESSEL PROPER -->
    <?php include __DIR__ . '/../includes/' . $storeMark . '-navi.php'; ?>

<!-- NOW WE MAKE CONTACT WITH CONTENT -->



<main class="iox_coreContents">
    <?php 
    if (!empty($page_insert)) {
        echo render_md($page_insert); } 
        ?>

    <?php 
    if (!empty($content_insert) && file_exists($content_insert)) {
        require_once $content_insert; } 
        ?>

    </main>

<!-- REST HERE THE FOOT OF THE OIX which carry the last copy and rights -->
    </div>
    <?php include __DIR__ . '/../includes/' . $storeMark . '-footer.php'; ?>

<!-- FINAL BLESSINGS OF THE FUNCTION -->
    <?php 
    if (!empty($scriptures) && file_exists($scriptures)) {
        require_once $scriptures; 
    } ?>

<!-- THE STANDARD CLOSING PRAYER OF ALL WORKS-->
</body>
</html>