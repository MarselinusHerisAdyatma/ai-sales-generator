<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiTestController extends Controller
{

public function testAi()
{
    $apiKey = config('services.gemini.key');

    // Kita pakai model terbaru dari list kamu: gemini-2.5-flash
    $response = Http::withoutVerifying()
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "Halo Gemini 2.5! Saya sedang belajar integrasi API. Bisa beri saya satu kalimat penyemangat?"]
                    ]
                ]
            ]
        ]);

    // Cek jika error
    if ($response->failed()) {
        return $response->json();
    }

    // Ambil teks jawaban
    return $response->json()['candidates'][0]['content']['parts'][0]['text'];
}

}