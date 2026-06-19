<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Http;
// use App\Models\BotMessage;

// class BotChatController extends Controller
// {   
//     public function showGuestBotChat()
//     {
//         return view('chat.bot_guest');
//     }

//     // Tampilkan halaman pilihan: chat dokter atau bot
//     public function showOptions()
//     {
//         return view('chat.options');
//     }

//     // Tampilkan ruang chat bot
//     public function showBotChat()
//     {
//         $user = Auth::user();

//         $messages = BotMessage::where('user_id', $user->id)
//             ->orderBy('created_at')
//             ->get();

//         return view('chat.bot_space', compact('user', 'messages'));
//     }

//     // Kirim pesan ke bot
//     public function sendMessage(Request $request)
//     {
//         $request->validate([
//             'message' => 'required|string|max:1000',
//         ]);

//         $user = Auth::user();

//         // Simpan pesan user
//         BotMessage::create([
//             'user_id' => $user->id,
//             'role'    => 'user',
//             'message' => $request->message,
//         ]);

//         // Ambil history percakapan (max 10 terakhir agar tidak terlalu panjang)
//         $history = BotMessage::where('user_id', $user->id)
//             ->orderBy('created_at')
//             ->take(-10)
//             ->get()
//             ->map(fn($msg) => [
//                 'role'    => $msg->role,
//                 'content' => $msg->message,
//             ])
//             ->toArray();

//         // System prompt — atur kepribadian bot
//         $systemPrompt = [
//             'role'    => 'system',
//             'content' => 'Kamu adalah asisten kesehatan virtual MBC Clinic. Jawab pertanyaan kesehatan umum secara singkat, ramah, dan mudah dipahami dalam Bahasa Indonesia. Selalu sarankan untuk konsultasi langsung dengan dokter MBC Clinic jika keluhan serius atau butuh diagnosis pasti. Jangan memberikan resep obat dengan dosis spesifik.',
//         ];

//         $messages = array_merge([$systemPrompt], $history);

//         try {
//             $response = Http::withHeaders([
//                 'Authorization' => 'Bearer ' . config('services.deepseek.api_key'),
//                 'Content-Type'  => 'application/json',
//             ])->timeout(30)->post(config('services.deepseek.api_url'), [
//                 'model'       => 'deepseek-chat',
//                 'messages'    => $messages,
//                 'temperature' => 0.7,
//                 'max_tokens'  => 500,
//             ]);

//             if ($response->failed()) {
//                 \Log::error('DeepSeek API error', ['body' => $response->body()]);
//                 $botReply = 'Maaf, sistem bot sedang gangguan. Silakan coba lagi atau hubungi dokter kami langsung.';
//             } else {
//                 $botReply = $response->json('choices.0.message.content') 
//                     ?? 'Maaf, saya tidak bisa memproses pertanyaan itu.';
//             }

//         } catch (\Exception $e) {
//             \Log::error('DeepSeek connection failed', ['error' => $e->getMessage()]);
//             $botReply = 'Maaf, koneksi ke bot sedang bermasalah. Silakan coba lagi nanti.';
//         }

//         // Simpan balasan bot
//         $botMessage = BotMessage::create([
//             'user_id' => $user->id,
//             'role'    => 'assistant',
//             'message' => $botReply,
//         ]);

//         return response()->json([
//             'status'  => 'ok',
//             'message' => $botMessage,
//         ]);
//     }

//     // Reset/hapus riwayat chat bot
//     public function resetChat()
//     {
//         BotMessage::where('user_id', Auth::id())->delete();
//         return redirect()->back()->with('success', 'Riwayat chat bot telah direset.');
//     }

//     public function sendGuestMessage(Request $request)
//     {
//         $request->validate([
//             'message' => 'required|string|max:1000',
//             'history' => 'nullable|array', // riwayat percakapan dikirim dari JS
//         ]);

//         $systemPrompt = [
//             'role'    => 'system',
//             'content' => 'Kamu adalah asisten kesehatan virtual MBC Clinic. Jawab pertanyaan kesehatan umum secara singkat, ramah, dan mudah dipahami dalam Bahasa Indonesia. Selalu sarankan untuk konsultasi langsung dengan dokter MBC Clinic jika keluhan serius atau butuh diagnosis pasti. Jangan memberikan resep obat dengan dosis spesifik.',
//         ];

//         // Gabungkan history dari frontend + pesan baru
//         $history = $request->history ?? [];
//         $history[] = ['role' => 'user', 'content' => $request->message];

//         $messages = array_merge([$systemPrompt], $history);

//         try {
//             $response = Http::withHeaders([
//                 'Authorization' => 'Bearer ' . config('services.deepseek.api_key'),
//                 'Content-Type'  => 'application/json',
//             ])->timeout(30)->post(config('services.deepseek.api_url'), [
//                 'model'       => 'deepseek-chat',
//                 'messages'    => $messages,
//                 'temperature' => 0.7,
//                 'max_tokens'  => 500,
//             ]);

