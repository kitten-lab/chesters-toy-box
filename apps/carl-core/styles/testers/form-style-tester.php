<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Form Test Lab</title>
  <link rel="stylesheet" href="/styles/iox-core.css">
  <link rel="stylesheet" href="/styles/JXCC.css">
</head>
<body>

  <div class="iox_coreContents">
    <h1>Form Test Lab</h1>

    <form>

      <!-- TEXT INPUT -->
      <label>Text Input</label>
      <input type="text" placeholder="Type something...">

      <!-- NUMBER -->
      <label>Number Input</label>
      <input type="number" placeholder="123">

      <!-- EMAIL -->
      <label>Email</label>
      <input type="email" placeholder="email@example.com">

      <!-- PASSWORD -->
      <label>Password</label>
      <input type="password" placeholder="••••••••">

      <!-- TEXTAREA -->
      <label>Textarea</label>
      <textarea placeholder="Write something..."></textarea>

      <!-- SELECT -->
      <label>Select Dropdown</label>
      <select>
        <option>Option One</option>
        <option>Option Two</option>
        <option>Option Three</option>
      </select>

      <!-- MULTI SELECT -->
      <label>Multi Select</label>
      <select multiple>
        <option>Alpha</option>
        <option>Beta</option>
        <option>Gamma</option>
      </select>

      <!-- CHECKBOXES -->
      <label>Checkboxes</label>
      <div>
        <label><input type="checkbox"> Option A</label>
        <label><input type="checkbox"> Option B</label>
        <label><input type="checkbox"> Option C</label>
      </div>

      <!-- RADIO -->
      <label>Radio Buttons</label>
      <div>
        <label><input type="radio" name="radio"> Choice 1</label>
        <label><input type="radio" name="radio"> Choice 2</label>
        <label><input type="radio" name="radio"> Choice 3</label>
      </div>

      <!-- RANGE -->
      <label>Range</label>
      <input type="range">

      <!-- FILE -->
      <label>File Upload</label>
      <input type="file">

      <!-- DATE -->
      <label>Date</label>
      <input type="date">

      <!-- COLOR -->
      <label>Color Picker</label>
      <input type="color">

      <!-- BUTTONS -->
      <div style="margin-top: 20px;">
        <button type="button">Button</button>
        <button type="submit">Submit</button>
        <a href="#" class="btn">Link Button (.btn)</a>
      </div>

    </form>

  </div>

</body>
</html>