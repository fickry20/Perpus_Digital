<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PustakaDigital - Hub Hub Pemikiran & Pengetahuan</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Tailwind via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            .glass {
                background: rgba(255, 255, 255, 0.75);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }
            .dark-glass {
                background: rgba(17, 24, 39, 0.8);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.05);
            }
        </style>
    </head>
    <body class="antialiased bg-slate-900 text-slate-100 overflow-x-hidden">
        <!-- Floating Navbar -->
        <header class="fixed top-0 left-0 w-full z-50 px-4 py-4">
            <nav class="max-w-7xl mx-auto glass dark-glass rounded-2xl px-6 py-4 flex justify-between items-center shadow-lg transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-md shadow-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" class="w-6 h-6 text-slate-900" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-emerald-400 to-indigo-400 bg-clip-text text-transparent">PustakaDigital</span>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-slate-900 font-semibold rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="font-medium text-slate-300 hover:text-white transition-all">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-slate-900 font-semibold rounded-xl shadow-lg shadow-emerald-500/20 transition-all duration-200">
                                    Daftar Sekarang
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </nav>
        </header>

        <!-- Hero Section -->
        <section class="relative min-h-screen pt-32 pb-20 flex items-center justify-center overflow-hidden">
            <!-- Background Decorative Blobs -->
            <div class="absolute top-1/4 left-1/10 w-96 h-96 bg-emerald-500/10 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-1/4 right-1/10 w-96 h-96 bg-indigo-500/10 rounded-full blur-[100px] pointer-events-none"></div>

            <div class="max-w-5xl mx-auto px-6 text-center z-10">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-semibold mb-6 animate-pulse">
                    <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                    Perpustakaan Era Baru
                </span>

                <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                    Gerbang Digital Menuju <br>
                    <span class="bg-gradient-to-r from-emerald-400 via-teal-400 to-indigo-400 bg-clip-text text-transparent">Pengetahuan Tanpa Batas</span>
                </h1>

                <p class="text-lg md:text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                    Akses koleksi buku terbaik, lacak riwayat peminjaman secara instan, dan jelajahi wawasan baru kapan saja dan di mana saja.
                </p>

                <!-- Custom Search Bar -->
                <div class="max-w-2xl mx-auto mb-16">
                    <form action="{{ route('books.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 p-2 rounded-2xl bg-slate-800/80 border border-slate-700 shadow-2xl focus-within:border-emerald-500 transition-all duration-300">
                        <div class="flex-1 flex items-center gap-3 px-4 py-2 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" class="w-6 h-6 stroke-slate-400" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196 7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                            <input type="text" name="search" placeholder="Cari judul buku, penulis, atau ISBN..." class="w-full bg-transparent border-none outline-none text-white placeholder-slate-500 focus:ring-0">
                        </div>
                        <button type="submit" class="sm:px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-slate-900 font-semibold rounded-xl transition-all duration-200 active:scale-95 shadow-md shadow-emerald-500/10">
                            Cari Buku
                        </button>
                    </form>
                </div>

                <!-- Statistics Widgets -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                    <div class="p-6 rounded-2xl bg-slate-800/40 border border-slate-800 backdrop-blur-sm">
                        <div class="text-4xl font-extrabold text-emerald-400 mb-2">1,500+</div>
                        <div class="text-sm text-slate-400 font-medium">Koleksi Buku Digital</div>
                    </div>
                    <div class="p-6 rounded-2xl bg-slate-800/40 border border-slate-800 backdrop-blur-sm">
                        <div class="text-4xl font-extrabold text-indigo-400 mb-2">850+</div>
                        <div class="text-sm text-slate-400 font-medium">Anggota Aktif</div>
                    </div>
                    <div class="p-6 rounded-2xl bg-slate-800/40 border border-slate-800 backdrop-blur-sm col-span-2 md:col-span-1">
                        <div class="text-4xl font-extrabold text-teal-400 mb-2">99.8%</div>
                        <div class="text-sm text-slate-400 font-medium">Tingkat Layanan Pengembalian</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-24 bg-slate-950 relative border-t border-slate-900">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Bagaimana Kami Membantu Anda?</h2>
                    <p class="text-slate-400 max-w-lg mx-auto">Sistem cerdas kami dirancang untuk mempermudah manajemen dan akses buku perpustakaan.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="p-8 rounded-3xl bg-slate-900 border border-slate-850 hover:border-emerald-500/50 transition-all duration-300 group">
                        <div class="h-14 w-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 group-hover:scale-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196 7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Pencarian Cepat</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">
                            Temukan buku favorit Anda dalam hitungan detik dengan pencarian cerdas berbasis judul, penulis, maupun nomor ISBN.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="p-8 rounded-3xl bg-slate-900 border border-slate-850 hover:border-indigo-500/50 transition-all duration-300 group">
                        <div class="h-14 w-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-400 mb-6 group-hover:scale-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Peminjaman Mandiri</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">
                            Pinjam buku secara instan tanpa antre. Sistem kami otomatis mengamankan kuota buku dan menetapkan tanggal kembali.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="p-8 rounded-3xl bg-slate-900 border border-slate-850 hover:border-teal-500/50 transition-all duration-300 group">
                        <div class="h-14 w-14 bg-teal-500/10 rounded-2xl flex items-center justify-center text-teal-400 mb-6 group-hover:scale-110 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Riwayat Transaksi</h3>
                        <p class="text-slate-400 leading-relaxed text-sm">
                            Pantau riwayat buku yang dipinjam, masa tenggat waktu aktif, dan selesaikan pengembalian secara praktis di dashboard.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-12 bg-slate-900 border-t border-slate-850 text-slate-500 text-sm">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <span class="text-white font-bold text-base tracking-tight">PustakaDigital</span>
                    <p class="mt-2 text-slate-400">&copy; {{ date('Y') }} Sistem Manajemen Perpustakaan Digital. All rights reserved.</p>
                </div>
                <div class="flex gap-6 text-slate-400">
                    <a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="hover:text-emerald-400 transition-colors">Daftar</a>
                    <a href="#" class="hover:text-emerald-400 transition-colors">Syarat & Ketentuan</a>
                </div>
            </div>
        </footer>
    </body>
</html>
