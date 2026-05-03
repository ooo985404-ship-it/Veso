<?php
require_once __DIR__ . '/../app/config.php';

$file = basename($_GET['file'] ?? '');
$path = STORAGE_PATH . '/processed/' . $file;

if (!$file || !file_exists($path)) {
    http_response_code(404);
    exit('الملف غير موجود.');
}

$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

if ($ext === 'zip') {
    header('Content-Type: application/zip');
} else {
    header('Content-Type: image/png');
}

header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Length: ' . filesize($path));
header('Pragma: no-cache');
header('Expires: 0');

readfile($path);
exit;
