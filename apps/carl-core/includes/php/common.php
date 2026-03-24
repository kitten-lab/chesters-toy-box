

<?php 
// Smoosh the address into the $storeMark
$storeMark = $houseMark . $proprietorMark;

// If there is a page insert, insert it.
$address = __DIR__ . '/../../pages/' . $storeMark . '/' . $deptMark . '/';
$page_path = $address . $page_slug . '.' . $page_ext;
$page_insert = file_exists($page_path) ? file_get_contents($page_path) : ''; 
$dirInclude = __DIR__ . '/../../includes/';

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

function safe_include($path) {
if (!empty($path) && file_exists($path)) {
    require_once $initiates; 
}
}

function render_page_insert($page_insert, $page_ext) {
    if (!empty($page_insert)) {
        if ($page_ext === 'md') {
            return render_md($page_insert);
        } else {
            return $page_insert;
        }
    }
    return '';
}

function call_dept_style($deptStyle, $storeMark, $deptMark) {
if(!empty($deptStyle)) {
            return '<link rel="stylesheet" 
                href="/styles/' . $storeMark . '.' . $deptMark . '.css">';
            } }
?>
