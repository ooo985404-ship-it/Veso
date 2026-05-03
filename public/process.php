```php
<?php
require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/RemoveBgService.php';
require_once __DIR__ . '/../app/ImageProcessor.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("طلب غير صالح");
}

$template = $_POST['template'] ?? 'sadu.png';
$templatePath = __DIR__ . '/assets/templates/' . $template;

if (!file_exists($templatePath)) {
    die("الخلفية غير موجودة");
}

$files = $_FILES['product_images'];

if (count($files['name']) > 10) {
    die("الحد الأقصى 10 صور");
}

$removeBg = new RemoveBgService(env('REMOVE_BG_API_KEY'));
$processor = new ImageProcessor();

$zip = new ZipArchive();
$zipName = 'result_' . time() . '.zip';
$zipPath = __DIR__ . '/../storage/' . $zipName;

if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
    die("فشل إنشاء ZIP");
}

for ($i = 0; $i < count($files['name']); $i++) {

    if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;

    $tmpFile = [
        'name' => $files['name'][$i],
        'tmp_name' => $files['tmp_name'][$i],
        'error' => $files['error'][$i],
        'size' => $files['size'][$i]
    ];

    try {
        $uploadPath = save_uploaded_image($tmpFile);
        $noBg = $removeBg->removeBackground($uploadPath);
        $final = $processor->mergeWithBackground($templatePath, $noBg);

        $zip->addFile($final, basename($final));

    } catch (Exception $e) {
        continue;
    }
}

$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="'.$zipName.'"');
header('Content-Length: ' . filesize($zipPath));

readfile($zipPath);
exit;
```
