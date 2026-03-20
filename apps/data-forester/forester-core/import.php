<!DOCTYPE html>
<html>
<head>
    <title>Forestry Engine</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../header.php'; ?>


<h2>Enter a Prepared Log</h2>

<form method="POST" action="save_log.php">
<div class="form-box">
    <div class="field"><input type="number" name="import_order"  placeholder="ORDER IMPORTED" ><br>
    </div>

    <div class="field"><input type="number" name="log_number" placeholder="LOG ORIGIN NUMBER" >
</div>
    
    <div class="field">
    <textarea name="log_content" rows="12"></textarea><br><br>
</div>
    <button type="submit">Break into Timbers</button>
</div>
</form>
<?php include __DIR__ . '/../footer.php'; ?>

</body>
</html>