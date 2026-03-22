
<!--?PHP INCLUDES ?-->

<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//
?>

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
if (!empty($content_insert) && file_exists($content_insert)) {
    require_once $content_insert; 
} ?>


<?php 
if (!empty($page_insert)) {
    $Parsedown = new Parsedown();
    echo $Parsedown->text($page_insert); } ?>
    <!-- main page content -->
    </main>
    </div>
    <?php include __DIR__ . '/../includes/jxcc-footer.php'; ?>
    </body>




</html>