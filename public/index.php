```php
<?php ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vezo Studio</title>

<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background:#f3f4f6;
  margin:0;
  padding:12px;
}

.container {
  max-width:480px;
  margin:auto;
}

.card {
  background:#fff;
  padding:18px;
  border-radius:18px;
  box-shadow:0 8px 25px rgba(0,0,0,0.08);
}

h2 {
  margin:0 0 10px;
  font-size:20px;
}

p {
  margin:0 0 10px;
  color:#555;
  font-size:14px;
}

/* الخلفيات */
.templates {
  display:grid;
  grid-template-columns: repeat(2, 1fr);
  gap:10px;
  margin:12px 0;
}

.template {
  border:2px solid #ddd;
  border-radius:12px;
  overflow:hidden;
  cursor:pointer;
  transition:0.3s;
}

.template img {
  width:100%;
  height:80px;
  object-fit:cover;
  display:block;
}

.template input {
  display:none;
}

.template.active {
  border-color:#c5a059;
  transform:scale(1.03);
  box-shadow:0 4px 12px rgba(197,160,89,0.3);
}

/* رفع الصور */
.file-box {
  margin-top:10px;
}

input[type="file"] {
  width:100%;
  padding:10px;
  border:2px dashed #ddd;
  border-radius:12px;
  background:#fafafa;
}

button {
  width:100%;
  margin-top:12px;
  padding:14px;
  background:#c5a059;
  color:white;
  border:none;
  border-radius:12px;
  font-size:15px;
  font-weight:bold;
  cursor:pointer;
}
</style>
</head>

<body>

<div class="container">
  <div class="card">

    <h2>✨ Vezo Studio</h2>
    <p>اختر الخلفية وارفع حتى 10 صور</p>

    <form action="process.php" method="POST" enctype="multipart/form-data">

      <div class="templates">

        <label class="template active">
          <input type="radio" name="template" value="sadu.png" checked>
          <img src="assets/templates/sadu.png">
        </label>

        <label class="template">
          <input type="radio" name="template" value="national.png">
          <img src="assets/templates/national.png">
        </label>

        <label class="template">
          <input type="radio" name="template" value="founding.png">
          <img src="assets/templates/founding.png">
        </label>

        <label class="template">
          <input type="radio" name="template" value="grey.png">
          <img src="assets/templates/grey.png">
        </label>

        <label class="template">
          <input type="radio" name="template" value="grad.png">
          <img src="assets/templates/grad.png">
        </label>

      </div>

      <div class="file-box">
        <input type="file" name="product_images[]" multiple accept="image/*" required>
        <p>يمكنك اختيار حتى 10 صور</p>
      </div>

      <button type="submit">🚀 معالجة الصور</button>

    </form>

  </div>
</div>

<script>
// اختيار الخلفية بالضغط
const templates = document.querySelectorAll('.template');

templates.forEach(t => {
  t.addEventListener('click', () => {
    templates.forEach(el => el.classList.remove('active'));
    t.classList.add('active');
    t.querySelector('input').checked = true;
  });
});
</script>

</body>
</html>
```
