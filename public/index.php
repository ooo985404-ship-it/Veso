<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vezo Studio</title>

<style>
* { box-sizing: border-box; }

body {
  font-family: Arial, sans-serif;
  background: #f3f4f6;
  margin: 0;
  padding: 14px;
  color: #1f2937;
}

.wrapper {
  max-width: 900px;
  margin: 0 auto;
}

.header {
  background: #ffffff;
  border-radius: 18px;
  padding: 18px;
  margin-bottom: 14px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.06);
  text-align: center;
}

.header h1 {
  margin: 0 0 8px;
  font-size: 22px;
}

.header p {
  margin: 0;
  color: #6b7280;
  font-size: 14px;
}

.section {
  background: #ffffff;
  border-radius: 18px;
  padding: 14px;
  margin-bottom: 14px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.06);
}

.section h2 {
  font-size: 17px;
  margin: 0 0 12px;
}

.grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 12px;
}

@media (min-width: 650px) {
  .grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (min-width: 950px) {
  .grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

.card {
  background: #fafafa;
  border: 3px solid transparent;
  border-radius: 16px;
  overflow: hidden;
  cursor: pointer;
  transition: 0.2s;
}

.card input {
  display: none;
}

.card img {
  width: 100%;
  height: 105px;
  object-fit: cover;
  display: block;
}

.card span {
  display: block;
  padding: 8px;
  font-size: 13px;
  font-weight: bold;
  text-align: center;
}

.card.selected {
  border-color: #16a34a;
  box-shadow: 0 8px 18px rgba(22,163,74,0.22);
  transform: scale(1.02);
}

.upload-box {
  background: #ffffff;
  border-radius: 18px;
  padding: 16px;
  margin-bottom: 14px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.06);
}

.upload-box h2 {
  font-size: 17px;
  margin: 0 0 10px;
}

input[type="file"] {
  width: 100%;
  padding: 14px;
  border: 2px dashed #cbd5e1;
  border-radius: 14px;
  background: #f8fafc;
}

.note {
  font-size: 13px;
  color: #6b7280;
  margin-top: 8px;
}

button {
  width: 100%;
  padding: 15px;
  border: none;
  border-radius: 14px;
  background: #16a34a;
  color: white;
  font-size: 17px;
  font-weight: bold;
  cursor: pointer;
}

button:disabled {
  background: #94a3b8;
}

.footer-space {
  height: 20px;
}
</style>
</head>

<body>

<div class="wrapper">

  <div class="header">
    <h1>✨ Vezo Studio</h1>
    <p>اختر الخلفية، ارفع حتى 10 صور، ثم حمّل النتائج كملف ZIP</p>
  </div>

  <form action="process.php" method="POST" enctype="multipart/form-data" id="mainForm">

    <div class="section">
      <h2>🇸🇦 المناسبات</h2>
      <div class="grid">

        <label class="card selected">
          <input type="radio" name="bg" value="assets/templates/events/events_national_1.png" checked>
          <img src="assets/templates/events/events_national_1.png" alt="اليوم الوطني">
          <span>اليوم الوطني</span>
        </label>

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/events/events_eid_1.png">
          <img src="assets/templates/events/events_eid_1.png" alt="عيد الأضحى">
          <span>عيد الأضحى</span>
        </label>

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/events/events_foundation_1.png">
          <img src="assets/templates/events/events_foundation_1.png" alt="يوم التأسيس">
          <span>يوم التأسيس</span>
        </label>

      </div>
    </div>

    <div class="section">
      <h2>🎨 خلفيات سادة</h2>
      <div class="grid">

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/basic/basic_white_1.png">
          <img src="assets/templates/basic/basic_white_1.png" alt="أبيض">
          <span>أبيض</span>
        </label>

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/basic/basic_beige_1.png">
          <img src="assets/templates/basic/basic_beige_1.png" alt="بيج">
          <span>بيج</span>
        </label>

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/basic/basic_dark_1.png">
          <img src="assets/templates/basic/basic_dark_1.png" alt="داكن">
          <span>داكن</span>
        </label>

      </div>
    </div>

    <div class="section">
      <h2>🏺 تراث سعودي</h2>
      <div class="grid">

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/heritage/heritage_sadu_1.png">
          <img src="assets/templates/heritage/heritage_sadu_1.png" alt="سدو">
          <span>سدو</span>
        </label>

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/heritage/heritage_najdi_1.png">
          <img src="assets/templates/heritage/heritage_najdi_1.png" alt="نجدي">
          <span>نجدي</span>
        </label>

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/heritage/heritage_palm_1.png">
          <img src="assets/templates/heritage/heritage_palm_1.png" alt="نخلة">
          <span>نخلة</span>
        </label>

      </div>
    </div>

    <div class="section">
      <h2>💰 التخفيضات</h2>
      <div class="grid">

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/offers/offers_whitefriday_1.png">
          <img src="assets/templates/offers/offers_whitefriday_1.png" alt="الجمعة البيضاء">
          <span>الجمعة البيضاء</span>
        </label>

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/offers/offers_sale_1.png">
          <img src="assets/templates/offers/offers_sale_1.png" alt="تخفيضات">
          <span>تخفيضات</span>
        </label>

        <label class="card">
          <input type="radio" name="bg" value="assets/templates/offers/offers_discount_1.png">
          <img src="assets/templates/offers/offers_discount_1.png" alt="خصومات">
          <span>خصومات</span>
        </label>

      </div>
    </div>

    <div class="upload-box">
      <h2>📤 رفع الصور</h2>
      <input type="file" name="product_images[]" multiple accept="image/*" required>
      <div class="note">يمكنك رفع حتى 10 صور. بعد المعالجة سيظهر زر تحميل ملف ZIP.</div>
    </div>

    <button type="submit" id="submitBtn">🚀 معالجة الصور</button>

  </form>

  <div class="footer-space"></div>

</div>

<script>
const cards = document.querySelectorAll('.card');

cards.forEach(card => {
  card.addEventListener('click', () => {
    cards.forEach(c => c.classList.remove('selected'));
    card.classList.add('selected');
    card.querySelector('input').checked = true;
  });
});

document.getElementById('mainForm').addEventListener('submit', function () {
  const btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.innerText = '⏳ جاري المعالجة... انتظر قليلاً';
});
</script>

</body>
</html>
