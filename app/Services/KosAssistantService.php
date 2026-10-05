<?php

namespace App\Services;

use App\Models\Kost;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class KosAssistantService
{
    private const MAX_STEPS = 4;

    /**
     * Memproses pertanyaan user dan berkomunikasi dengan OpenRouter.
     */
    public function ask(array $history, string $message): string
    {
        $messages = array_merge(
            [
                [
                    'role' => 'system',
                    'content' => $this->systemPrompt(),
                ],
            ],
            array_slice($history, -10),
            [
                [
                    'role' => 'user',
                    'content' => $message,
                ],
            ]
        );

        for ($step = 0; $step < self::MAX_STEPS; $step++) {

            try {
                $response = $this->callApi($messages);
            } catch (Throwable $e) {
                Log::error('OpenRouter connection exception', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);

                return 'Maaf, asisten sedang mengalami gangguan koneksi. Coba lagi sebentar ya.';
            }

            /*
             * Rate limit
             */
            if ($response->status() === 429) {
                Log::warning('OpenRouter rate limit', [
                    'body' => $response->body(),
                ]);

                return 'Asisten sedang ramai, coba lagi beberapa detik ya.';
            }

            /*
             * Error dari OpenRouter
             */
            if ($response->failed()) {
                Log::error('OpenRouter API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return 'Maaf, asisten sedang sibuk. Coba lagi sebentar ya.';
            }

            /*
             * Ambil message dari response OpenRouter
             */
            $assistant = $response->json('choices.0.message');

            if (!is_array($assistant)) {
                Log::error('OpenRouter invalid response', [
                    'body' => $response->body(),
                ]);

                return 'Maaf, aku belum mendapatkan jawaban dari asisten.';
            }

            /*
             * Jika tidak ada tool_calls,
             * berarti AI sudah memberikan jawaban langsung.
             */
            if (empty($assistant['tool_calls'])) {
                $content = $assistant['content'] ?? null;

                if (is_string($content) && trim($content) !== '') {
                    return trim($content);
                }

                return 'Maaf, aku belum bisa menjawab itu.';
            }

            /*
             * Masukkan response assistant ke conversation.
             */
            $messages[] = $assistant;

            /*
             * Jalankan setiap tool yang diminta AI.
             */
            foreach ($assistant['tool_calls'] as $call) {

                $functionName = $call['function']['name'] ?? null;

                $arguments = $call['function']['arguments'] ?? '{}';

                $args = json_decode($arguments, true);

                if (!is_array($args)) {
                    $args = [];
                }

                $result = $this->runTool(
                    $functionName,
                    $args
                );

                $messages[] = [
                    'role' => 'tool',
                    'tool_call_id' => $call['id'] ?? '',
                    'content' => json_encode(
                        $result,
                        JSON_UNESCAPED_UNICODE
                    ),
                ];
            }
        }

        return 'Maaf, aku butuh pertanyaan yang lebih spesifik ya.';
    }

    /**
     * Instruksi utama untuk AI.
     */
    private function systemPrompt(): string
    {
        return <<<PROMPT
Kamu adalah Asisten KosinAja!, asisten virtual untuk membantu pengguna mencari kos.

ATURAN UTAMA:
1. Selalu jawab dalam Bahasa Indonesia.
2. Gunakan bahasa yang ramah, natural, singkat, dan mudah dipahami.
3. Fokus utama adalah membantu pengguna mencari kos di KosinAja!.
4. Jangan pernah mengarang data kos.
5. Jika pengguna meminta pencarian kos, WAJIB gunakan tool cari_kos.
6. Jika pengguna belum menyebutkan lokasi atau budget, tanyakan SATU informasi yang paling penting terlebih dahulu.
7. Jangan menanyakan banyak pertanyaan sekaligus.
8. Jika pengguna sudah memberikan lokasi dan budget, langsung gunakan tool cari_kos.
9. Jika hasil pencarian kosong, katakan dengan jujur bahwa tidak ada kos yang cocok.
10. Jika hasil kosong, sarankan pengguna melonggarkan filter, misalnya menaikkan budget atau mengurangi fasilitas.
11. Maksimal tampilkan 3 rekomendasi kos.
12. Untuk setiap rekomendasi, tampilkan:
   - Nama kos
   - Kisaran harga
   - Alamat
   - Jumlah kamar kosong
   - Fasilitas utama
13. Jika pengguna hanya menyapa seperti "hai", "halo", atau "hi", balas dengan ramah dan tawarkan bantuan mencari kos.
14. Jika pertanyaan di luar topik kos, arahkan kembali dengan sopan ke layanan KosinAja!.
15. Jangan mengatakan bahwa kamu memiliki akses ke data yang sebenarnya tidak diberikan oleh tool.
16. Jangan membuat-buat nama kos, harga, alamat, fasilitas, atau jumlah kamar.

CONTOH:
User: "Hai"
Assistant: "Hai! 👋 Aku Asisten KosinAja. Mau cari kos di daerah mana?"

User: "Cari kos"
Assistant: "Boleh 😊 Kamu mau cari kos di daerah mana?"

User: "Cari kos di Jakarta"
Assistant: "Siap. Budget maksimal per bulan berapa?"

User: "Cari kos di Jakarta bawah 2 juta"
→ Gunakan tool cari_kos dengan lokasi Jakarta dan harga_max 2000000.

User: "Cari kos Jakarta 1 sampai 2 juta yang ada AC"
→ Gunakan tool cari_kos dengan lokasi Jakarta, harga_min 1000000, harga_max 2000000, fasilitas AC.

Jika tidak ada hasil:
"Maaf, belum ada kos yang cocok dengan kriteria itu. Coba naikkan budget atau kurangi filter fasilitas ya 😊"

PROMPT;
    }

    /**
     * Memanggil API OpenRouter.
     */
    private function callApi(array $messages): Response
    {
        $apiKey = config('services.openrouter.api_key');
        $model = config('services.openrouter.model');

        /*
         * Pastikan konfigurasi tersedia.
         */
        if (empty($apiKey)) {
            Log::error('OpenRouter API key tidak ditemukan.');
        }

        if (empty($model)) {
            Log::error('OpenRouter model tidak ditemukan.');
        }

        return Http::withToken($apiKey)
            ->acceptJson()
            ->withHeaders([
                'HTTP-Referer' => config('app.url'),
                'X-Title' => 'KosinAja',
            ])
            ->timeout(40)
            ->post(
                'https://openrouter.ai/api/v1/chat/completions',
                [
                    'model' => $model,

                    'messages' => $messages,

                    'tools' => $this->tools(),

                    'tool_choice' => 'auto',

                    'temperature' => 0.4,

                    'max_tokens' => 600,
                ]
            );
    }

    /**
     * Daftar tool yang boleh digunakan AI.
     */
    private function tools(): array
    {
        return [
            [
                'type' => 'function',

                'function' => [
                    'name' => 'cari_kos',

                    'description' =>
                        'Cari kos berdasarkan lokasi, rentang harga sewa per bulan, dan fasilitas.',

                    'parameters' => [
                        'type' => 'object',

                        'properties' => [

                            'lokasi' => [
                                'type' => 'string',
                                'description' =>
                                    'Nama daerah, jalan, atau kota. Contoh: Jakarta, Banyuwangi, Kebayoran.',
                            ],

                            'harga_min' => [
                                'type' => 'integer',
                                'description' =>
                                    'Harga minimum sewa per bulan dalam Rupiah.',
                            ],

                            'harga_max' => [
                                'type' => 'integer',
                                'description' =>
                                    'Harga maksimum sewa per bulan dalam Rupiah.',
                            ],

                            'fasilitas' => [
                                'type' => 'string',
                                'description' =>
                                    'Satu fasilitas yang dicari. Contoh: wifi, AC, parkir.',
                            ],
                        ],

                        'additionalProperties' => false,
                    ],
                ],
            ],
        ];
    }

    /**
     * Menjalankan tool pencarian kos.
     */
    private function runTool(string $name, array $args): array
    {
        if ($name !== 'cari_kos') {
            return [
                'error' => 'Tool tidak dikenal.',
            ];
        }

        /*
         * Harga yang digunakan hanya harga aktif
         * dengan periode penagihan Bulanan.
         */
        $hargaBulanan = function ($q) {
            $q->where('isactive', true)
                ->whereHas(
                    'periode',
                    fn ($p) => $p->where(
                        'periode_penagihan',
                        'Bulanan'
                    )
                );
        };

        $query = Kost::query();

        /*
         * FILTER LOKASI
         */
        if (!empty($args['lokasi'])) {

            $lokasi = trim($args['lokasi']);

            $query->where(function ($q) use ($lokasi) {

                $q->where(
                    'alamat',
                    'like',
                    "%{$lokasi}%"
                )
                ->orWhere(
                    'nama_kost',
                    'like',
                    "%{$lokasi}%"
                );
            });
        }

        /*
         * FILTER HARGA
         */
        if (
            !empty($args['harga_min']) ||
            !empty($args['harga_max'])
        ) {

            $query->whereHas(
                'kamars.hargaKamars',
                function ($q) use ($args, $hargaBulanan) {

                    $hargaBulanan($q);

                    if (!empty($args['harga_min'])) {

                        $q->where(
                            'harga',
                            '>=',
                            (int) $args['harga_min']
                        );
                    }

                    if (!empty($args['harga_max'])) {

                        $q->where(
                            'harga',
                            '<=',
                            (int) $args['harga_max']
                        );
                    }
                }
            );
        }

        /*
         * FILTER FASILITAS
         */
        if (!empty($args['fasilitas'])) {

            $fasilitas = trim($args['fasilitas']);

            $f = '%' . $fasilitas . '%';

            $query->where(function ($q) use ($f) {

                $q->whereHas(
                    'fasilitas',
                    fn ($x) => $x->where(
                        'nama_fasilitas',
                        'like',
                        $f
                    )
                )
                ->orWhereHas(
                    'kamars.fasilitas',
                    fn ($x) => $x->where(
                        'nama_fasilitas',
                        'like',
                        $f
                    )
                );
            });
        }

        /*
         * Ambil data kos.
         */
        $hasil = $query
            ->with([
                'fasilitas',

                'kamars.fasilitas',

                'kamars.hargaKamars' => $hargaBulanan,
            ])
            ->limit(5)
            ->get();

        /*
         * Tidak ada hasil.
         */
        if ($hasil->isEmpty()) {

            return [
                'jumlah' => 0,

                'kos' => [],

                'catatan' =>
                    'Tidak ada kost yang cocok dengan filter ini.',
            ];
        }

        /*
         * Format hasil untuk AI.
         */
        return [
            'jumlah' => $hasil->count(),

            'kos' => $hasil
                ->map(function ($k) {

                    /*
                     * Ambil seluruh harga bulanan aktif.
                     */
                    $harga = $k->kamars
                        ->flatMap
                        ->hargaKamars
                        ->pluck('harga');

                    /*
                     * Gabungkan fasilitas kost dan fasilitas kamar.
                     */
                    $fasilitas = $k->fasilitas
                        ->pluck('nama_fasilitas')
                        ->merge(
                            $k->kamars
                                ->flatMap
                                ->fasilitas
                                ->pluck('nama_fasilitas')
                        )
                        ->unique()
                        ->values()
                        ->implode(', ');

                    /*
                     * Hitung kamar kosong.
                     *
                     * Di database KosinAja, status kamar
                     * yang tersedia diasumsikan "kosong".
                     */
                    $kamarKosong = $k->kamars
                        ->filter(
                            fn ($kamar) =>
                                $kamar->status === 'kosong'
                        )
                        ->count();

                    return [
                        'nama' => $k->nama_kost,

                        'alamat' => $k->alamat,

                        'harga_mulai' => $harga->isNotEmpty()
                            ? 'Rp' .
                                number_format(
                                    $harga->min(),
                                    0,
                                    ',',
                                    '.'
                                ) .
                                '/bulan'
                            : 'Hubungi pengelola',

                        'harga_hingga' => $harga->isNotEmpty()
                            ? 'Rp' .
                                number_format(
                                    $harga->max(),
                                    0,
                                    ',',
                                    '.'
                                ) .
                                '/bulan'
                            : null,

                        'jumlah_kamar' =>
                            $k->kamars->count(),

                        'kamar_kosong' =>
                            $kamarKosong,

                        'fasilitas' =>
                            $fasilitas ?: 'Belum ada informasi fasilitas.',
                    ];
                })
                ->all(),
        ];
    }
}