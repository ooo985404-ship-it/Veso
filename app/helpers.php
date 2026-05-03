<?php

function save_uploaded_image(array $file): string
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('فشل رفع الصورة.');
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

    $mime = mime_content_type($file['tmp_name']);

    if (!isset($allowed[$mime])) {
        throw new Exception('صيغة الصورة غير مدعومة. استخدم JPG أو PNG أو WEBP.');
    }

    if ($file['size'] > 8 * 1024 * 1024) {
        throw new Exception('حجم الصورة كبير. الحد الأقصى 8MB.');
    }

    $name = 'upload_' . date('Ymd_His') . '_' . bin2hex(random_bytes(5)) . '.' . $allowed[$mime];
    $target = STORAGE_PATH . '/uploads/' . $name;

    if (!move_uploaded_file($file['tmp_name'], $target)) {
        throw new Exception('تعذر حفظ الصورة.');
    }

    return $target;
}
