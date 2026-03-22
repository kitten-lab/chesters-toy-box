<?php


// Include the Composer autoloader
require_once '/Parsedown.php';

// Instantiate the Parsedown parser
$Parsedown = new Parsedown();

// Read the content of your Markdown file
$markdownContent = '$page_insert'

// Convert the Markdown to HTML
$htmlContent = $Parsedown->text($markdownContent);

// You can now display the rendered HTML within your PHP file
?>