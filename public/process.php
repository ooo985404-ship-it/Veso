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

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $zipName . '"');
    header('Content-Length: ' . filesize($zipPath));
    header('Pragma: no-cache');
    header('Expires: 0');

    readfile($zipPath);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo '<h2>حدث خطأ</h2>';
    echo '<p>' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<a href="index.php">رجوع</a>';
}
