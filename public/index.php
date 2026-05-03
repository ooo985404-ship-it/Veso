<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>اختيار الخلفية</title>

<style>
body {
    font-family: Arial;
    background: #f5f5f5;
    padding: 20px;
}

h2 {
    margin-top: 40px;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 15px;
}

.card {
    background: #fff;
    border-radius: 10px;
    padding: 5px;
    cursor: pointer;
    border: 2px solid transparent;
}

.card img {
    width: 100%;
    border-radius: 8px;
}

.card input {
    display: none;
}

.card.selected {
    border: 2px solid green;
}
</style>
</head>

<body>

<h1>اختر الخلفية</h1>

<form action="process.php" method="POST">

<!-- المناسبات -->
<h2>🇸🇦 المناسبات</h2>
<div class="grid">

<label class="card">
<input type="radio" name="bg" value="assets/templates/events/events_national_1.png">
<img src="assets/templates/events/events_national_1.png">
</label>

<label class="card">
<input type="radio" name="bg" value="assets/templates/events/events_eid_1.png">
<img src="assets/templates/events/events_eid_1.png">
</label>

<label class="card">
<input type="radio" name="bg" value="assets
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
