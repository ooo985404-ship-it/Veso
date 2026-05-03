<?php

class ImageProcessor
{
    public function mergeWithBackground(string $backgroundPath, string $productPath): string
    {
        $background = $this->createImage($backgroundPath);
        $product = $this->createImage($productPath);

        $bgW = imagesx($background);
        $bgH = imagesy($background);

        $productW = imagesx($product);
        $productH = imagesy($product);

        $maxW = (int)($bgW * 0.72);
        $maxH = (int)($bgH * 0.72);

        $scale = min($maxW / $productW, $maxH / $productH);
        $newW = (int)($productW * $scale);
        $newH = (int)($productH * $scale);

        $resized = imagecreatetruecolor($newW, $newH);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);

        imagecopyresampled(
            $resized,
            $product,
            0,
            0,
            0,
            0,
            $newW,
            $newH,
            $productW,
            $productH
        );

        $x = (int)(($bgW - $newW) / 2);
        $y = (int)(($bgH - $newH) / 2);

        imagealphablending($background, true);
        imagecopy($background, $resized, $x, $y, 0, 0, $newW, $newH);

        $outputPath = STORAGE_PATH . '/processed/final_' . date('Ymd_His') . '_' . bin2hex(random_bytes(5)) . '.png';
        imagepng($background, $outputPath, 9);

        imagedestroy($background);
        imagedestroy($product);
        imagedestroy($resized);

        return $outputPath;
    }

    private function createImage(string $path)
    {
        $mime = mime_content_type($path);

        return match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($path),
            'image/png' => imagecreatefrompng($path),
            'image/webp' => imagecreatefromwebp($path),
            default => throw new Exception('صيغة صورة غير مدعومة: ' . $mime),
        };
    }
}
