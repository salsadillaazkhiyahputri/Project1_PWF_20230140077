<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function getToken(Request $request)
    {
        try {
            // 1. Validasi: Pastikan user ngirim email & password yang bener formatnya
            $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // 2. Cek di Database: Apakah email & passwordnya cocok?
            if (! Auth::attempt($data)) {
                Log::info('[Auth - API] Email atau password salah');

                return response()->json([
                    'message' => 'Email atau password salah',
                ], 401);
            }

            // 3. Buat Kunci (Token): Kalau cocok, server bikin token buat user ini
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('api_token')->plainTextToken;

            Log::info("User {$user->email} berhasil dapat token");

            // 4. Kirim Balasan: Kasih tau user kalau login sukses & kasih tokennya
            return response()->json([
                'message' => 'Login berhasil',
                'access_token' => $token, // KODE INI YANG NANTI DI COPY
                'token_type' => 'Bearer',
            ], 200);

        } catch (\Throwable $e) {
            Log::error('Error saat login', [
                'message' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Terjadi kesalahan server'], 500);
        }
    }
}