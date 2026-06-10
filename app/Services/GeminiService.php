<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    /**
     * Generate structured news article using Google Gemini API.
     */
    public static function generateNews(string $prompt, string $tone = 'formal'): ?array
    {
        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey)) {
            throw new \Exception("GEMINI_API_KEY belum dikonfigurasi di file .env Anda. Silakan dapatkan API Key gratis di Google AI Studio dan tambahkan ke file .env.");
        }

        $systemInstruction = "Anda adalah seorang jurnalis profesional Indonesia yang ahli dalam menyusun berita menarik, kredibel, dan berbobot.";
        
        if ($tone === 'informal') {
            $systemInstruction .= " Tulis berita dengan gaya bahasa yang santai, kreatif, populer, menarik bagi generasi muda, namun tetap informatif dan beretika.";
        } elseif ($tone === 'professional') {
            $systemInstruction .= " Tulis berita dengan gaya bahasa profesional, berbobot, berbasis fakta, edukatif, dan informatif.";
        } else {
            $systemInstruction .= " Tulis berita dengan gaya jurnalistik formal, resmi, sesuai standar kode etik jurnalistik (PUEBI/KBBI) dan struktur piramida terbalik.";
        }

        $systemInstruction .= " Output harus dikembalikan dalam format JSON mentah (raw JSON) dengan struktur sebagai berikut: {\"title\": \"Judul Berita\", \"content\": \"Isi berita dalam format HTML lengkap dengan tag-tag semantik seperti <p>, <strong>, <ul>, dan <ol> untuk mempermudah pembacaan. Jangan gunakan tag <h1> atau <h2> karena itu sudah disediakan oleh sistem layout.\"}";
        $systemInstruction .= " SANGAT PENTING: Untuk menghindari kegagalan parsing JSON (JSON decode error), pastikan semua tanda kutip ganda (\") di dalam teks isi berita ditulis menggunakan tanda kutip tunggal (') atau entitas HTML (&quot; atau &ldquo; dan &rdquo;). Jangan pernah menuliskan tanda kutip ganda (\") langsung di dalam nilai teks JSON.";

        $fullPrompt = "Topik/Kata kunci/Berita Mentah: \n" . $prompt . "\n\nBuatkan berita utuh sesuai instruksi.";

        $modelEnv = env('GEMINI_MODEL');
        if (!empty($modelEnv)) {
            $modelsToTry = [$modelEnv];
        } else {
            $modelsToTry = ['gemini-2.5-flash', 'gemini-2.0-flash', 'gemini-1.5-flash'];
        }

        $lastError = null;
        $response = null;

        try {
            foreach ($modelsToTry as $model) {
                try {
                    $response = Http::withoutVerifying()->post(
                        "https://generativelanguage.googleapis.com/v1/models/" . $model . ":generateContent?key=" . $apiKey,
                        [
                            'contents' => [
                                [
                                    'parts' => [
                                        ['text' => $systemInstruction . "\n\n" . $fullPrompt]
                                    ]
                                ]
                            ]
                        ]
                    );

                    if ($response->successful()) {
                        $lastError = null;
                        break;
                    }

                    $errorMsg = $response->json()['error']['message'] ?? 'Gagal menghubungi server Gemini.';
                    Log::warning("Gemini service failed for model {$model}: {$errorMsg}");
                    $lastError = new \Exception("Gemini API Error ({$model}): " . $errorMsg);

                } catch (\Exception $e) {
                    Log::warning("Gemini HTTP request failed for model {$model}: " . $e->getMessage());
                    $lastError = $e;
                }
            }

            if ($lastError !== null || $response === null || !$response->successful()) {
                throw $lastError ?? new \Exception("Gagal menghubungi server Gemini setelah mencoba semua model.");
            }

            $result = $response->json();
            $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (empty($text)) {
                throw new \Exception("Respons AI kosong.");
            }

            // Extract JSON block from Gemini's response (supporting both ```json and plain ``` markdown formats)
            $jsonText = $text;
            if (preg_match('/```json\s*(.*?)\s*```/s', $text, $matches)) {
                $jsonText = $matches[1];
            } elseif (preg_match('/```\s*(.*?)\s*```/s', $text, $matches)) {
                $jsonText = $matches[1];
            } else {
                // Find first '{' and last '}'
                $start = strpos($text, '{');
                $end = strrpos($text, '}');
                if ($start !== false && $end !== false) {
                    $jsonText = substr($text, $start, $end - $start + 1);
                }
            }

            $decoded = json_decode(trim($jsonText), true);
            
            // Fallback: If JSON decoding fails, wrap the raw response as content
            if (json_last_error() !== JSON_ERROR_NONE) {
                return [
                    'title' => 'Berita AI Berhasil Dibuat',
                    'content' => '<p>' . nl2br(e($text)) . '</p>',
                ];
            }

            return [
                'title' => $decoded['title'] ?? 'Judul Berita Berhasil Dibuat',
                'content' => $decoded['content'] ?? '<p>Konten berita berhasil dibuat.</p>',
            ];

        } catch (\Exception $e) {
            Log::error("Gemini News Generation failed: " . $e->getMessage());
            throw $e;
        }
    }
}
