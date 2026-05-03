```php
<?php ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>Vezo Studio</title>

<style>
body {
  font-family: Arial;
  background:#f3f4f6;
  text-align:center;
  margin:0;
  padding:20px;
}

.card {
  background:#fff;
  padding:20px;
  margin:20px auto;
  width:90%;
  max-width:500px;
  border-radius:20px;
  box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

h2 { margin-bottom:10px; }

.templates {
  display:grid;
  grid-template-columns: repeat(2, 1fr);
  gap:10px;
  margin:15px 0;
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
  height:90px;
  object-fit:cover;
}

.template input {
  display:none;
}

.template.active {
  border-color:#c5a059;
  transform:scale(1.05);
  box-shadow:0 5px 15px rgba(197,160,89,0.4);
}

input[type="file"] {
  margin-top:15px;
}

button {
  margin-top:15px;
  padding:12px 20px;
  background:#c5a059;
  color:#fff;
  border:none;
  border-radius:10px;
  cursor:pointer;
  font-weight:bold;
}
</style>

</head>
<body>

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

<input type="file" name="product_images[]" multiple accept="image/*" required>
<p>يمكنك رفع حتى 10 صور</p>

<button type="submit">🚀 معالجة الصور</button>

</form>

</div>

<script>
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
