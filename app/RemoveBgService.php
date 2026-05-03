<?php

class RemoveBgService
{
    private string $apiKey;

    public function __construct(?string $apiKey)
    {
        if (!$apiKey || $apiKey === 'PUT_YOUR_REMOVE_BG_KEY_HERE') {
            throw new Exception('مفتاح remove.bg غير مضبوط في ملف .env.');
        }

        $this->apiKey = $apiKey;
    }

    public function removeBackground(string $imagePath): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.remove.bg/v1.0/removebg',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'image_file' => new CURLFile($imagePath),
                'size' => 'auto',
            ],
            CURLOPT_HTTPHEADER => [
                'X-Api-Key: ' . $this->apiKey,
            ],
        ]);

        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $error = curl_error($curl);

        curl_close($curl);

        if ($result === false || $status !== 200) {
            throw new Exception('فشل إزالة الخلفية. HTTP: ' . $status . ' ' . $error);
        }

        $outputPath = STORAGE_PATH . '/temp/nobg_' . date('Ymd_His') . '_' . bin2hex(random_bytes(5)) . '.png';
        file_put_contents($outputPath, $result);

        return $outputPath;
    }
}
