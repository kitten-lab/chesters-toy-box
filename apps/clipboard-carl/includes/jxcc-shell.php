
<!--?PHP INCLUDES ?-->

<?php 
if (!empty($php_insert) && file_exists($php_insert)) {
    require_once $php_insert; 
} ?>
<!-- OPENING DOCUMENT -->
<!DOCTYPE html>
    <html>
    <head>
        <title>Clipboard Carl __title__</title>
        <link rel="stylesheet" href="/styles/jxcc-style.css">
    </head>
    <body>
    <?php include __DIR__ . '/../includes/jxcc-header.php'; ?>
    <div class="f_coreContainer">

        <?php include __DIR__ . '/../includes/jxcc-navi.php'; ?>
        <main class="f_coreContents">
    
<?php 
if (!empty($page_insert) && file_exists($page_insert)) {
    require_once $page_insert; 
} ?>
    <!-- main page content -->
    </main>
    </div>
    <?php include __DIR__ . '/../includes/jxcc-footer.php'; ?>
    </body>
</html>