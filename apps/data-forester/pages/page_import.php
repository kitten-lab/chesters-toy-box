<form method="POST" action="../actors/save_log.php">
<div class="form-box">
<h2>Enter a Prepared Log</h2>

<input name="title">
<select name="source" id="source-select">
  <option value="Wire Wolf Woods">Wire Wolf Woods</option>
  <option value="Evernote Field">Evernote Field</option>
  <option value="Bound Journal">Bound Journal</option>
  <option value="Other">Other</option>
</select>

<input type="text" name="source_other" placeholder="Specify source (if Other)">
<input name="created_at" type="datetime-local">
<input name="imported_at" type="datetime-local">
<textarea name="log_content"></textarea>
    <button type="submit">Break into Timbers</button>
</div>
</form>