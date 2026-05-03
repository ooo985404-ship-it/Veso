<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/RemoveBgService.php';
require_once __DIR__ . '/../app/ImageProcessor.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('طريقة الطلب غير صحيحة.');
    }

    if (empty($_FILES['product_image']['tmp_name'])) {
        throw new Exception('لم يتم رفع صورة.');
    }

    $template = basename($_POST['template'] ?? 'sadu.png');
    $templatePath = __DIR__ . '/assets/templates/' . $template;

    if (!file_exists($templatePath)) {
        throw new Exception('الخلفية غير موجودة.');
    }

    $uploadPath = save_uploaded_image($_FILES['product_image']);

    $removeBg = new RemoveBgService(env('REMOVE_BG_API_KEY'));
    $noBgPath = $removeBg->removeBackground($uploadPath);

    $processor = new ImageProcessor();
    $finalPath = $processor->mergeWithBackground($templatePath, $noBgPath);

    $downloadUrl = 'download.php?file=' . urlencode(basename($finalPath));

} catch (Exception $e) {
    http_response_code(500);
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>نتيجة المعالجة</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="card">
    <?php if (!empty($error)): ?>
        <h2>حدث خطأ</h2>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <a class="btn" href="index.php">رجوع</a>
    <?php else: ?>
        <h2>✅ تمت المعالجة بنجاح</h2>
        <img class="preview" src="../storage/processed/<?= htmlspecialchars(basename($finalPath)) ?>" alt="Final Image">
        <a class="btn" href="<?= htmlspecialchars($downloadUrl) ?>">تحميل الصورة</a>
        <a class="btn secondary" href="index.php">معالجة صورة أخرى</a>
    <?php endif; ?>
</div>

</body>
</html>
