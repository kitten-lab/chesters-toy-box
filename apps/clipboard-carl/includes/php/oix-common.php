

<?php 
// Smoosh the address into the $storeMark
$storeMark = $houseMark . $proprietorMark;

// If there is a page insert, insert it.
$page_insert = file_exists($page_path) ? file_get_contents($page_path) : ''; 

// CARL LOVES THE PARSEDOWN PARSER 
require_once 'Parsedown.php';
$Parsedown = new Parsedown();

function render_md($text) {
    static $Parsedown;
    if (!$Parsedown) {
        $Parsedown = new Parsedown();
    }
    return $Parsedown->text($text);
}

require_once 'navi-icos.php';
?>

