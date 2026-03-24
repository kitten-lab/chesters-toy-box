
<!--// WELCOME THE INITIATES. PLEASE INCLUDE IF APPLICABLE -->
<?php require_once __DIR__ . '/../includes/php/common.php'; ?>
<?php safe_include($initiates); ?>

<!-- THE STANDARD OPENING PRAYER FOR THE PROVINENCE -->
<!DOCTYPE html>
<html>
    <head>
        <title><?= $page_title ?></title>
        <link rel="stylesheet" href="/styles/iox-core.css">
        <link rel="stylesheet" href="/styles/fonts.css">
        <link rel="stylesheet" href="/styles/<?= $storeMark; ?>.css">
        <?php if(!empty($deptStyle)) {
            echo '<link rel="stylesheet" href="/styles/' . $storeMark . '.' . $deptMark . '.css">';
        } 
        ?>
        
    </head>
<body>

<!-- ENTER THE HEAD OF THE OIX which opens the room -->
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <div class="iox_coreContainer">

<!-- THE NAVIGATION OF THE VESSEL PROPER -->
    <?php include __DIR__ . '/../includes/nav.' . $storeMark . '.php'; ?>

<!-- NOW WE MAKE CONTACT WITH CONTENT -->
<main class="iox_coreContents">
    <?php 
        if (!empty($page_insert)) {
            if ($page_ext == 'md') {
                echo render_md($page_insert); 
                } else {
                    echo $page_insert;
            } 
        }
        ?>

    <?php safe_include($content_insert); ?>

    </main>

<!-- REST HERE THE FOOT OF THE OIX which carry the last copy and rights -->
    </div>
    <?php include __DIR__ . '/../includes/footer.php'; ?>

<!-- FINAL BLESSINGS OF THE FUNCTION -->
    <?php safe_include($scriptures); ?>

<!-- THE STANDARD CLOSING PRAYER OF ALL WORKS-->
</body>
</html>