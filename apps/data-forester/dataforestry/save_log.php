<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '/dataforestry/db.php';

$log = $_POST['log_content'];

// Remove markdown-style formatting
$log = preg_replace('/[*_#>`]/', '', $log);
$import_order = $_POST['import_order'];
$log_number = $_POST['log_number'];

$log_code = "GW-" . $import_order . "-" . $log_number;

// Save log


$stmt = $conn->prepare("INSERT INTO logs (content, import_order, log_number, log_code) VALUES (?, ?, ?, ?)");
$stmt->bind_param("siis", $log, $import_order, $log_number, $log_code);
$stmt->execute();

$log_id = $stmt->insert_id;

// Split into sentences (basic)
$log = preg_replace('/~+/', '', $log); // remove ~~

// Force clean speaker labels onto their own lines
$log = preg_replace('/\s*(You said:)\s*/i', "\nYou said:\n", $log);
$log = preg_replace('/\s*(ChatGPT said:)\s*/i', "\nChatGPT said:\n", $log);
$blocks = preg_split('/\n(?=You said:|ChatGPT said:)/i', $log);

$current_speaker = "unknown";
$order = 0;
$block_id = 0;

foreach ($blocks as $block) {
    $order = 0;
    $block = trim($block);
    if ($block == "") continue;

    $block_id++;
    $speaker = "unknown";
    
    if (stripos($block, "You said:") === 0) {
        $speaker = "user";
        $block = trim(substr($block, strlen("You said:")));
    }

    if (stripos($block, "ChatGPT said:") === 0) {
        $speaker = "assistant";
        $block = trim(substr($block, strlen("ChatGPT said:")));
    }

    // Split into sentences
    $sentences = preg_split('/(?<!\b\d)(?<=[.?!])\s+/', $block);

    foreach ($sentences as $sentence) {
        $sentence = trim($sentence);
        if ($sentence == "") continue;

        $stmt = $conn->prepare("INSERT INTO timbers (log_id, content, order_index, speaker, block_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isisi", $log_id, $sentence, $order, $speaker, $block_id);
        $stmt->execute();

        $order++;
    }
}
echo "<h3>Processed Log: $log_code</h3>";
echo "<a href='/index.php'>Back</a>";

?>