//             if ($response->failed()) {
//                 \Log::error('DeepSeek API error', ['body' => $response->body()]);
//                 $botReply = 'Maaf, sistem bot sedang gangguan. Silakan coba lagi atau hubungi dokter kami langsung.';
//             } else {
//                 $botReply = $response->json('choices.0.message.content')
//                     ?? 'Maaf, saya tidak bisa memproses pertanyaan itu.';
//             }
//         } catch (\Exception $e) {
//             \Log::error('DeepSeek connection failed', ['error' => $e->getMessage()]);
//             $botReply = 'Maaf, koneksi ke bot sedang bermasalah. Silakan coba lagi nanti.';
//         }

//         return response()->json([
//             'status'  => 'ok',
//             'message' => $botReply,
//         ]);
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\BotMessage;

class BotChatController extends Controller
{
    // ✅ BARU — helper untuk panggil AI (DeepSeek atau OpenAI, tinggal ganti AI_PROVIDER di .env)
    private function callAI(array $messages): string
    {
        $provider = config('services.ai_provider');

        if ($provider === 'openai') {
            $apiKey = config('services.openai.api_key');
            $apiUrl = config('services.openai.api_url');
            $model  = config('services.openai.model');
        } else {
            $apiKey = config('services.deepseek.api_key');
            $apiUrl = config('services.deepseek.api_url');
            $model  = config('services.deepseek.model', 'deepseek-v4-flash');
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post($apiUrl, [
                'model'       => $model,
                'messages'    => $messages,
                'temperature' => 0.7,
                'max_tokens'  => 500,
            ]);

            if ($response->failed()) {
                \Log::error("$provider API error", ['body' => $response->body()]);
                return 'Maaf, sistem bot sedang gangguan. Silakan coba lagi atau hubungi dokter kami langsung.';
            }

            return $response->json('choices.0.message.content')
                ?? 'Maaf, saya tidak bisa memproses pertanyaan itu.';

        } catch (\Exception $e) {
            \Log::error("$provider connection failed", ['error' => $e->getMessage()]);
            return 'Maaf, koneksi ke bot sedang bermasalah. Silakan coba lagi nanti.';
        }
    }

    public function showGuestBotChat()
    {
        return view('chat.bot_guest');
    }

    // Tampilkan halaman pilihan: chat dokter atau bot
    public function showOptions()
    {
        return view('chat.options');
    }

    // Tampilkan ruang chat bot
    public function showBotChat()
    {
        $user = Auth::user();

        $messages = BotMessage::where('user_id', $user->id)
            ->orderBy('created_at')
            ->get();

        return view('chat.bot_space', compact('user', 'messages'));
    }

    // Kirim pesan ke bot
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $user = Auth::user();

        // Simpan pesan user
        BotMessage::create([
            'user_id' => $user->id,
            'role'    => 'user',
            'message' => $request->message,
        ]);

        // Ambil history percakapan (max 10 terakhir agar tidak terlalu panjang)
        $history = BotMessage::where('user_id', $user->id)
            ->orderBy('created_at')
            ->take(-10)
            ->get()
            ->map(fn($msg) => [
                'role'    => $msg->role,
                'content' => $msg->message,
            ])
            ->toArray();

        // System prompt — atur kepribadian bot
        $systemPrompt = [
            'role'    => 'system',
            'content' => 'Kamu adalah asisten kesehatan virtual MBC Clinic. Jawab pertanyaan kesehatan umum secara singkat, ramah, dan mudah dipahami dalam Bahasa Indonesia. Selalu sarankan untuk konsultasi langsung dengan dokter MBC Clinic jika keluhan serius atau butuh diagnosis pasti. Jangan memberikan resep obat dengan dosis spesifik.',
        ];

        $messages = array_merge([$systemPrompt], $history);

        // ✅ DIGANTI — sekarang panggil helper callAI() bukan kode Http manual
        $botReply = $this->callAI($messages);

        // Simpan balasan bot
        $botMessage = BotMessage::create([
            'user_id' => $user->id,
            'role'    => 'assistant',
            'message' => $botReply,
        ]);

        return response()->json([
            'status'  => 'ok',
            'message' => $botMessage,
        ]);
    }

    // Reset/hapus riwayat chat bot
    public function resetChat()
    {
        BotMessage::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Riwayat chat bot telah direset.');
    }

    public function sendGuestMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'history' => 'nullable|array', // riwayat percakapan dikirim dari JS
        ]);

        $systemPrompt = [
            'role'    => 'system',
            'content' => 'Kamu adalah asisten kesehatan virtual MBC Clinic. Jawab pertanyaan kesehatan umum secara singkat, ramah, dan mudah dipahami dalam Bahasa Indonesia. Selalu sarankan untuk konsultasi langsung dengan dokter MBC Clinic jika keluhan serius atau butuh diagnosis pasti. Jangan memberikan resep obat dengan dosis spesifik.',
        ];

        // Gabungkan history dari frontend + pesan baru
        $history = $request->history ?? [];
        $history[] = ['role' => 'user', 'content' => $request->message];

        $messages = array_merge([$systemPrompt], $history);

        // ✅ DIGANTI — sekarang panggil helper callAI() bukan kode Http manual
        $botReply = $this->callAI($messages);

        return response()->json([
            'status'  => 'ok',
            'message' => $botReply,
        ]);
    }
}