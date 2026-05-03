<?php
$file = basename($_GET['file'] ?? '');
$path = __DIR__ . '/../storage/processed/' . $file;

if (!$file || !file_exists($path)) {
    http_response_code(404);
    exit('الملف غير موجود.');
}

header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Length: ' . filesize($path));

readfile($path);
exit;
