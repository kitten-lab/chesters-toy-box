<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$log = $_POST['log_content'];

// Save log


$title = $_POST['title'] ?? null;
$created_at = $_POST['created_at'] ?? null;
$imported_at = !empty($_POST['imported_at']) ? $_POST['imported_at'] : null;

$stmt = $conn->prepare("
    INSERT INTO logs (title, content, source, created_at, imported_at)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param("sssss", $title, $log, $source, $created_at, $imported_at);
$stmt->execute();

$source = $_POST['source'] ?? null;

if ($source === "Other" && !empty($_POST['source_other'])) {
    $source = $_POST['source_other'];
}
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
    $lines = preg_split('/\n+/', $block);

$in_code_block = false;
$code_buffer = "";

foreach ($lines as $line) {
    $line = trim($line);
    if ($line === "") continue;

    // Detect code block start/end
    if (strpos($line, '```') === 0) {
        if (!$in_code_block) {
            $in_code_block = true;
            $code_buffer = $line . "\n";
        } else {
            $code_buffer .= $line;
            
            // SAVE FULL CODE BLOCK
            $type = "code";
            $content = trim($code_buffer);

            $stmt = $conn->prepare("INSERT INTO timbers (log_id, content, order_index, speaker, block_id, type) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("isisss", $log_id, $content, $order, $speaker, $block_id, $type);
            $stmt->execute();

            $order++;

            $in_code_block = false;
            $code_buffer = "";
        }
        continue;
    }

    // If inside code block → accumulate only
    if ($in_code_block) {
        $code_buffer .= $line . "\n";
        continue;
    }

    // Detect list item (simple version)
    if (preg_match('/^(\d+\.|-|\*)\s+/', $line)) {
        $type = "text";
        $content = $line;

        $stmt = $conn->prepare("INSERT INTO timbers (log_id, content, order_index, speaker, block_id, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isisss", $log_id, $content, $order, $speaker, $block_id, $type);
        $stmt->execute();

        $order++;
        continue;
    }

    // Otherwise: normal paragraph → split into sentences (lightly)
    $parts = preg_split('/(?<=[.?!])\s+/', $line);

    foreach ($parts as $part) {
        $part = trim($part);
        if ($part === "") continue;

        $type = "text";
        $content = $part;

        $stmt = $conn->prepare("INSERT INTO timbers (log_id, content, order_index, speaker, block_id, type) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isisss", $log_id, $content, $order, $speaker, $block_id, $type);
        $stmt->execute();

        $order++;
    }
};

   
}
echo "<h3>Processed Log: $title</h3>";
echo "<a href='/index.php'>Back</a>";

?>

