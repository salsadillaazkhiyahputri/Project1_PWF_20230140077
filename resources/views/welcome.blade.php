<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel - Profil Mahasiswa</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
        
        <script>
            // Konfigurasi agar warna oranye-merah kamu aktif
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            brand: '#f53003',
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="bg-[#0a0a0a] text-[#EDEDEC] min-h-screen flex flex-col items-center justify-center p-6" style="font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">

        @if (Route::has('login'))
            <header class="w-full max-w-2xl text-right mb-12 text-sm">
                <nav class="flex justify-end gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 border border-[#3E3E3A] rounded-full transition-all hover:bg-white hover:text-black hover:border-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 border border-transparent rounded-full transition-all hover:text-brand">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 border border-[#3E3E3A] rounded-full transition-all hover:bg-white hover:text-black hover:border-white">Register</a>
                        @endif
                    @endauth
                </nav>
            </header>
        @endif

        <div class="relative group w-full max-w-lg">
            <div class="absolute -inset-1 bg-gradient-to-r from-brand to-orange-500 rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000"></div>
            
            <main class="relative bg-[#161615] border border-white/10 rounded-2xl p-10 shadow-2xl overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand to-orange-500"></div>

                <div class="flex flex-col gap-8">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand mb-2 block">Nama Lengkap</span>
                        <h1 class="text-2xl font-semibold tracking-tight text-white">Salsa Dilla Azkhiyah Putri</h1>
                    </div>

                    <div class="flex justify-between items-end border-t border-white/5 pt-8">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#A1A09A] mb-1 block">NIM Mahasiswa</span>
                            <p class="text-xl font-mono tracking-widest text-white">20230140077</p>
                        </div>
                        
                        <div class="w-14 h-14 flex items-center justify-center bg-brand/10 rounded-xl border border-brand/20 shadow-[0_0_15px_rgba(245,48,3,0.2)]">
                             <svg class="w-8 h-8 text-brand" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                             </svg>
                        </div>
                    </div>

                    <div class="mt-4 pt-4">
                        <a href="{{ url('/about') }}" class="group/btn relative inline-flex items-center justify-center w-full px-8 py-4 font-bold text-black transition-all duration-200 bg-white rounded-xl hover:bg-gray-200 active:scale-95 shadow-lg">
                            Lihat Modul Pertemuan 2 (About)
                            <svg class="w-4 h-4 ml-2 transition-transform group-hover/btn:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </a>
                    </div>
                </div>
            </main>
        </div>

        <footer class="mt-12 text-[#706f6c] text-[10px] uppercase tracking-[0.2em] text-center">
            Teknologi Informasi &bull; Universitas Muhammadiyah Yogyakarta
        </footer>

    </body>
</html>