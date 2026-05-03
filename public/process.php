<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/RemoveBgService.php';
require_once __DIR__ . '/../app/ImageProcessor.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('طلب غير صالح');
    }

    $template = basename($_POST['template'] ?? 'sadu.png');
    $templatePath = __DIR__ . '/assets/templates/' . $template;

    if (!file_exists($templatePath)) {
        throw new Exception('الخلفية غير موجودة');
    }

    if (empty($_FILES['product_images']['name'][0])) {
        throw new Exception('لم يتم رفع صور');
    }

    $files = $_FILES['product_images'];
    $count = count($files['name']);

    if ($count > 10) {
        throw new Exception('الحد الأقصى 10 صور فقط');
    }

    $removeBg = new RemoveBgService(env('REMOVE_BG_API_KEY'));
    $processor = new ImageProcessor();

    $zipName = 'vezo_results_' . date('Ymd_His') . '.zip';
    $zipPath = STORAGE_PATH . '/processed/' . $zipName;

    $zip = new ZipArchive();

    if ($zip->open($zipPath, ZipArchive::CREATE) !== true) {
        throw new Exception('فشل إنشاء ملف ZIP');
    }

    $processed = 0;

    for ($i = 0; $i < $count; $i++) {
        if ($files['error'][$i] !== UPLOAD_ERR_OK) {
            continue;
        }

        $singleFile = [
            'name' => $files['name'][$i],
            'tmp_name' => $files['tmp_name'][$i],
            'error' => $files['error'][$i],
            'size' => $files['size'][$i],
        ];

        try {
            $uploadPath = save_uploaded_image($singleFile);
            $noBgPath = $removeBg->removeBackground($uploadPath);
            $finalPath = $processor->mergeWithBackground($templatePath, $noBgPath);

            $zip->addFile($finalPath, 'vezo_image_' . ($i + 1) . '.png');
            $processed++;
        } catch (Exception $e) {
            continue;
        }
    }

    $zip->close();

    if ($processed === 0) {
        throw new Exception('لم تتم معالجة أي صورة. تأكد من المفتاح أو رصيد remove.bg.');
    }

    $downloadUrl = 'download.php?file=' . urlencode($zipName);

} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>نتيجة المعالجة</title>

<style>
* { box-sizing: border-box; }

body {
  font-family: Arial, sans-serif;
  background:#f3f4f6;
  margin:0;
  padding:15px;
  min-height:100vh;
  display:flex;
  align-items:center;
  justify-content:center;
}

.card {
  background:#fff;
  padding:22px;
  width:100%;
  max-width:420px;
  border-radius:20px;
  box-shadow:0 10px 30px rgba(0,0,0,0.08);
  text-align:center;
}

h2 {
  margin:0 0 12px;
  color:#1f2937;
}

p {
  color:#555;
  line-height:1.7;
}

.btn {
  display:block;
  width:100%;
  padding:14px;
  margin-top:12px;
  border-radius:12px;
  text-decoration:none;
  font-weight:bold;
  color:white;
  background:#c5a059;
}

.btn.secondary {
  background:#1f2937;
}

.error {
  color:#dc2626;
  font-weight:bold;
}
</style>
</head>

<body>
<div class="card">

<?php if (!empty($error)): ?>

  <h2>حدث خطأ</h2>
  <p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
  <a class="btn secondary" href="index.php">رجوع</a>

<?php else: ?>

  <h2>✅ تمت المعالجة</h2>
  <p>تمت معالجة <?= (int)$processed ?> صورة بنجاح.</p>

  <a class="btn" href="<?= htmlspecialchars($downloadUrl, ENT_QUOTES, 'UTF-8') ?>">
    📥 تنزيل ملف ZIP
  </a>

  <a class="btn secondary" href="index.php">
    معالجة صور أخرى
  </a>

<?php endif; ?>

</div>
</body>
</html>
