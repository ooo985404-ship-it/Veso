<?php
require_once __DIR__ . '/../app/config.php';

$templates = [
    'sadu.png' => 'سدو',
    'national.png' => 'وطني',
    'founding.png' => 'التأسيس',
    'grey.png' => 'رمادي',
];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Vezo Studio MVP</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="card">
    <h1>✨ Vezo Studio</h1>
    <p>ارفع صورة المنتج واختر خلفية الاستوديو</p>

    <form action="process.php" method="POST" enctype="multipart/form-data">
        <h3>1. اختر الخلفية</h3>

        <div class="templates">
            <?php foreach ($templates as $file => $name): ?>
                <label class="template">
                    <input type="radio" name="template" value="<?= htmlspecialchars($file) ?>" <?= $file === 'sadu.png' ? 'checked' : '' ?>>
                    <img src="assets/templates/<?= htmlspecialchars($file) ?>" alt="<?= htmlspecialchars($name) ?>">
                    <span><?= htmlspecialchars($name) ?></span>
                </label>
            <?php endforeach; ?>
        </div>

        <h3>2. ارفع صورة المنتج</h3>
        <input type="file" name="product_image" accept="image/*" required>

        <button type="submit">🚀 معالجة الصورة</button>
    </form>
</div>

</body>
</html>
