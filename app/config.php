<?php

function env(string $key, ?string $default = null): ?string
{
    // أولاً: اقرأ من Environment Variables في Render
    $value = getenv($key);

    if ($value !== false && $value !== '') {
        return $value;
    }

    // ثانياً: اقرأ من ملف .env لو موجود
    static $env = null;

    if ($env === null) {
        $env = [];
        $path = __DIR__ . '/../.env';

        if (file_exists($path)) {
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                $line = trim($line);

                if ($line === '' || str_starts_with($line, '#')) {
                    continue;
                }

                [$name, $val] = array_pad(explode('=', $line, 2), 2, '');
                $env[trim($name)] = trim($val);
            }
        }
    }

    return $env[$key] ?? $default;
}

define('ROOT_PATH', dirname(__DIR__));
define('STORAGE_PATH', ROOT_PATH . '/storage');

foreach (['uploads', 'processed', 'temp'] as $dir) {
    $path = STORAGE_PATH . '/' . $dir;

    if (!is_dir($path)) {
        mkdir($path, 0775, true);
    }
}
