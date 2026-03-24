
<!--// WELCOME THE INITIATES. PLEASE INCLUDE IF APPLICABLE -->
<?php require_once $dirInclude . 'php/common.php'; ?>
<?php safe_include($initiates); ?>

<!-- THE STANDARD OPENING PRAYER FOR THE PROVINENCE: -->
    <!DOCTYPE html>
    <html><head>
    <title><?= $page_title ?></title>

    <!-- THE CALLING OF THE STYLESHEET PROCESSION -->
    <link rel="stylesheet" href="/styles/iox-core.css">
    <link rel="stylesheet" href="/styles/fonts.css">
    <link rel="stylesheet" href="/styles/<?= $storeMark; ?>.css">
        <?php echo call_dept_style($deptStyle); ?>

    </head>
    <body>
<!-- END OPENING PRAYERS -->
<!-- ENTER THE HEAD OF THE OIX which opens the room -->
<?php include $dirInclude . 'header.php'; ?>

<!-- BEGIN NOW THE 'BODY OF THE DIVINE PAGE' -->
<div class="iox_coreContainer">

    <!-- THE NAVIGATION OF THE VESSEL PROPER -->
    <?php include $dirInclude . 'nav.' . $storeMark . '.php'; ?>

    <!-- NOW WE MAKE CONTACT WITH CONTENT -->
    <main class="iox_coreContents">
        <?php echo render_page_insert($page_insert, $page_ext); ?>
        <?php safe_include($page_logic); ?>
    </main>

</div>
<!-- END NOW THE 'BODY OF THE DIVINE PAGE' -->
<!-- REST HERE THE FOOT OF THE OIX which carry the last copy and rights -->
<?php include $dirInclude . 'footer.php'; ?>

<!-- FINAL BLESSINGS OF THE FUNCTION -->
<?php safe_include($scriptures); ?>

<!-- THE STANDARD CLOSING PRAYER OF ALL WORKS-->
</body>
</html>
<!-- AMEN -->