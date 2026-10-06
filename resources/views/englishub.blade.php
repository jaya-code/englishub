<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#4f46e5">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>EnglisHub Mobile - Belajar Bahasa Inggris Mandiri & Mahir</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192.svg">
    <link rel="icon" type="image/svg+xml" href="/icons/icon-192.svg">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Canvas Confetti for Celebrations -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        .perspective-1000 { perspective: 1000px; }
        .transform-style-3d { transform-style: preserve-3d; }
        .backface-hidden { backface-visibility: hidden; -webkit-backface-visibility: hidden; }
        .rotate-y-180 { transform: rotateY(180deg); }
        .touch-action-manipulation { touch-action: manipulation; }
        .bg-mesh-gradient {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.25) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(236, 72, 153, 0.2) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(16, 185, 129, 0.15) 0px, transparent 50%);
        }
        @keyframes soundwave {
            0%, 100% { height: 6px; }
            50% { height: 34px; }
        }
        .animate-wave-1 { animation: soundwave 0.8s ease-in-out infinite 0.1s; }
        .animate-wave-2 { animation: soundwave 0.9s ease-in-out infinite 0.2s; }
        .animate-wave-3 { animation: soundwave 0.7s ease-in-out infinite 0.3s; }
        .animate-wave-4 { animation: soundwave 1.0s ease-in-out infinite 0.15s; }
        .animate-wave-5 { animation: soundwave 0.85s ease-in-out infinite 0.25s; }
    </style>
</head>
<body class="h-full bg-slate-950 text-slate-100 antialiased flex flex-col items-center justify-start min-h-screen selection:bg-indigo-500 selection:text-white">

    <!-- DESKTOP TOP BAR (Toggles preview frame & info) -->
    <header class="w-full max-w-5xl px-4 py-2 hidden md:flex items-center justify-between text-xs text-slate-400 border-b border-slate-800/80 bg-slate-900/60 backdrop-blur-md">
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center justify-center w-5 h-5 rounded-md bg-gradient-to-tr from-indigo-500 to-violet-500 text-white font-bold text-[11px]">EH</span>
            <span class="font-semibold text-slate-200">EnglisHub Mobile</span>
            <span class="bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 px-2 py-0.5 rounded-full text-[11px] font-medium">Aplikasi Web Belajar Cepat & Fasih</span>
        </div>
        <div class="flex items-center gap-3">
            <button id="toggleDeviceFrameBtn" onclick="toggleDesktopFrame()" class="flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-800 hover:bg-slate-700 text-slate-300 transition-colors">
                <span id="frameIcon">📱</span>
                <span id="frameLabel">Mode Layar HP</span>
            </button>
            <span class="text-slate-600">|</span>
            <span>Versi Mobile-Optimized PWA</span>
        </div>
    </header>

    <!-- MAIN APP CONTAINER (Adaptive Mobile Frame) -->
    <div id="appContainer" class="w-full h-full min-h-screen md:min-h-[860px] md:h-[92vh] md:max-w-[430px] md:my-auto md:rounded-[44px] md:shadow-[0_25px_80px_-15px_rgba(79,70,229,0.35),0_0_0_12px_#1e293b,0_0_0_14px_#334155] bg-slate-900 flex flex-col overflow-hidden relative border-slate-800">
        
        <!-- MOBILE NOTCH / STATUS BAR (Cosmetic on Desktop, Safe Area on Mobile) -->
        <div class="w-full pt-3 px-6 pb-1 flex items-center justify-between text-xs font-semibold text-slate-400 select-none z-30">
            <div id="liveClock" class="tracking-tight text-slate-300">09:41</div>
            <div class="w-24 h-4 bg-slate-950 rounded-full hidden md:block"></div>
            <div class="flex items-center gap-1.5">
                <span class="text-[11px]">⚡ 5G</span>
                <div class="w-5 h-2.5 border border-slate-400 rounded-sm p-[1px] flex items-center">
                    <div class="h-full w-full bg-emerald-400 rounded-[1px]"></div>
                </div>
            </div>
        </div>

        <!-- TOP APP HEADER -->
        <div class="px-4 py-2.5 flex items-center justify-between border-b border-slate-800/80 bg-slate-900/90 backdrop-blur-md z-20">
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-pink-500 p-[2px] shadow-lg shadow-indigo-500/20">
                    <div class="w-full h-full bg-slate-900 rounded-[14px] flex items-center justify-center text-lg font-black text-indigo-400">
                        🇬🇧
                    </div>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <h1 class="text-sm font-extrabold tracking-tight text-white">EnglisHub</h1>
                        <span id="headerLevelTag" class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Lv.1 Dasar</span>
                    </div>
                    <p class="text-[11px] text-slate-400">Hafal, Ucapkan & Kuasai</p>
                </div>
            </div>

            <!-- Header Quick Stats (Streak & XP) -->
            <div class="flex items-center gap-1.5">
                <div class="flex items-center gap-1 bg-amber-500/10 border border-amber-500/30 px-2 py-1 rounded-xl text-amber-400 font-bold text-xs shadow-sm">
                    <span>🔥</span>
                    <span id="streakCount">5</span>
                </div>
                <div class="flex items-center gap-1 bg-indigo-500/15 border border-indigo-500/30 px-2 py-1 rounded-xl text-indigo-300 font-bold text-xs shadow-sm">
                    <span>💎</span>
                    <span id="xpCount">{{ $stats['xp'] }}</span>
                    <span class="text-[10px] text-indigo-400 font-normal">XP</span>
                </div>
                <button onclick="toggleAudioSettingsModal()" title="Pengaturan Audio" class="w-8 h-8 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center text-xs transition-colors">
                    🔊
                </button>
            </div>
        </div>

        <!-- MAIN SCROLLABLE CONTENT VIEW -->
        <main id="mainScrollArea" class="flex-1 overflow-y-auto overflow-x-hidden no-scrollbar pb-24 px-4 pt-3 space-y-4">
            
            <!-- SECTION 1: MODUL BELAJAR (LEARN) -->
            <div id="view-learn" class="space-y-4 transition-all duration-200">
                
                <!-- Daily Target Progress Card -->
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-900/60 via-purple-900/40 to-slate-900 border border-indigo-500/30 p-3.5 shadow-lg">
                    <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <span class="text-[11px] font-semibold uppercase tracking-wider text-indigo-300">Target Harianmu</span>
                            <h3 class="text-xs font-bold text-white flex items-center gap-1">
                                <span>🎯 Selesaikan 10 Kata Hari Ini</span>
                            </h3>
                        </div>
                        <span id="dailyProgressText" class="text-xs font-extrabold text-indigo-300 bg-indigo-500/20 px-2 py-0.5 rounded-full border border-indigo-500/30">
                            {{ min($stats['practiced_words'], 10) }}/10
                        </span>
                    </div>
                    <div class="w-full bg-slate-800/80 rounded-full h-2.5 overflow-hidden p-[2px]">
                        @php
                            $targetPercent = min(100, round(($stats['practiced_words'] / 10) * 100));
                        @endphp
                        <div id="dailyProgressBar" class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-pink-500 transition-all duration-500" style="width: {{ $targetPercent }}%;"></div>
                    </div>
                    <div class="flex items-center justify-between mt-2 text-[11px] text-slate-400">
                        <span>Skor Suara Rata-rata: <strong class="text-emerald-400" id="statAvgScore">{{ $stats['avg_score'] }}%</strong></span>
                        <span>Total Hafal: <strong class="text-indigo-300" id="statMasteredWords">{{ $stats['mastered_words'] }} kata</strong></span>
                    </div>
                </div>

                <!-- Level Selector Tabs -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Tahapan Belajar</span>
                        <span class="text-[11px] text-slate-400">Pilih level kemampuanmu</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5 p-1 bg-slate-800/70 rounded-2xl border border-slate-700/60">
                        <button onclick="filterCurriculum('beginner')" id="btnLevel-beginner" class="level-tab-btn active py-2 rounded-xl text-xs font-bold transition-all text-center flex flex-col items-center gap-0.5 bg-indigo-600 text-white shadow-md">
                            <span>🟢 Level 1</span>
                            <span class="text-[10px] font-medium opacity-90">Dasar · {{ $levelWordCounts['beginner'] ?? 0 }} kata</span>
                        </button>
                        <button onclick="filterCurriculum('daily')" id="btnLevel-daily" class="level-tab-btn py-2 rounded-xl text-xs font-bold transition-all text-center flex flex-col items-center gap-0.5 text-slate-400 hover:text-slate-200">
                            <span>🟡 Level 2</span>
                            <span class="text-[10px] font-medium opacity-90">Harian · {{ $levelWordCounts['daily'] ?? 0 }} kata</span>
                        </button>
                        <button onclick="filterCurriculum('advanced')" id="btnLevel-advanced" class="level-tab-btn py-2 rounded-xl text-xs font-bold transition-all text-center flex flex-col items-center gap-0.5 text-slate-400 hover:text-slate-200">
                            <span>🟣 Level 3</span>
                            <span class="text-[10px] font-medium opacity-90">Mahir · {{ $levelWordCounts['advanced'] ?? 0 }} kata</span>
                        </button>
                    </div>
                </div>

                <!-- Fast Action Launchers -->
                <div class="grid grid-cols-4 gap-1.5">
                    <button onclick="launchQuickMode('flashcard')" class="p-2 rounded-2xl bg-gradient-to-b from-indigo-500/20 to-indigo-600/10 border border-indigo-500/30 hover:border-indigo-400/60 transition-all text-left group">
                        <div class="text-lg mb-0.5 group-hover:scale-110 transition-transform">🗂️</div>
                        <div class="text-[11px] font-bold text-white leading-tight">Flashcard</div>
                        <div class="text-[10px] text-indigo-300">Hafal Cepat</div>
                    </button>
                    <button onclick="launchQuickMode('quiz')" class="p-2 rounded-2xl bg-gradient-to-b from-amber-500/20 to-amber-600/10 border border-amber-500/30 hover:border-amber-400/60 transition-all text-left group">
                        <div class="text-lg mb-0.5 group-hover:scale-110 transition-transform">🎯</div>
                        <div class="text-[11px] font-bold text-white leading-tight">Kuis Arti</div>
                        <div class="text-[10px] text-amber-300">Tes Memori</div>
                    </button>
                    <button onclick="launchQuickMode('builder')" class="p-2 rounded-2xl bg-gradient-to-b from-cyan-500/20 to-cyan-600/10 border border-cyan-500/30 hover:border-cyan-400/60 transition-all text-left group">
                        <div class="text-lg mb-0.5 group-hover:scale-110 transition-transform">🧩</div>
                        <div class="text-[11px] font-bold text-white leading-tight">Susun Kata</div>
                        <div class="text-[10px] text-cyan-300">Pola Kalimat</div>
                    </button>
                    <button onclick="launchQuickMode('pronounce')" class="p-2 rounded-2xl bg-gradient-to-b from-emerald-500/20 to-emerald-600/10 border border-emerald-500/30 hover:border-emerald-400/60 transition-all text-left group">
                        <div class="text-lg mb-0.5 group-hover:scale-110 transition-transform">🎙️</div>
                        <div class="text-[11px] font-bold text-white leading-tight">Studio Suara</div>
                        <div class="text-[10px] text-emerald-300">Cek Suara</div>
                    </button>
                </div>

                <!-- Grammar & Sentence Rules Cheat Sheet Banner -->
                <div onclick="openGrammarModal()" class="cursor-pointer p-3 rounded-2xl bg-gradient-to-r from-blue-900/60 via-indigo-900/40 to-slate-900 border border-blue-500/30 hover:border-blue-400/60 transition-all flex items-center justify-between group shadow-md">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-blue-500/20 border border-blue-500/40 flex items-center justify-center text-lg shrink-0">
                            📘
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white group-hover:text-blue-300 transition-colors">Panduan Pola Kalimat & Tata Bahasa (Grammar)</div>
                            <div class="text-[11px] text-blue-200/80">Rumus S-V-O, 4 Tenses Utama, To Be & Do/Does</div>
                        </div>
                    </div>
                    <span class="text-xs text-blue-400 group-hover:translate-x-1 transition-transform">Buka ➜</span>
                </div>

                <!-- Learning Categories List -->
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-300 uppercase tracking-wider">Topik & Kategori Materi</span>
                        <span id="categoryCountBadge" class="text-[11px] text-slate-400">{{ count($categories) }} Modul Lengkap</span>
                    </div>

                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">🔍</span>
                        <input type="text" id="categorySearchInput" oninput="applyCategoryFilters()" placeholder="Cari topik, mis. hotel, makanan, idiom..." class="w-full pl-9 pr-3 py-2.5 rounded-2xl bg-slate-800 border border-slate-700 focus:border-indigo-500 text-xs text-white placeholder-slate-500 focus:outline-none transition-colors">
                    </div>

                    <div id="categoryEmptyState" class="hidden text-center py-6 text-xs text-slate-500">Tidak ada topik yang cocok.</div>

                    <div id="categoryCardsContainer" class="space-y-2.5">
                        @foreach ($categories as $cat)
                            <div data-level="{{ $cat->level }}" data-category-id="{{ $cat->id }}" data-name="{{ \Illuminate\Support\Str::lower($cat->name.' '.$cat->description) }}" class="category-card p-3.5 rounded-2xl bg-slate-800/80 border border-slate-700/70 hover:border-indigo-500/50 transition-all group shadow-sm">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-11 h-11 rounded-2xl bg-slate-900 border border-slate-700/80 flex items-center justify-center text-xl shrink-0 group-hover:scale-105 transition-transform shadow-inner">
                                            {{ $cat->icon }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-xs font-bold text-white group-hover:text-indigo-300 transition-colors">{{ $cat->name }}</h4>
                                                <span class="text-[10px] uppercase px-1.5 py-0.2 rounded-md font-semibold
                                                    {{ $cat->level === 'beginner' ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30' : ($cat->level === 'daily' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'bg-purple-500/20 text-purple-300 border border-purple-500/30') }}">
                                                    {{ $cat->level === 'beginner' ? 'Dasar' : ($cat->level === 'daily' ? 'Sehari-hari' : 'Mahir') }}
                                                </span>
                                            </div>
                                            <p class="text-xs text-slate-400 mt-0.5 line-clamp-2 leading-snug">{{ $cat->description }}</p>
                                            <div class="flex items-center gap-3 mt-2 text-[11px] text-slate-400 font-medium">
                                                <span>📚 {{ $cat->vocabularies_count }} Kosakata</span>
                                                <span>•</span>
                                                <span class="text-indigo-400">Audio & Fonetik</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3 flex items-center gap-2">
                                    <div class="flex-1 h-1.5 rounded-full bg-slate-900 overflow-hidden">
                                        <div class="category-progress-bar h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-400 transition-all duration-500" style="width: 0%"></div>
                                    </div>
                                    <span class="category-progress-label text-[11px] font-semibold text-slate-400 tabular-nums">0/{{ $cat->vocabularies_count }}</span>
                                </div>

                                <!-- Action Buttons per Category -->
                                <div class="grid grid-cols-3 gap-1.5 mt-3 pt-2.5 border-t border-slate-700/50">
                                    <button onclick="openCategoryStudy({{ $cat->id }}, 'flashcard')" class="py-1.5 px-2 rounded-xl bg-slate-900 hover:bg-indigo-600/30 border border-slate-700 hover:border-indigo-500/40 text-[11px] font-semibold text-slate-300 hover:text-white transition-all flex items-center justify-center gap-1">
                                        <span>🗂️</span> Hafal
                                    </button>
                                    <button onclick="openCategoryStudy({{ $cat->id }}, 'quiz')" class="py-1.5 px-2 rounded-xl bg-slate-900 hover:bg-amber-600/30 border border-slate-700 hover:border-amber-500/40 text-[11px] font-semibold text-slate-300 hover:text-white transition-all flex items-center justify-center gap-1">
                                        <span>🎯</span> Kuis
                                    </button>
                                    <button onclick="openCategoryStudy({{ $cat->id }}, 'pronounce')" class="py-1.5 px-2 rounded-xl bg-slate-900 hover:bg-emerald-600/30 border border-slate-700 hover:border-emerald-500/40 text-[11px] font-semibold text-slate-300 hover:text-white transition-all flex items-center justify-center gap-1">
                                        <span>🎙️</span> Ucapkan
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- SECTION 2: FLASHCARD STUDY MODE -->
            <div id="view-flashcard" class="hidden space-y-4 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <button onclick="switchTab('learn')" class="text-xs text-indigo-400 flex items-center gap-1 hover:underline font-semibold">
                        <span>← Kembali ke Modul</span>
                    </button>
                    <span id="fcCategoryBadge" class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Semua Kosakata</span>
                </div>

                <!-- Progress Header -->
                <div class="flex items-center justify-between text-xs text-slate-400">
                    <span class="font-medium">Kartu <strong id="fcCurrentIndex" class="text-white">1</strong> dari <span id="fcTotalCards">0</span></span>
                    <div class="flex items-center gap-1">
                        <button onclick="playSlowToggle()" id="fcSlowBtn" class="text-[11px] px-2 py-0.5 rounded-md bg-slate-800 text-slate-300 border border-slate-700 flex items-center gap-1">
                            <span>🐢</span> Mode Pelan: <strong id="slowModeLabel" class="text-emerald-400">OFF</strong>
                        </button>
                    </div>
                </div>

                <!-- 3D Interactive Card Container -->
                <div class="perspective-1000 w-full min-h-[340px] cursor-pointer select-none" onclick="flipFlashcard()">
                    <div id="flashcardElement" class="w-full h-full min-h-[340px] transform-style-3d transition-transform duration-500 relative rounded-3xl">
                        
                        <!-- CARD FRONT (English & Phonetics) -->
                        <div class="backface-hidden absolute inset-0 rounded-3xl bg-gradient-to-br from-slate-800 via-slate-900 to-indigo-950 border-2 border-indigo-500/40 p-6 flex flex-col justify-between shadow-2xl shadow-indigo-950/50">
                            <div class="flex items-center justify-between">
                                <span id="fcFrontPos" class="text-[11px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Noun</span>
                                <span id="fcFrontDifficulty" class="text-[11px] font-semibold text-slate-400">Basic A1</span>
                            </div>

                            <div class="text-center my-auto py-4">
                                <h2 id="fcFrontWord" class="text-3xl font-extrabold text-white tracking-tight leading-tight">Word</h2>
                                <p id="fcFrontPhonetic" class="text-sm font-medium text-indigo-300 mt-2 tracking-wide font-mono">/wɜːd/</p>
                                
                                <div class="mt-4 flex items-center justify-center gap-2" onclick="event.stopPropagation()">
                                    <button onclick="speakWord(currentFlashcardWord)" class="px-4 py-2 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs flex items-center gap-1.5 shadow-lg shadow-indigo-500/30 transition-transform active:scale-95">
                                        <span>🔊</span> Dengarkan Pelafalan
                                    </button>
                                </div>
                            </div>

                            <div class="text-center text-[11px] text-slate-400 flex items-center justify-center gap-1">
                                <span>↻ Ketuk kartu untuk membalik & melihat arti</span>
                            </div>
                        </div>

                        <!-- CARD BACK (Meaning, Examples & Tips) -->
                        <div class="backface-hidden rotate-y-180 absolute inset-0 rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 border-2 border-emerald-500/40 p-6 flex flex-col justify-between shadow-2xl shadow-emerald-950/50">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Terjemahan</span>
                                <span id="fcBackWordSmall" class="text-xs font-bold text-slate-300">Word</span>
                            </div>

                            <div class="my-auto space-y-3">
                                <div>
                                    <h3 id="fcBackTranslation" class="text-xl font-black text-emerald-400 leading-snug">Arti Kata</h3>
                                </div>

                                <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/70 text-left">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-[11px] font-bold text-indigo-300">Contoh Kalimat:</span>
                                        <button onclick="event.stopPropagation(); speakWord(currentFlashcardExample)" class="text-xs text-slate-300 hover:text-white">
                                            🔊
                                        </button>
                                    </div>
                                    <p id="fcBackExample" class="text-xs font-semibold text-white leading-relaxed">Example sentence goes here.</p>
                                    <p id="fcBackExampleTr" class="text-xs text-slate-400 mt-1 italic leading-relaxed">Terjemahan kalimat contoh.</p>
                                </div>

                                <div class="p-2.5 rounded-xl bg-amber-500/10 border border-amber-500/20 text-left">
                                    <div class="flex items-center gap-1 text-[11px] font-bold text-amber-400">
                                        <span>💡</span> Tips Pelafalan (Pronunciation)
                                    </div>
                                    <p id="fcBackTip" class="text-[11px] text-amber-200/90 mt-0.5 leading-snug">Penekanan suku kata...</p>
                                </div>
                            </div>

                            <div class="text-center text-[11px] text-slate-400">
                                <span>↻ Ketuk untuk kembali ke sisi depan</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Flashcard Action Buttons -->
                <div class="grid grid-cols-2 gap-2.5">
                    <button onclick="markFlashcardStatus(false)" class="py-3 px-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 text-xs font-bold flex items-center justify-center gap-1.5 transition-all active:scale-98 shadow-sm">
                        <span>🔄</span> Perlu Diulang
                    </button>
                    <button onclick="markFlashcardStatus(true)" class="py-3 px-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-extrabold flex items-center justify-center gap-1.5 transition-all active:scale-98 shadow-lg shadow-emerald-600/25">
                        <span>✨</span> Sudah Hafal (+25 XP)
                    </button>
                </div>

                <!-- Prev/Next Controls -->
                <div class="flex items-center justify-between pt-1">
                    <button onclick="prevFlashcard()" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold flex items-center gap-1">
                        <span>← Sebelumnya</span>
                    </button>
                    <button onclick="practicePronunciationCurrentWord()" class="py-1.5 px-3 rounded-xl bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-xs font-bold flex items-center gap-1 hover:bg-indigo-500/30">
                        <span>🎙️</span> Latih di Studio
                    </button>
                    <button onclick="nextFlashcard()" class="p-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-semibold flex items-center gap-1">
                        <span>Berikutnya →</span>
                    </button>
                </div>
            </div>

            <!-- SECTION 3: QUIZ & KUIS KOSAKATA -->
            <div id="view-quiz" class="hidden space-y-4 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <button onclick="switchTab('learn')" class="text-xs text-indigo-400 flex items-center gap-1 hover:underline font-semibold">
                        <span>← Kembali</span>
                    </button>
                    <div class="flex items-center gap-2">
                        <span id="quizStreakBadge" class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30">🔥 Streak: 0</span>
                        <span id="quizHearts" class="text-xs">❤️❤️❤️</span>
                    </div>
                </div>

                <!-- Submode Tabs -->
                <div class="grid grid-cols-3 gap-1 p-1 bg-slate-800/80 rounded-2xl border border-slate-700/60">
                    <button onclick="setQuizSubMode('mcq')" id="btnQuizMode-mcq" class="py-1.5 rounded-xl text-xs font-bold transition-all text-center bg-indigo-600 text-white shadow-sm">
                        <span>🎯 Tebak Arti</span>
                    </button>
                    <button onclick="setQuizSubMode('builder')" id="btnQuizMode-builder" class="py-1.5 rounded-xl text-xs font-bold transition-all text-center text-slate-400 hover:text-slate-200">
                        <span>🧩 Susun Kalimat</span>
                    </button>
                    <button onclick="setQuizSubMode('listening')" id="btnQuizMode-listening" class="py-1.5 rounded-xl text-xs font-bold transition-all text-center text-slate-400 hover:text-slate-200">
                        <span>👂 Dengar Suara</span>
                    </button>
                </div>

                <!-- SUBMODE 1: MULTIPLE CHOICE (TEBAK ARTI) -->
                <div id="quizContainer-mcq" class="space-y-4">
                    <div id="quizCardBox" class="p-5 rounded-3xl bg-slate-800/90 border border-slate-700 shadow-xl space-y-4 text-center">
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span id="quizModeBadge" class="font-bold text-indigo-400 uppercase tracking-wider">Tebak Arti Kata</span>
                            <span>Soal <strong id="quizCurrentNo" class="text-white">1</strong>/10</span>
                        </div>

                        <div class="py-2">
                            <span class="text-xs text-slate-400">Apa arti dari kata bahasa Inggris berikut?</span>
                            <div class="flex items-center justify-center gap-2 mt-1">
                                <h2 id="quizQuestionWord" class="text-2xl font-black text-white tracking-tight">Delicious</h2>
                                <button onclick="speakWord(quizTargetWord)" class="text-sm p-1 rounded-lg bg-indigo-500/20 text-indigo-300 hover:bg-indigo-500/40">
                                    🔊
                                </button>
                            </div>
                            <p id="quizQuestionPhonetic" class="text-xs font-mono text-indigo-300 mt-1">/dɪˈlɪʃ.əs/</p>
                        </div>

                        <!-- 4 Multiple Choice Options -->
                        <div id="quizOptionsContainer" class="grid grid-cols-1 gap-2 pt-1">
                            <!-- Dynamically populated options -->
                        </div>

                        <!-- Feedback Banner -->
                        <div id="quizFeedbackBox" class="hidden p-3 rounded-2xl text-xs font-bold transition-all">
                            <span id="quizFeedbackText">Bagus sekali! Jawaban benar.</span>
                        </div>
                    </div>
                </div>

                <!-- SUBMODE 2: SENTENCE BUILDER (SUSUN POLA KALIMAT) -->
                <div id="quizContainer-builder" class="hidden space-y-4">
                    <div class="p-5 rounded-3xl bg-slate-800/90 border border-cyan-500/30 shadow-xl space-y-4 text-center">
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span class="font-bold text-cyan-400 uppercase tracking-wider">Susun Kalimat (Sentence Builder)</span>
                            <span id="builderProgressLabel" class="text-white font-semibold">1 / 5</span>
                        </div>

                        <div class="p-3 rounded-2xl bg-cyan-950/40 border border-cyan-500/30 text-left">
                            <span class="text-[11px] font-bold text-cyan-400 uppercase tracking-wider">Terjemahan Target:</span>
                            <p id="builderTargetTranslation" class="text-sm font-bold text-white mt-1">
                                Setiap kata bahasa Inggris memiliki setidaknya satu bunyi vokal.
                            </p>
                        </div>

                        <!-- Assembled Sentence Area (Slots) -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5 text-[11px] text-slate-400">
                                <span>Susunan Kalimatmu (Ketuk kata untuk mengembalikan):</span>
                                <button onclick="clearBuilderSentence()" class="text-rose-400 hover:underline">Hapus Semua</button>
                            </div>
                            <div id="builderAssembledArea" class="min-h-[64px] p-3 rounded-2xl bg-slate-900 border-2 border-dashed border-slate-700 flex flex-wrap gap-1.5 items-center justify-center transition-all">
                                <span id="builderPlaceholder" class="text-xs text-slate-500 italic">Ketuk kata-kata di bawah sesuai urutan yang tepat</span>
                            </div>
                        </div>

                        <!-- Available Chips Palette -->
                        <div>
                            <div class="text-[11px] text-slate-400 text-left mb-1.5 font-medium">Pilihan Kata:</div>
                            <div id="builderChipsPalette" class="flex flex-wrap gap-1.5 justify-center">
                                <!-- Populated dynamically -->
                            </div>
                        </div>

                        <!-- Builder Feedback -->
                        <div id="builderFeedbackBox" class="hidden p-3 rounded-2xl text-xs font-bold transition-all">
                            <span id="builderFeedbackText"></span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 pt-1">
                            <button onclick="checkBuilderSentence()" id="btnCheckBuilder" class="flex-1 py-3 px-4 rounded-2xl bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-extrabold text-xs transition-all shadow-lg shadow-cyan-600/25 active:scale-98">
                                Periksa Susunan (+25 XP)
                            </button>
                            <button onclick="nextBuilderSentence()" class="py-3 px-3 rounded-2xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition-colors">
                                Ganti Kalimat ➜
                            </button>
                        </div>
                    </div>
                </div>

                <!-- SUBMODE 3: LISTENING QUIZ (DENGAR & TEBAK) -->
                <div id="quizContainer-listening" class="hidden space-y-4">
                    <div class="p-5 rounded-3xl bg-slate-800/90 border border-violet-500/30 shadow-xl space-y-4 text-center">
                        <div class="flex items-center justify-between text-xs text-slate-400">
                            <span class="font-bold text-violet-400 uppercase tracking-wider">Tes Pendengaran (Listening)</span>
                            <span>Soal <strong id="listeningCurrentNo" class="text-white">1</strong>/10</span>
                        </div>

                        <div class="py-4 space-y-3">
                            <span class="text-xs text-slate-300">Dengarkan audio penutur, lalu pilih kata yang kamu dengar:</span>
                            <div class="flex flex-col items-center justify-center gap-2">
                                <button onclick="playListeningAudio()" class="w-20 h-20 rounded-full bg-gradient-to-tr from-violet-600 to-indigo-600 hover:from-violet-500 hover:to-indigo-500 text-white text-3xl flex items-center justify-center shadow-xl shadow-violet-500/30 active:scale-95 transition-all">
                                    🔊
                                </button>
                                <span class="text-[11px] text-violet-300 font-semibold">Ketuk untuk Memutar Suara</span>
                            </div>
                        </div>

                        <!-- 4 Options for Listening -->
                        <div id="listeningOptionsContainer" class="grid grid-cols-2 gap-2 pt-1">
                            <!-- Populated dynamically -->
                        </div>

                        <!-- Feedback Banner -->
                        <div id="listeningFeedbackBox" class="hidden p-3 rounded-2xl text-xs font-bold transition-all">
                            <span id="listeningFeedbackText"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: STUDIO PELAFALAN (PRONUNCIATION & SPEECH RECOGNITION) -->
            <div id="view-pronounce" class="hidden space-y-4 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <button onclick="switchTab('learn')" class="text-xs text-indigo-400 flex items-center gap-1 hover:underline font-semibold">
                        <span>← Kembali</span>
                    </button>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">🎙️ AI Speech Studio</span>
                </div>

                <!-- Pronunciation Target Card -->
                <div class="p-5 rounded-3xl bg-gradient-to-b from-slate-800 to-slate-900 border border-emerald-500/30 shadow-2xl text-center space-y-3">
                    <div class="flex items-center justify-between text-[11px] text-slate-400">
                        <span class="font-bold text-emerald-400 uppercase tracking-wider">Target Pengucapan</span>
                        <button onclick="pickRandomStudioWord()" class="text-indigo-400 hover:underline flex items-center gap-1">
                            <span>🎲</span> Kata Lain
                        </button>
                    </div>

                    <div class="py-2">
                        <h2 id="studioWordText" class="text-3xl font-extrabold text-white tracking-tight">Pronounce</h2>
                        <p id="studioPhoneticText" class="text-sm font-mono text-emerald-300 mt-1">/prəˈnaʊns/</p>
                        <p id="studioTranslationText" class="text-xs text-slate-400 mt-1 italic">Mengucapkan / Melafalkan</p>
                    </div>

                    <!-- Audio Listen Buttons -->
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="speakWord(currentStudioWord, 1.0)" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold border border-slate-700 flex items-center gap-1.5 transition-all">
                            <span>🔊</span> Normal (1.0x)
                        </button>
                        <button onclick="speakWord(currentStudioWord, 0.65)" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold border border-slate-700 flex items-center gap-1.5 transition-all">
                            <span>🐢</span> Pelan (0.65x)
                        </button>
                    </div>

                    <!-- Pronunciation Guidance Tip -->
                    <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/80 text-left">
                        <div class="text-[11px] font-bold text-amber-400 flex items-center gap-1">
                            <span>💡</span> Tips Cara Mengucapkan:
                        </div>
                        <p id="studioTipText" class="text-xs text-slate-300 mt-1 leading-snug">
                            Ingat berbunyi 'pra-NAUNS', bukan pro-nounce. Tekankan suku kata kedua.
                        </p>
                    </div>

                    <!-- Microphone & Voice Wave Area -->
                    <div class="pt-2 flex flex-col items-center justify-center">
                        
                        <!-- Soundwave visualization bars -->
                        <div id="soundWaveBars" class="flex items-center justify-center gap-1.5 h-10 mb-2 opacity-30 transition-opacity">
                            <span class="w-1.5 bg-emerald-400 rounded-full h-2 animate-wave-1"></span>
                            <span class="w-1.5 bg-teal-400 rounded-full h-3 animate-wave-2"></span>
                            <span class="w-1.5 bg-indigo-400 rounded-full h-5 animate-wave-3"></span>
                            <span class="w-1.5 bg-purple-400 rounded-full h-3 animate-wave-4"></span>
                            <span class="w-1.5 bg-pink-400 rounded-full h-2 animate-wave-5"></span>
                        </div>

                        <!-- Big Record Button -->
                        <button id="recordMicBtn" onclick="toggleMicrophoneRecord()" class="w-20 h-20 rounded-full bg-gradient-to-tr from-emerald-500 via-teal-500 to-indigo-500 hover:from-emerald-400 hover:to-indigo-400 p-[3px] shadow-xl shadow-emerald-500/25 active:scale-95 transition-all">
                            <div id="recordMicInner" class="w-full h-full rounded-full bg-slate-900 flex flex-col items-center justify-center text-white">
                                <span id="recordMicIcon" class="text-2xl">🎙️</span>
                                <span id="recordMicStatus" class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider mt-0.5">Ucapkan</span>
                            </div>
                        </button>
                        <p id="micPromptText" class="text-xs text-slate-400 mt-2">Tekan mikrofon & ucapkan kata dalam bahasa Inggris</p>
                    </div>

                    <!-- Result Scoring Card -->
                    <div id="speechResultCard" class="hidden p-4 rounded-2xl bg-slate-800 border border-slate-700 text-left space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold uppercase text-slate-400">Hasil Evaluasi AI:</span>
                            <span id="speechScoreBadge" class="text-xs font-black px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">95% Match</span>
                        </div>
                        <div class="text-xs">
                            <span class="text-slate-400">Yang terdengar:</span>
                            <span id="speechHeardText" class="font-bold text-white ml-1">"Pronounce"</span>
                        </div>
                        <p id="speechFeedbackTip" class="text-xs text-emerald-300 leading-snug">
                            Luar biasa! Pelafalan sangat fasih dan jelas.
                        </p>
                    </div>
                </div>

                <!-- Speech Simulation / Fallback for browsers without Web Speech Recognition -->
                <div class="p-3 rounded-2xl bg-slate-800/60 border border-slate-700/60 text-xs text-slate-400 space-y-1">
                    <div class="font-semibold text-slate-300 flex items-center gap-1">
                        <span>ℹ️</span> Panduan Mikrofon
                    </div>
                    <p class="text-[11px] leading-relaxed">
                        Jika browser meminta izin mikrofon, pilih <strong>"Allow / Izinkan"</strong>. Anda juga bisa menirukan suara penutur asli secara berulang-ulang untuk melatih otot lidah & aksen (muscle memory).
                    </p>
                </div>
            </div>

            <!-- SECTION 5: ROLEPLAY CONVERSATION SIMULATOR -->
            <div id="view-conversation" class="hidden space-y-4 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-white">Simulator Dialog Sehari-hari</h3>
                        <p class="text-[11px] text-slate-400">Latihan percakapan nyata dua arah</p>
                    </div>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Roleplay AI</span>
                </div>

                <!-- Scenario Selector Pills -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
                    @foreach ($conversations as $index => $convo)
                        <button onclick="selectConversation({{ $convo->id }})" class="convo-pill-btn shrink-0 px-3 py-1.5 rounded-xl text-xs font-bold transition-all border {{ $index === 0 ? 'bg-indigo-600 border-indigo-500 text-white' : 'bg-slate-800 border-slate-700 text-slate-400 hover:text-white' }}" data-id="{{ $convo->id }}">
                            {{ $convo->scenario_tag }}
                        </button>
                    @endforeach
                </div>

                <!-- Active Scenario Header -->
                <div class="p-3 rounded-2xl bg-gradient-to-r from-slate-800 to-indigo-950/60 border border-indigo-500/30">
                    <h4 id="convoTitle" class="text-xs font-extrabold text-white">Memesan Kopi di Cafe London</h4>
                    <p id="convoDesc" class="text-[11px] text-slate-300 mt-0.5 leading-snug">Praktikkan memesan minuman, ukuran cangkir, dan takeaway.</p>
                </div>

                <!-- Chat Dialogue Stream -->
                <div id="chatMessagesStream" class="space-y-3 min-h-[260px] max-h-[380px] overflow-y-auto no-scrollbar p-1">
                    <!-- Dynamic chat dialogue bubbles -->
                </div>

                <!-- User Interactive Reply Controls -->
                <div id="convoReplyBox" class="p-3 rounded-2xl bg-slate-800/90 border border-slate-700 space-y-2">
                    <div class="flex items-center justify-between text-[11px] text-slate-400">
                        <span class="font-bold text-indigo-300">Giliranmu Berbicara (Your Turn):</span>
                        <button onclick="toggleTranslationSpoilers()" class="text-slate-400 hover:text-white underline">
                            Tampilkan Terjemahan
                        </button>
                    </div>
                    <div id="convoOptionButtons" class="space-y-1.5">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </div>

            <!-- SECTION 6: POCKET DICTIONARY (KAMUS SAKU & PENCARIAN) -->
            <div id="view-dictionary" class="hidden space-y-3 transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-white">Kamus Saku & Kosakata Lengkap</h3>
                        <p class="text-[11px] text-slate-400">Cari kata, dengarkan pelafalan & simpan kata favorit</p>
                    </div>
                    <span id="dictWordTotalBadge" class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">
                        {{ count($vocabularies) }} Kata
                    </span>
                </div>

                <!-- Search Input Bar -->
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">🔍</span>
                    <input type="text" id="dictSearchInput" oninput="filterDictionaryWords()" placeholder="Ketik kata Inggris atau arti bahasa Indonesia..." class="w-full pl-9 pr-8 py-2.5 rounded-2xl bg-slate-800 border border-slate-700 focus:border-indigo-500 text-xs text-white placeholder-slate-500 focus:outline-none transition-colors">
                    <button id="dictClearSearchBtn" onclick="clearDictSearch()" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white text-xs">✕</button>
                </div>

                <!-- Filter Chips -->
                <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar pb-1 text-xs">
                    <button onclick="setDictFilter('all')" class="dict-filter-chip shrink-0 px-2.5 py-1 rounded-xl bg-indigo-600 text-white font-bold" data-filter="all">Semua</button>
                    <button onclick="setDictFilter('basic')" class="dict-filter-chip shrink-0 px-2.5 py-1 rounded-xl bg-slate-800 text-slate-400 hover:text-white font-medium" data-filter="basic">Dasar (A1)</button>
                    <button onclick="setDictFilter('daily')" class="dict-filter-chip shrink-0 px-2.5 py-1 rounded-xl bg-slate-800 text-slate-400 hover:text-white font-medium" data-filter="daily">Sehari-hari</button>
                    <button onclick="setDictFilter('advanced')" class="dict-filter-chip shrink-0 px-2.5 py-1 rounded-xl bg-slate-800 text-slate-400 hover:text-white font-medium" data-filter="advanced">Mahir / Idiom</button>
                    <button onclick="setDictFilter('saved')" class="dict-filter-chip shrink-0 px-2.5 py-1 rounded-xl bg-slate-800 text-amber-300 hover:text-amber-200 font-medium" data-filter="saved">⭐ Tersimpan</button>
                </div>

                <!-- Category Select & Result Count -->
                <div class="flex items-center gap-2">
                    <select id="dictCategorySelect" onchange="renderDictionaryList()" class="flex-1 min-w-0 px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 focus:border-indigo-500 text-xs text-slate-200 focus:outline-none">
                        <option value="">Semua Kategori ({{ count($categories) }})</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->icon }} {{ $cat->name }} ({{ $cat->vocabularies_count }})</option>
                        @endforeach
                    </select>
                    <span id="dictResultCount" class="shrink-0 text-[11px] font-semibold text-slate-400"></span>
                </div>

                <!-- Dictionary List Items -->
                <div id="dictWordListContainer" class="space-y-2">
                    <!-- Populated dynamically -->
                </div>

                <button id="dictLoadMoreBtn" onclick="loadMoreDictionaryWords()" class="hidden w-full py-2.5 rounded-2xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-xs font-bold text-indigo-300 transition-colors">
                    Muat lebih banyak
                </button>
            </div>

            <!-- SECTION 7: PROFILE & GAMIFICATION MODAL / VIEW -->
            <div id="view-profile" class="hidden space-y-4 transition-all duration-200">
                <div class="p-5 rounded-3xl bg-gradient-to-br from-indigo-900/60 via-purple-900/40 to-slate-900 border border-indigo-500/30 text-center space-y-3 shadow-xl">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-tr from-indigo-500 to-pink-500 p-1 mx-auto shadow-lg shadow-indigo-500/30">
                        <div class="w-full h-full rounded-full bg-slate-900 flex items-center justify-center text-2xl font-black">
                            👑
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-white">Siswa Bahasa Inggris Aktif</h3>
                        <p class="text-xs text-indigo-300 mt-0.5">Tingkat Kemampuan: <strong id="profileLevelName">Penjelajah Percakapan</strong></p>
                    </div>
                    
                    <div class="grid grid-cols-3 gap-2 pt-2 border-t border-slate-800/80">
                        <div class="p-2 rounded-xl bg-slate-900/80 border border-slate-800">
                            <div class="text-base font-black text-indigo-400" id="profTotalXP">{{ $stats['xp'] }}</div>
                            <div class="text-[10px] text-slate-400">Total XP</div>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-900/80 border border-slate-800">
                            <div class="text-base font-black text-emerald-400" id="profMastered">{{ $stats['mastered_words'] }}</div>
                            <div class="text-[10px] text-slate-400">Kata Hafal</div>
                        </div>
                        <div class="p-2 rounded-xl bg-slate-900/80 border border-slate-800">
                            <div class="text-base font-black text-amber-400" id="profAvgScore">{{ $stats['avg_score'] }}%</div>
                            <div class="text-[10px] text-slate-400">Akurasi Suara</div>
                        </div>
                    </div>
                </div>

                <!-- Badges & Achievements -->
                <div class="space-y-2">
                    <h4 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Lencana Prestasi (Badges)</h4>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/70 flex items-center gap-2.5">
                            <span class="text-2xl">🌱</span>
                            <div>
                                <div class="text-xs font-bold text-white">Langkah Pertama</div>
                                <div class="text-[10px] text-slate-400">Mulai belajar kata dasar</div>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/70 flex items-center gap-2.5">
                            <span class="text-2xl">🎙️</span>
                            <div>
                                <div class="text-xs font-bold text-white">Golden Voice</div>
                                <div class="text-[10px] text-slate-400">Skor suara di atas 90%</div>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/70 flex items-center gap-2.5">
                            <span class="text-2xl">🔥</span>
                            <div>
                                <div class="text-xs font-bold text-white">Rajin Latihan</div>
                                <div class="text-[10px] text-slate-400">Streak belajar 5 hari</div>
                            </div>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/70 flex items-center gap-2.5">
                            <span class="text-2xl">💬</span>
                            <div>
                                <div class="text-xs font-bold text-white">Ahli Dialog</div>
                                <div class="text-[10px] text-slate-400">Tuntaskan skenario cafe</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- App Info & Reset -->
                <div class="p-3 rounded-2xl bg-slate-800/40 border border-slate-700/50 space-y-2 text-xs">
                    <div class="flex items-center justify-between text-slate-400">
                        <span>Database Kosakata</span>
                        <strong class="text-slate-200">{{ count($vocabularies) }} kata & frasa</strong>
                    </div>
                    <div class="flex items-center justify-between text-slate-400">
                        <span>Simulator Dialog</span>
                        <strong class="text-slate-200">{{ count($conversations) }} skenario interaktif</strong>
                    </div>
                    <div class="pt-2 border-t border-slate-700/60 flex items-center justify-between">
                        <button onclick="resetLearningProgress()" class="text-[11px] text-rose-400 hover:text-rose-300 underline">
                            Reset Riwayat Latihan
                        </button>
                        <span class="text-[11px] text-slate-500">EnglisHub Mobile v2.0</span>
                    </div>
                </div>
            </div>

        </main>

        <!-- FLOATING BOTTOM NAVIGATION BAR (iOS / Android Style) -->
        <nav class="absolute bottom-0 left-0 right-0 h-16 bg-slate-900/95 backdrop-blur-lg border-t border-slate-800/90 px-2 flex items-center justify-around z-30 select-none">
            <button onclick="switchTab('learn')" id="tabNav-learn" class="bottom-tab-btn active flex-1 flex flex-col items-center justify-center py-1 text-indigo-400 transition-colors">
                <span class="text-lg">📚</span>
                <span class="text-[11px] font-bold mt-0.5">Belajar</span>
            </button>
            <button onclick="switchTab('flashcard')" id="tabNav-flashcard" class="bottom-tab-btn flex-1 flex flex-col items-center justify-center py-1 text-slate-400 hover:text-slate-200 transition-colors">
                <span class="text-lg">🗂️</span>
                <span class="text-[11px] font-bold mt-0.5">Flashcard</span>
            </button>
            <button onclick="switchTab('quiz')" id="tabNav-quiz" class="bottom-tab-btn flex-1 flex flex-col items-center justify-center py-1 text-slate-400 hover:text-slate-200 transition-colors">
                <span class="text-lg">🎯</span>
                <span class="text-[11px] font-bold mt-0.5">Kuis</span>
            </button>
            <button onclick="switchTab('pronounce')" id="tabNav-pronounce" class="bottom-tab-btn flex-1 flex flex-col items-center justify-center py-1 text-slate-400 hover:text-slate-200 transition-colors">
                <span class="text-lg">🎙️</span>
                <span class="text-[11px] font-bold mt-0.5">Suara</span>
            </button>
            <button onclick="switchTab('conversation')" id="tabNav-conversation" class="bottom-tab-btn flex-1 flex flex-col items-center justify-center py-1 text-slate-400 hover:text-slate-200 transition-colors">
                <span class="text-lg">💬</span>
                <span class="text-[11px] font-bold mt-0.5">Dialog</span>
            </button>
            <button onclick="switchTab('dictionary')" id="tabNav-dictionary" class="bottom-tab-btn flex-1 flex flex-col items-center justify-center py-1 text-slate-400 hover:text-slate-200 transition-colors">
                <span class="text-lg">📖</span>
                <span class="text-[11px] font-bold mt-0.5">Kamus</span>
            </button>
            <button onclick="switchTab('profile')" id="tabNav-profile" class="bottom-tab-btn flex-1 flex flex-col items-center justify-center py-1 text-slate-400 hover:text-slate-200 transition-colors">
                <span class="text-lg">👤</span>
                <span class="text-[11px] font-bold mt-0.5">Profil</span>
            </button>
        </nav>

    </div>

    <!-- AUDIO SETTINGS MODAL -->
    <div id="audioSettingsModal" class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="w-full max-w-sm rounded-3xl bg-slate-900 border border-slate-700 p-5 space-y-4 shadow-2xl">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-white flex items-center gap-1.5">
                    <span>🔊</span> Pengaturan Suara & Pelafalan
                </h3>
                <button onclick="toggleAudioSettingsModal()" class="text-slate-400 hover:text-white text-xs">✕</button>
            </div>
            
            <div class="space-y-3 text-xs">
                <div class="flex items-center justify-between">
                    <span>Efek Suara UI (Chimes & Bell)</span>
                    <input type="checkbox" id="soundFxToggle" checked onchange="toggleSoundFx(this.checked)" class="w-4 h-4 rounded text-indigo-600">
                </div>
                <div class="flex items-center justify-between">
                    <span>Aksen Suara Penutur</span>
                    <select id="voiceAccentSelect" onchange="changeVoiceAccent(this.value)" class="bg-slate-800 border border-slate-700 text-xs rounded-xl px-2 py-1 text-white">
                        <option value="en-US">US (American English)</option>
                        <option value="en-GB">UK (British English)</option>
                        <option value="en-AU">AU (Australian)</option>
                    </select>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <span>Kecepatan Standar Audio</span>
                        <span id="speechRateLabel" class="text-indigo-400 font-bold">1.0x</span>
                    </div>
                    <input type="range" id="speechRateRange" min="0.5" max="1.5" step="0.1" value="1.0" oninput="changeSpeechRate(this.value)" class="w-full accent-indigo-500">
                </div>
            </div>

            <button onclick="toggleAudioSettingsModal()" class="w-full py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs transition-colors">
                Simpan & Tutup
            </button>
        </div>
    </div>

    <!-- GRAMMAR & SENTENCE PATTERNS MODAL -->
    <div id="grammarGuideModal" class="hidden fixed inset-0 z-50 bg-slate-950/85 backdrop-blur-md flex items-center justify-center p-3 md:p-4">
        <div class="w-full max-w-md max-h-[85vh] rounded-3xl bg-slate-900 border border-slate-700 flex flex-col shadow-2xl overflow-hidden">
            <!-- Modal Header -->
            <div class="px-5 py-3.5 border-b border-slate-800 flex items-center justify-between bg-slate-900/90">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📘</span>
                    <div>
                        <h3 class="text-xs font-bold text-white">Panduan Pola Kalimat & Tata Bahasa</h3>
                        <p class="text-[11px] text-slate-400">Fondasi utama berbicara & merangkai kalimat</p>
                    </div>
                </div>
                <button onclick="closeGrammarModal()" class="w-7 h-7 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center text-xs">✕</button>
            </div>

            <!-- Grammar Subtabs -->
            <div class="flex gap-1 p-2 bg-slate-950/60 border-b border-slate-800 overflow-x-auto no-scrollbar">
                <button onclick="switchGrammarTab('svo')" id="gTabBtn-svo" class="g-tab-btn active shrink-0 px-2.5 py-1 rounded-xl text-[11px] font-bold bg-indigo-600 text-white">Pola S-V-O</button>
                <button onclick="switchGrammarTab('tenses')" id="gTabBtn-tenses" class="g-tab-btn shrink-0 px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-400 hover:text-white">4 Tenses Kunci</button>
                <button onclick="switchGrammarTab('tobe')" id="gTabBtn-tobe" class="g-tab-btn shrink-0 px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-400 hover:text-white">To Be & Pronoun</button>
                <button onclick="switchGrammarTab('dodoes')" id="gTabBtn-dodoes" class="g-tab-btn shrink-0 px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-400 hover:text-white">Do / Does / Did</button>
                <button onclick="switchGrammarTab('aan')" id="gTabBtn-aan" class="g-tab-btn shrink-0 px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-400 hover:text-white">A vs An & Modal</button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div class="p-4 overflow-y-auto space-y-3.5 text-xs text-slate-300 leading-relaxed no-scrollbar flex-1">
                <!-- Section 1: SVO -->
                <div id="gSec-svo" class="space-y-2.5">
                    <div class="p-3 rounded-2xl bg-indigo-950/40 border border-indigo-500/30">
                        <span class="text-[11px] font-extrabold text-indigo-400 uppercase tracking-wider">Rumus Inti:</span>
                        <div class="text-sm font-extrabold text-white mt-0.5">Subject + Verb + Object (+ Complement)</div>
                        <p class="text-xs text-slate-300 mt-1">Dalam bahasa Inggris, urutan kata tidak boleh tertukar. Subjek (pelaku) berada di depan, diikuti kata kerja (aktivitas), lalu objek penerima.</p>
                    </div>
                    <div class="space-y-1.5">
                        <div class="text-xs font-bold text-slate-200">Contoh Praktis Sehari-hari:</div>
                        <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-white text-xs">"I (S) drink (V) fresh coffee (O) every morning."</div>
                                <div class="text-[11px] text-slate-400 italic">Saya minum kopi segar setiap pagi.</div>
                            </div>
                            <button onclick="speakWord('I drink fresh coffee every morning')" class="p-1 rounded-lg bg-indigo-500/20 text-indigo-300 hover:bg-indigo-500/40 text-xs">🔊</button>
                        </div>
                        <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-white text-xs">"They (S) booked (V) a hotel room (O) yesterday."</div>
                                <div class="text-[11px] text-slate-400 italic">Mereka memesan kamar hotel kemarin.</div>
                            </div>
                            <button onclick="speakWord('They booked a hotel room yesterday')" class="p-1 rounded-lg bg-indigo-500/20 text-indigo-300 hover:bg-indigo-500/40 text-xs">🔊</button>
                        </div>
                    </div>
                </div>

                <!-- Section 2: 4 Tenses -->
                <div id="gSec-tenses" class="hidden space-y-2.5">
                    <div class="p-3 rounded-2xl bg-amber-500/10 border border-amber-500/30">
                        <span class="text-[11px] font-bold text-amber-400">1. Simple Present Tense (Kebiasaan / Fakta)</span>
                        <div class="font-mono text-xs text-white font-bold mt-0.5">S + V1 (tambah -s/-es untuk He/She/It)</div>
                        <p class="text-[11px] text-slate-300 mt-1">"She works at an international airport."</p>
                        <button onclick="speakWord('She works at an international airport')" class="text-[11px] text-amber-300 font-semibold mt-1">🔊 Dengarkan</button>
                    </div>
                    <div class="p-3 rounded-2xl bg-emerald-500/10 border border-emerald-500/30">
                        <span class="text-[11px] font-bold text-emerald-400">2. Present Continuous (Sedang Terjadi Saat Ini)</span>
                        <div class="font-mono text-xs text-white font-bold mt-0.5">S + is/am/are + V-ing</div>
                        <p class="text-[11px] text-slate-300 mt-1">"We are learning English together right now."</p>
                        <button onclick="speakWord('We are learning English together right now')" class="text-[11px] text-emerald-300 font-semibold mt-1">🔊 Dengarkan</button>
                    </div>
                    <div class="p-3 rounded-2xl bg-sky-500/10 border border-sky-500/30">
                        <span class="text-[11px] font-bold text-sky-400">3. Simple Past Tense (Kejadian Lampau Selesai)</span>
                        <div class="font-mono text-xs text-white font-bold mt-0.5">S + V2 (Kata Kerja Lampau)</div>
                        <p class="text-[11px] text-slate-300 mt-1">"He arrived at the hotel two hours ago."</p>
                        <button onclick="speakWord('He arrived at the hotel two hours ago')" class="text-[11px] text-sky-300 font-semibold mt-1">🔊 Dengarkan</button>
                    </div>
                    <div class="p-3 rounded-2xl bg-fuchsia-500/10 border border-fuchsia-500/30">
                        <span class="text-[11px] font-bold text-fuchsia-400">4. Simple Future Tense (Rencana Masa Depan)</span>
                        <div class="font-mono text-xs text-white font-bold mt-0.5">S + will + V1 (atau be going to)</div>
                        <p class="text-[11px] text-slate-300 mt-1">"I will send the project deliverables by tomorrow."</p>
                        <button onclick="speakWord('I will send the project deliverables by tomorrow')" class="text-[11px] text-fuchsia-300 font-semibold mt-1">🔊 Dengarkan</button>
                    </div>
                </div>

                <!-- Section 3: To Be & Pronoun -->
                <div id="gSec-tobe" class="hidden space-y-2.5">
                    <div class="text-xs text-slate-300">Gunakan <strong>To Be</strong> bila kalimat TIDAK memiliki kata kerja aksi (menjelaskan profesi, sifat, lokasi, atau kondisi).</div>
                    <div class="overflow-hidden rounded-2xl border border-slate-700/80">
                        <table class="w-full text-left text-xs">
                            <thead class="bg-slate-800 text-slate-300 border-b border-slate-700">
                                <tr>
                                    <th class="p-2 font-bold">Subjek</th>
                                    <th class="p-2 font-bold">Sekarang</th>
                                    <th class="p-2 font-bold">Lampau</th>
                                    <th class="p-2 font-bold">Contoh</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800">
                                <tr>
                                    <td class="p-2 font-bold text-indigo-400">I</td>
                                    <td class="p-2 text-white">am</td>
                                    <td class="p-2 text-slate-400">was</td>
                                    <td class="p-2 text-slate-300">I am ready</td>
                                </tr>
                                <tr>
                                    <td class="p-2 font-bold text-indigo-400">You / We / They</td>
                                    <td class="p-2 text-white">are</td>
                                    <td class="p-2 text-slate-400">were</td>
                                    <td class="p-2 text-slate-300">They are punctual</td>
                                </tr>
                                <tr>
                                    <td class="p-2 font-bold text-indigo-400">He / She / It</td>
                                    <td class="p-2 text-white">is</td>
                                    <td class="p-2 text-slate-400">was</td>
                                    <td class="p-2 text-slate-300">She is kind</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Section 4: Do / Does / Did -->
                <div id="gSec-dodoes" class="hidden space-y-2.5">
                    <div class="p-3 rounded-2xl bg-slate-800/90 border border-slate-700">
                        <div class="font-bold text-white text-xs">Untuk Kalimat Tanya & Negatif:</div>
                        <ul class="list-disc list-inside space-y-1.5 mt-2 text-[11px] text-slate-300">
                            <li><strong>DO:</strong> Digunakan untuk subjek <em>I, You, We, They</em> pada masa sekarang.
                                <br><span class="text-indigo-300 italic pl-3">"Do you speak English?" / "I do not know."</span>
                            </li>
                            <li><strong>DOES:</strong> Digunakan untuk subjek <em>He, She, It</em> pada masa sekarang (kata kerja kembali ke bentuk dasar tanpa -s).
                                <br><span class="text-indigo-300 italic pl-3">"Does he live in London?" / "She does not eat meat."</span>
                            </li>
                            <li><strong>DID:</strong> Digunakan untuk SEMUA subjek pada masa lampau.
                                <br><span class="text-indigo-300 italic pl-3">"Did you receive the email yesterday?"</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Section 5: A vs An & Modal Verbs -->
                <div id="gSec-aan" class="hidden space-y-2.5">
                    <div class="p-3 rounded-2xl bg-slate-800/90 border border-slate-700">
                        <div class="font-bold text-white text-xs">Kunci Pemakaian "A" vs "An":</div>
                        <p class="text-[11px] text-slate-300 mt-1">Dilihat dari <strong>BUNYI suara awal</strong>, bukan huruf ejaannya!</p>
                        <div class="grid grid-cols-2 gap-2 mt-2 text-[11px]">
                            <div class="p-2 rounded-xl bg-slate-900 border border-slate-800">
                                <span class="font-bold text-emerald-400">Pakai "AN" (Bunyi Vokal):</span>
                                <div class="mt-1 space-y-0.5 text-slate-300">
                                    <div>• An apple</div>
                                    <div>• An hour <em>(huruf h bisu)</em></div>
                                    <div>• An emergency</div>
                                </div>
                            </div>
                            <div class="p-2 rounded-xl bg-slate-900 border border-slate-800">
                                <span class="font-bold text-sky-400">Pakai "A" (Bunyi Konsonan):</span>
                                <div class="mt-1 space-y-0.5 text-slate-300">
                                    <div>• A book</div>
                                    <div>• A university <em>(bunyi /juː/)</em></div>
                                    <div>• A one-way ticket</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 rounded-2xl bg-indigo-950/40 border border-indigo-500/30">
                        <div class="font-bold text-white text-xs">Modal Verbs (Can, Would, Should, Must):</div>
                        <p class="text-[11px] text-slate-300 mt-1">Setelah modal verb, kata kerja <strong>SELALU kembali ke bentuk V1 asli tanpa imbuhan</strong> (-ing/-ed/-s dilarang).</p>
                        <div class="mt-1.5 text-[11px] text-indigo-300">
                            <div>• "Could I <strong>get</strong> the check, please?" (Bukan got/gets)</div>
                            <div>• "You should <strong>listen</strong> carefully."</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Close -->
            <div class="p-3 bg-slate-900 border-t border-slate-800">
                <button onclick="closeGrammarModal()" class="w-full py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs transition-colors">
                    Tutup Panduan & Lanjut Belajar
                </button>
            </div>
        </div>
    </div>

    <!-- EMBEDDED INITIAL STATE DATA FROM LARAVEL -->
    <script>
        window.ENGLISHUB_DATA = {
            categories: @json($categories),
            vocabularies: @json($vocabularies),
            conversations: @json($conversations),
            userRecords: @json($userRecords),
            stats: @json($stats),
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    </script>

    <!-- MAIN CLIENT APPLICATION LOGIC -->
    <script>
        // Global State
        let currentTab = 'learn';
        let currentLevel = 'beginner';
        let isSlowAudioMode = false;
        let isSoundFxEnabled = true;
        let preferredSpeechRate = 1.0;
        let preferredVoiceLang = 'en-US';

        // Flashcards state
        let activeFlashcards = [];
        let flashcardIndex = 0;
        let isCardFlipped = false;
        let currentFlashcardWord = '';
        let currentFlashcardExample = '';

        // Quiz state
        let quizQuestions = [];
        let quizIndex = 0;
        let quizStreak = 0;
        let quizLives = 3;
        let quizTargetWord = '';

        // Pronunciation Studio state
        let currentStudioWord = '';
        let isRecordingMic = false;
        let speechRecognitionInstance = null;

        // Conversation state
        let activeConversation = null;
        let currentDialogueStep = 0;
        let showTranslationSpoilers = false;

        // Dictionary state
        let activeDictFilter = 'all';
        let bookmarkedWordIds = JSON.parse(localStorage.getItem('englishub_bookmarks') || '[]');

        // Initialize Audio Synthesizer (Zero-dependency Web Audio API)
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();

        function playSyntheticTone(type) {
            if (!isSoundFxEnabled) return;
            try {
                if (audioCtx.state === 'suspended') {
                    audioCtx.resume();
                }
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.connect(gain);
                gain.connect(audioCtx.destination);

                const now = audioCtx.currentTime;

                if (type === 'correct') {
                    // Upward pleasant arpeggio
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(523.25, now); // C5
                    osc.frequency.exponentialRampToValueAtTime(659.25, now + 0.1); // E5
                    osc.frequency.exponentialRampToValueAtTime(783.99, now + 0.2); // G5
                    gain.gain.setValueAtTime(0.15, now);
                    gain.gain.exponentialRampToValueAtTime(0.01, now + 0.35);
                    osc.start(now);
                    osc.stop(now + 0.35);
                } else if (type === 'incorrect') {
                    // Soft low buzz
                    osc.type = 'sawtooth';
                    osc.frequency.setValueAtTime(180, now);
                    osc.frequency.linearRampToValueAtTime(110, now + 0.25);
                    gain.gain.setValueAtTime(0.12, now);
                    gain.gain.exponentialRampToValueAtTime(0.01, now + 0.25);
                    osc.start(now);
                    osc.stop(now + 0.25);
                } else if (type === 'flip') {
                    // Subtle airy whoosh
                    osc.type = 'triangle';
                    osc.frequency.setValueAtTime(400, now);
                    osc.frequency.exponentialRampToValueAtTime(200, now + 0.1);
                    gain.gain.setValueAtTime(0.08, now);
                    gain.gain.exponentialRampToValueAtTime(0.01, now + 0.12);
                    osc.start(now);
                    osc.stop(now + 0.12);
                } else if (type === 'mic') {
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(880, now);
                    gain.gain.setValueAtTime(0.1, now);
                    gain.gain.exponentialRampToValueAtTime(0.01, now + 0.1);
                    osc.start(now);
                    osc.stop(now + 0.1);
                }
            } catch (e) {
                console.warn('Audio tone err:', e);
            }
        }

        // Web Speech Synthesis (TTS Audio Player)
        function speakWord(text, customRate = null) {
            if (!('speechSynthesis' in window)) {
                alert('Browser Anda tidak mendukung pemutar suara Web Speech API.');
                return;
            }
            window.speechSynthesis.cancel();

            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = preferredVoiceLang;

            if (customRate !== null) {
                utterance.rate = customRate;
            } else if (isSlowAudioMode) {
                utterance.rate = 0.65;
            } else {
                utterance.rate = preferredSpeechRate;
            }

            // Pick English voice if available
            const voices = window.speechSynthesis.getVoices();
            const engVoice = voices.find(v => v.lang.startsWith('en'));
            if (engVoice) {
                utterance.voice = engVoice;
            }

            window.speechSynthesis.speak(utterance);
        }

        // Speech Recognition Setup (Microphone Voice Lab)
        function initSpeechRecognition() {
            const SpeechRec = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRec) {
                return null;
            }
            const rec = new SpeechRec();
            rec.continuous = false;
            rec.interimResults = false;
            rec.lang = 'en-US';

            rec.onstart = function() {
                isRecordingMic = true;
                playSyntheticTone('mic');
                document.getElementById('soundWaveBars').classList.remove('opacity-30');
                document.getElementById('recordMicStatus').innerText = 'Mendengar...';
                document.getElementById('recordMicStatus').classList.remove('text-emerald-400');
                document.getElementById('recordMicStatus').classList.add('text-rose-400');
                document.getElementById('micPromptText').innerText = 'Silakan ucapkan kata dengan jelas sekarang...';
            };

            rec.onresult = function(event) {
                const transcript = event.results[0][0].transcript;
                processSpokenText(transcript);
            };

            rec.onerror = function(event) {
                console.warn('Speech rec error:', event.error);
                stopMicrophoneRecordUI();
                document.getElementById('micPromptText').innerText = 'Tidak terdengar suara atau izin mikrofon belum aktif. Coba lagi.';
            };

            rec.onend = function() {
                stopMicrophoneRecordUI();
            };

            return rec;
        }

        function toggleMicrophoneRecord() {
            if (!speechRecognitionInstance) {
                speechRecognitionInstance = initSpeechRecognition();
            }

            if (!speechRecognitionInstance) {
                // If browser does not support SpeechRecognition, provide simulated practice
                const mockInput = prompt('Browser tidak mendukung SpeechRecognition secara native. Ketik kata yang Anda ucapkan untuk simulasi evaluasi:', currentStudioWord);
                if (mockInput) {
                    processSpokenText(mockInput);
                }
                return;
            }

            if (isRecordingMic) {
                speechRecognitionInstance.stop();
            } else {
                try {
                    speechRecognitionInstance.start();
                } catch (e) {
                    speechRecognitionInstance.stop();
                    setTimeout(() => speechRecognitionInstance.start(), 200);
                }
            }
        }

        function stopMicrophoneRecordUI() {
            isRecordingMic = false;
            document.getElementById('soundWaveBars').classList.add('opacity-30');
            document.getElementById('recordMicStatus').innerText = 'Ucapkan';
            document.getElementById('recordMicStatus').classList.remove('text-rose-400');
            document.getElementById('recordMicStatus').classList.add('text-emerald-400');
            document.getElementById('micPromptText').innerText = 'Tekan mikrofon & ucapkan kata dalam bahasa Inggris';
        }

        function calculateMatchScore(target, spoken) {
            const cleanTarget = target.toLowerCase().trim().replace(/[^a-z0-9 ]/g, '');
            const cleanSpoken = spoken.toLowerCase().trim().replace(/[^a-z0-9 ]/g, '');

            if (cleanTarget === cleanSpoken) return 100;
            if (cleanSpoken.includes(cleanTarget) || cleanTarget.includes(cleanSpoken)) return 92;

            // Levenshtein distance
            const track = Array(cleanSpoken.length + 1).fill(null).map(() =>
                Array(cleanTarget.length + 1).fill(null));
            for (let i = 0; i <= cleanSpoken.length; i += 1) track[i][0] = i;
            for (let j = 0; j <= cleanTarget.length; j += 1) track[0][j] = j;
            for (let i = 1; i <= cleanSpoken.length; i += 1) {
                for (let j = 1; j <= cleanTarget.length; j += 1) {
                    const indicator = cleanSpoken[i - 1] === cleanTarget[j - 1] ? 0 : 1;
                    track[i][j] = Math.min(
                        track[i - 1][j] + 1,
                        track[i][j - 1] + 1,
                        track[i - 1][j - 1] + indicator,
                    );
                }
            }
            const distance = track[cleanSpoken.length][cleanTarget.length];
            const maxLen = Math.max(cleanTarget.length, cleanSpoken.length);
            const score = Math.max(0, Math.round(((maxLen - distance) / maxLen) * 100));
            return score;
        }

        function processSpokenText(spokenText) {
            const score = calculateMatchScore(currentStudioWord, spokenText);

            const resultCard = document.getElementById('speechResultCard');
            const scoreBadge = document.getElementById('speechScoreBadge');
            const heardText = document.getElementById('speechHeardText');
            const feedbackTip = document.getElementById('speechFeedbackTip');

            resultCard.classList.remove('hidden');
            heardText.innerText = `"${spokenText}"`;
            scoreBadge.innerText = `${score}% Match`;

            if (score >= 90) {
                playSyntheticTone('correct');
                scoreBadge.className = 'text-xs font-black px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30';
                feedbackTip.innerText = '🌟 Luar biasa! Pelafalan sangat fasih, intonasi & vokal sangat tepat!';
                confetti({ particleCount: 35, spread: 60, origin: { y: 0.6 } });
            } else if (score >= 70) {
                playSyntheticTone('correct');
                scoreBadge.className = 'text-xs font-black px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30';
                feedbackTip.innerText = '👍 Bagus sekali! Sudah mendekati benar. Perhatikan penekanan suku kata.';
            } else {
                playSyntheticTone('incorrect');
                scoreBadge.className = 'text-xs font-black px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 border border-rose-500/30';
                feedbackTip.innerText = '👂 Coba dengarkan lagi tombol normal/pelan, lalu ulangi secara perlahan.';
            }

            // Sync with backend
            const activeWordObj = window.ENGLISHUB_DATA.vocabularies.find(v => v.word.toLowerCase() === currentStudioWord.toLowerCase());
            if (activeWordObj) {
                saveLearningProgress(activeWordObj.id, score >= 85, score);
            }
        }

        // Live Clock
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const clockEl = document.getElementById('liveClock');
            if (clockEl) clockEl.innerText = `${hours}:${minutes}`;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // TAB SWITCHING
        function switchTab(tabName) {
            currentTab = tabName;
            const views = ['learn', 'flashcard', 'quiz', 'pronounce', 'conversation', 'dictionary', 'profile'];
            views.forEach(v => {
                const el = document.getElementById(`view-${v}`);
                if (el) el.classList.add('hidden');
                const btn = document.getElementById(`tabNav-${v}`);
                if (btn) {
                    btn.classList.remove('active', 'text-indigo-400');
                    btn.classList.add('text-slate-400');
                }
            });

            const activeView = document.getElementById(`view-${tabName}`);
            if (activeView) activeView.classList.remove('hidden');

            const activeBtn = document.getElementById(`tabNav-${tabName}`);
            if (activeBtn) {
                activeBtn.classList.add('active', 'text-indigo-400');
                activeBtn.classList.remove('text-slate-400');
            }

            // Scroll top
            document.getElementById('mainScrollArea').scrollTop = 0;

            // Initialize views on switch
            if (tabName === 'flashcard') {
                if (activeFlashcards.length === 0) {
                    activeFlashcards = window.ENGLISHUB_DATA.vocabularies;
                    flashcardIndex = 0;
                }
                renderFlashcard();
            } else if (tabName === 'quiz') {
                startQuizMode();
            } else if (tabName === 'pronounce') {
                if (!currentStudioWord) {
                    pickRandomStudioWord();
                }
            } else if (tabName === 'conversation') {
                if (!activeConversation && window.ENGLISHUB_DATA.conversations.length > 0) {
                    selectConversation(window.ENGLISHUB_DATA.conversations[0].id);
                }
            } else if (tabName === 'dictionary') {
                renderDictionaryList();
            }
        }

        // LEVEL FILTERING (Dasar A1 -> Sehari-hari -> Mahir)
        function filterCurriculum(level) {
            currentLevel = level;
            const buttons = ['beginner', 'daily', 'advanced'];
            buttons.forEach(lvl => {
                const btn = document.getElementById(`btnLevel-${lvl}`);
                if (lvl === level) {
                    btn.className = 'level-tab-btn active py-2 rounded-xl text-xs font-bold transition-all text-center flex flex-col items-center gap-0.5 bg-indigo-600 text-white shadow-md';
                } else {
                    btn.className = 'level-tab-btn py-2 rounded-xl text-xs font-bold transition-all text-center flex flex-col items-center gap-0.5 text-slate-400 hover:text-slate-200';
                }
            });

            applyCategoryFilters();

            const levelNames = {
                beginner: 'Lv.1 Dasar (A1)',
                daily: 'Lv.2 Sehari-hari (A2-B1)',
                advanced: 'Lv.3 Mahir / Kerja (B2-C1)'
            };
            document.getElementById('headerLevelTag').innerText = levelNames[level] || 'Level Belajar';
        }

        function applyCategoryFilters() {
            const search = (document.getElementById('categorySearchInput')?.value || '').toLowerCase().trim();
            let visibleCount = 0;

            document.querySelectorAll('.category-card').forEach(card => {
                const matchesLevel = search.length > 0 || card.getAttribute('data-level') === currentLevel;
                const matchesSearch = search.length === 0 || card.getAttribute('data-name').includes(search);
                const isVisible = matchesLevel && matchesSearch;
                card.style.display = isVisible ? 'block' : 'none';
                if (isVisible) visibleCount++;
            });

            document.getElementById('categoryCountBadge').innerText = search.length > 0
                ? `${visibleCount} topik ditemukan`
                : `${visibleCount} Modul Sesuai Level`;
            document.getElementById('categoryEmptyState').classList.toggle('hidden', visibleCount > 0);
        }

        function updateCategoryProgress() {
            const records = window.ENGLISHUB_DATA.userRecords || {};
            const masteredByCategory = {};

            window.ENGLISHUB_DATA.vocabularies.forEach(v => {
                if (records[v.id] && records[v.id].is_mastered) {
                    masteredByCategory[v.category_id] = (masteredByCategory[v.category_id] || 0) + 1;
                }
            });

            window.ENGLISHUB_DATA.categories.forEach(cat => {
                const card = document.querySelector(`.category-card[data-category-id="${cat.id}"]`);
                if (!card) return;
                const mastered = masteredByCategory[cat.id] || 0;
                const total = cat.vocabularies_count || 0;
                card.querySelector('.category-progress-bar').style.width = `${total ? Math.round((mastered / total) * 100) : 0}%`;
                card.querySelector('.category-progress-label').innerText = `${mastered}/${total}`;
            });
        }

        // QUICK MODE LAUNCHER
        function launchQuickMode(mode) {
            if (mode === 'flashcard') {
                const wordsInLevel = window.ENGLISHUB_DATA.vocabularies.filter(v => v.category?.level === currentLevel);
                activeFlashcards = wordsInLevel.length > 0 ? wordsInLevel : window.ENGLISHUB_DATA.vocabularies;
                flashcardIndex = 0;
                switchTab('flashcard');
            } else if (mode === 'quiz') {
                switchTab('quiz');
                setQuizSubMode('mcq');
            } else if (mode === 'builder') {
                switchTab('quiz');
                setQuizSubMode('builder');
            } else if (mode === 'pronounce') {
                switchTab('pronounce');
                pickRandomStudioWord();
            }
        }

        function openCategoryStudy(categoryId, mode) {
            const cat = window.ENGLISHUB_DATA.categories.find(c => c.id === categoryId);
            const filteredWords = window.ENGLISHUB_DATA.vocabularies.filter(v => v.category_id === categoryId);

            if (mode === 'flashcard') {
                activeFlashcards = filteredWords.length > 0 ? filteredWords : window.ENGLISHUB_DATA.vocabularies;
                flashcardIndex = 0;
                document.getElementById('fcCategoryBadge').innerText = cat ? cat.name : 'Modul';
                switchTab('flashcard');
            } else if (mode === 'quiz') {
                quizQuestions = filteredWords.length > 0 ? filteredWords : window.ENGLISHUB_DATA.vocabularies;
                switchTab('quiz');
            } else if (mode === 'pronounce') {
                if (filteredWords.length > 0) {
                    currentStudioWord = filteredWords[0].word;
                    renderStudioWord(filteredWords[0]);
                }
                switchTab('pronounce');
            }
        }

        // FLASHCARD LOGIC
        function renderFlashcard() {
            if (activeFlashcards.length === 0) return;
            const word = activeFlashcards[flashcardIndex];
            currentFlashcardWord = word.word;
            currentFlashcardExample = word.example_sentence || word.word;

            // Reset flip
            const cardEl = document.getElementById('flashcardElement');
            cardEl.classList.remove('rotate-y-180');
            isCardFlipped = false;

            // Populate Front
            document.getElementById('fcFrontWord').innerText = word.word;
            document.getElementById('fcFrontPhonetic').innerText = word.phonetic || '/.../';
            document.getElementById('fcFrontPos').innerText = word.part_of_speech || 'Word';
            document.getElementById('fcFrontDifficulty').innerText = word.difficulty === 'basic' ? 'Level Dasar' : (word.difficulty === 'daily' ? 'Sehari-hari' : 'Level Mahir');

            // Populate Back
            document.getElementById('fcBackWordSmall').innerText = word.word;
            document.getElementById('fcBackTranslation').innerText = word.translation;
            document.getElementById('fcBackExample').innerText = word.example_sentence || 'No example available.';
            document.getElementById('fcBackExampleTr').innerText = word.example_translation || '';
            document.getElementById('fcBackTip').innerText = word.pronunciation_tip || 'Dengarkan baik-baik suku kata yang ditekankan.';

            document.getElementById('fcCurrentIndex').innerText = flashcardIndex + 1;
            document.getElementById('fcTotalCards').innerText = activeFlashcards.length;
        }

        function flipFlashcard() {
            playSyntheticTone('flip');
            const cardEl = document.getElementById('flashcardElement');
            isCardFlipped = !isCardFlipped;
            if (isCardFlipped) {
                cardEl.classList.add('rotate-y-180');
            } else {
                cardEl.classList.remove('rotate-y-180');
            }
        }

        function nextFlashcard() {
            if (flashcardIndex < activeFlashcards.length - 1) {
                flashcardIndex++;
                renderFlashcard();
            } else {
                confetti({ particleCount: 50, spread: 70 });
                flashcardIndex = 0;
                renderFlashcard();
            }
        }

        function prevFlashcard() {
            if (flashcardIndex > 0) {
                flashcardIndex--;
                renderFlashcard();
            }
        }

        function markFlashcardStatus(isMastered) {
            const word = activeFlashcards[flashcardIndex];
            if (isMastered) {
                playSyntheticTone('correct');
                saveLearningProgress(word.id, true, null);
                addXP(25);
            } else {
                playSyntheticTone('flip');
                saveLearningProgress(word.id, false, null);
            }
            nextFlashcard();
        }

        function playSlowToggle() {
            isSlowAudioMode = !isSlowAudioMode;
            document.getElementById('slowModeLabel').innerText = isSlowAudioMode ? 'ON' : 'OFF';
            document.getElementById('slowModeLabel').className = isSlowAudioMode ? 'text-amber-400' : 'text-emerald-400';
            speakWord(currentFlashcardWord);
        }

        function practicePronunciationCurrentWord() {
            currentStudioWord = currentFlashcardWord;
            const wordObj = activeFlashcards[flashcardIndex];
            if (wordObj) renderStudioWord(wordObj);
            switchTab('pronounce');
        }

        // QUIZ LOGIC
        function startQuizMode() {
            quizQuestions = [...window.ENGLISHUB_DATA.vocabularies].sort(() => 0.5 - Math.random());
            quizIndex = 0;
            quizStreak = 0;
            quizLives = 3;
            renderQuizQuestion();
        }

        function renderQuizQuestion() {
            if (quizIndex >= quizQuestions.length || quizIndex >= 10) {
                // Completed
                confetti({ particleCount: 80, spread: 80, origin: { y: 0.5 } });
                playSyntheticTone('correct');
                alert(`Selamat! Anda telah menyelesaikan kuis dengan Streak: ${quizStreak}! +50 XP Bonus!`);
                addXP(50);
                startQuizMode();
                return;
            }

            const current = quizQuestions[quizIndex];
            quizTargetWord = current.word;

            document.getElementById('quizCurrentNo').innerText = quizIndex + 1;
            document.getElementById('quizQuestionWord').innerText = current.word;
            document.getElementById('quizQuestionPhonetic').innerText = current.phonetic || '';
            document.getElementById('quizStreakBadge').innerText = `🔥 Streak: ${quizStreak}`;

            // Generate 1 correct + 3 distractor choices
            const otherWords = window.ENGLISHUB_DATA.vocabularies.filter(v => v.id !== current.id);
            const distractors = [...otherWords].sort(() => 0.5 - Math.random()).slice(0, 3);
            const options = [...distractors, current].sort(() => 0.5 - Math.random());

            const container = document.getElementById('quizOptionsContainer');
            container.innerHTML = '';
            document.getElementById('quizFeedbackBox').classList.add('hidden');

            options.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = 'w-full py-3 px-4 rounded-2xl bg-slate-900 hover:bg-slate-700/80 border border-slate-700/80 text-left text-xs font-semibold text-white transition-all flex items-center justify-between group active:scale-98';
                btn.innerHTML = `
                    <span>${opt.translation}</span>
                    <span class="w-6 h-6 rounded-full bg-slate-800 text-[11px] text-slate-400 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">➜</span>
                `;
                btn.onclick = () => selectQuizAnswer(opt.id === current.id, btn, current);
                container.appendChild(btn);
            });
        }

        function selectQuizAnswer(isCorrect, btnElement, targetWord) {
            const feedbackBox = document.getElementById('quizFeedbackBox');
            const feedbackText = document.getElementById('quizFeedbackText');

            const allButtons = document.querySelectorAll('#quizOptionsContainer button');
            allButtons.forEach(b => b.disabled = true);

            if (isCorrect) {
                playSyntheticTone('correct');
                btnElement.className = 'w-full py-3 px-4 rounded-2xl bg-emerald-600/30 border-2 border-emerald-500 text-left text-xs font-extrabold text-emerald-300 transition-all flex items-center justify-between';
                quizStreak++;
                addXP(15);
                saveLearningProgress(targetWord.id, true, null);

                feedbackBox.className = 'p-3 rounded-2xl bg-emerald-950/60 border border-emerald-500/40 text-xs font-bold text-emerald-300 text-center block';
                feedbackText.innerText = '🎉 Hebat! Jawabanmu 100% Benar! (+15 XP)';
            } else {
                playSyntheticTone('incorrect');
                btnElement.className = 'w-full py-3 px-4 rounded-2xl bg-rose-600/30 border-2 border-rose-500 text-left text-xs font-bold text-rose-300 transition-all flex items-center justify-between';
                quizStreak = 0;
                quizLives--;

                feedbackBox.className = 'p-3 rounded-2xl bg-rose-950/60 border border-rose-500/40 text-xs font-bold text-rose-300 text-center block';
                feedbackText.innerText = `Kurang tepat. Arti yang benar: "${targetWord.translation}"`;
            }

            document.getElementById('quizStreakBadge').innerText = `🔥 Streak: ${quizStreak}`;
            document.getElementById('quizHearts').innerText = '❤️'.repeat(Math.max(0, quizLives));

            setTimeout(() => {
                quizIndex++;
                renderQuizQuestion();
            }, 1400);
        }

        // QUIZ SUBMODES & SENTENCE BUILDER LOGIC
        let currentQuizSubMode = 'mcq';
        let builderSentences = [];
        let builderIndex = 0;
        let currentBuilderTarget = null;
        let builderTokens = [];
        let builderSelectedTokens = [];

        let listeningQuestions = [];
        let listeningIndex = 0;
        let currentListeningTarget = null;

        function setQuizSubMode(mode) {
            currentQuizSubMode = mode;
            const modes = ['mcq', 'builder', 'listening'];
            modes.forEach(m => {
                const btn = document.getElementById(`btnQuizMode-${m}`);
                const container = document.getElementById(`quizContainer-${m}`);
                if (m === mode) {
                    if (btn) btn.className = 'py-1.5 rounded-xl text-xs font-bold transition-all text-center bg-indigo-600 text-white shadow-sm';
                    if (container) container.classList.remove('hidden');
                } else {
                    if (btn) btn.className = 'py-1.5 rounded-xl text-xs font-bold transition-all text-center text-slate-400 hover:text-slate-200';
                    if (container) container.classList.add('hidden');
                }
            });

            if (mode === 'mcq') {
                if (quizQuestions.length === 0) startQuizMode();
            } else if (mode === 'builder') {
                startBuilderMode();
            } else if (mode === 'listening') {
                startListeningMode();
            }
        }

        // SENTENCE BUILDER IMPLEMENTATION
        function startBuilderMode() {
            builderSentences = window.ENGLISHUB_DATA.vocabularies
                .filter(v => v.example_sentence && v.example_sentence.trim().length > 10)
                .sort(() => 0.5 - Math.random());
            builderIndex = 0;
            renderBuilderQuestion();
        }

        function renderBuilderQuestion() {
            if (builderIndex >= builderSentences.length) {
                builderIndex = 0;
            }
            currentBuilderTarget = builderSentences[builderIndex];
            const sentence = currentBuilderTarget.example_sentence.trim();

            document.getElementById('builderProgressLabel').innerText = `${(builderIndex % 10) + 1} / 10`;
            document.getElementById('builderTargetTranslation').innerText = currentBuilderTarget.example_translation || 'Susunlah kata-kata bahasa Inggris berikut sesuai arti:';
            document.getElementById('builderFeedbackBox').classList.add('hidden');

            // Tokenize words
            const rawTokens = sentence.split(/\s+/);
            builderTokens = rawTokens.map((w, idx) => ({ id: idx, text: w, used: false }));
            // Shuffle for palette
            builderTokens.sort(() => 0.5 - Math.random());
            builderSelectedTokens = [];

            renderBuilderSlots();
            renderBuilderPalette();
        }

        function renderBuilderSlots() {
            const assembledArea = document.getElementById('builderAssembledArea');
            assembledArea.innerHTML = '';

            if (builderSelectedTokens.length === 0) {
                assembledArea.innerHTML = '<span id="builderPlaceholder" class="text-xs text-slate-500 italic">Ketuk kata-kata di bawah sesuai urutan yang tepat</span>';
                return;
            }

            builderSelectedTokens.forEach((token, selIdx) => {
                const chip = document.createElement('button');
                chip.className = 'px-3 py-1.5 rounded-xl bg-cyan-600 hover:bg-rose-600 text-white font-bold text-xs shadow-md transition-all active:scale-95 flex items-center gap-1 group';
                chip.innerHTML = `<span>${token.text}</span><span class="text-[10px] opacity-75 group-hover:inline">✕</span>`;
                chip.onclick = () => removeBuilderWord(selIdx);
                assembledArea.appendChild(chip);
            });
        }

        function renderBuilderPalette() {
            const palette = document.getElementById('builderChipsPalette');
            palette.innerHTML = '';

            builderTokens.forEach(token => {
                const chip = document.createElement('button');
                if (token.used) {
                    chip.className = 'px-3 py-1.5 rounded-xl bg-slate-800 text-slate-600 border border-slate-700/40 text-xs font-semibold cursor-not-allowed opacity-40';
                    chip.disabled = true;
                } else {
                    chip.className = 'px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700 text-xs font-bold shadow-sm transition-all active:scale-95';
                    chip.onclick = () => addBuilderWord(token.id);
                }
                chip.innerText = token.text;
                palette.appendChild(chip);
            });
        }

        function addBuilderWord(tokenId) {
            const token = builderTokens.find(t => t.id === tokenId);
            if (!token || token.used) return;
            token.used = true;
            builderSelectedTokens.push(token);
            playSyntheticTone('flip');
            renderBuilderSlots();
            renderBuilderPalette();
        }

        function removeBuilderWord(selIdx) {
            const token = builderSelectedTokens[selIdx];
            if (!token) return;
            token.used = false;
            builderSelectedTokens.splice(selIdx, 1);
            playSyntheticTone('flip');
            renderBuilderSlots();
            renderBuilderPalette();
        }

        function clearBuilderSentence() {
            builderTokens.forEach(t => t.used = false);
            builderSelectedTokens = [];
            renderBuilderSlots();
            renderBuilderPalette();
            document.getElementById('builderFeedbackBox').classList.add('hidden');
        }

        function checkBuilderSentence() {
            if (!currentBuilderTarget) return;
            const targetSentence = currentBuilderTarget.example_sentence.trim();
            const assembled = builderSelectedTokens.map(t => t.text).join(' ').trim();
            const feedbackBox = document.getElementById('builderFeedbackBox');
            const feedbackText = document.getElementById('builderFeedbackText');

            if (assembled.toLowerCase() === targetSentence.toLowerCase()) {
                playSyntheticTone('correct');
                confetti({ particleCount: 60, spread: 70 });
                addXP(25);
                saveLearningProgress(currentBuilderTarget.id, true, 100);

                feedbackBox.className = 'p-3 rounded-2xl bg-emerald-950/60 border border-emerald-500/40 text-xs font-bold text-emerald-300 text-center block';
                feedbackText.innerHTML = `🎉 Sempurna! Susunan kalimatmu tepat! (+25 XP)<br><span class="text-[11px] text-emerald-200/90 font-normal">Memutar pelafalan audio...</span>`;

                speakWord(targetSentence);

                setTimeout(() => {
                    nextBuilderSentence();
                }, 2200);
            } else {
                playSyntheticTone('incorrect');
                feedbackBox.className = 'p-3 rounded-2xl bg-rose-950/60 border border-rose-500/40 text-xs font-bold text-rose-300 text-center block';
                feedbackText.innerText = 'Susunan belum tepat. Cek kembali urutan Subjek, Kata Kerja, dan Objek.';
            }
        }

        function nextBuilderSentence() {
            builderIndex++;
            renderBuilderQuestion();
        }

        // LISTENING QUIZ IMPLEMENTATION
        function startListeningMode() {
            listeningQuestions = [...window.ENGLISHUB_DATA.vocabularies].sort(() => 0.5 - Math.random());
            listeningIndex = 0;
            renderListeningQuestion();
        }

        function renderListeningQuestion() {
            if (listeningIndex >= listeningQuestions.length || listeningIndex >= 10) {
                confetti({ particleCount: 80, spread: 80 });
                playSyntheticTone('correct');
                alert(`Luar biasa! Latihan listening selesai! +40 XP Bonus!`);
                addXP(40);
                startListeningMode();
                return;
            }

            currentListeningTarget = listeningQuestions[listeningIndex];
            document.getElementById('listeningCurrentNo').innerText = listeningIndex + 1;
            document.getElementById('listeningFeedbackBox').classList.add('hidden');

            // Pick 3 distractors
            const otherWords = window.ENGLISHUB_DATA.vocabularies.filter(v => v.id !== currentListeningTarget.id);
            const distractors = [...otherWords].sort(() => 0.5 - Math.random()).slice(0, 3);
            const options = [...distractors, currentListeningTarget].sort(() => 0.5 - Math.random());

            const container = document.getElementById('listeningOptionsContainer');
            container.innerHTML = '';

            options.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = 'w-full py-3 px-3 rounded-2xl bg-slate-900 hover:bg-slate-700/80 border border-slate-700 text-center text-xs font-bold text-white transition-all active:scale-98 shadow-sm';
                btn.innerText = opt.word;
                btn.onclick = () => selectListeningAnswer(opt.id === currentListeningTarget.id, btn, currentListeningTarget);
                container.appendChild(btn);
            });

            // Auto play audio once
            setTimeout(() => {
                playListeningAudio();
            }, 300);
        }

        function playListeningAudio() {
            if (currentListeningTarget) {
                speakWord(currentListeningTarget.word);
            }
        }

        function selectListeningAnswer(isCorrect, btnElement, targetWord) {
            const feedbackBox = document.getElementById('listeningFeedbackBox');
            const feedbackText = document.getElementById('listeningFeedbackText');

            const allButtons = document.querySelectorAll('#listeningOptionsContainer button');
            allButtons.forEach(b => b.disabled = true);

            if (isCorrect) {
                playSyntheticTone('correct');
                btnElement.className = 'w-full py-3 px-3 rounded-2xl bg-emerald-600/30 border-2 border-emerald-500 text-center text-xs font-black text-emerald-300 transition-all';
                addXP(20);
                saveLearningProgress(targetWord.id, true, null);

                feedbackBox.className = 'p-3 rounded-2xl bg-emerald-950/60 border border-emerald-500/40 text-xs font-bold text-emerald-300 text-center block';
                feedbackText.innerHTML = `🎉 Tepat sekali! Kata: "${targetWord.word}" (${targetWord.phonetic}) = ${targetWord.translation}`;
            } else {
                playSyntheticTone('incorrect');
                btnElement.className = 'w-full py-3 px-3 rounded-2xl bg-rose-600/30 border-2 border-rose-500 text-center text-xs font-bold text-rose-300 transition-all';

                feedbackBox.className = 'p-3 rounded-2xl bg-rose-950/60 border border-rose-500/40 text-xs font-bold text-rose-300 text-center block';
                feedbackText.innerText = `Kurang tepat. Suara tadi adalah: "${targetWord.word}" (${targetWord.translation})`;
            }

            setTimeout(() => {
                listeningIndex++;
                renderListeningQuestion();
            }, 1600);
        }

        // GRAMMAR GUIDE MODAL LOGIC
        function openGrammarModal() {
            const modal = document.getElementById('grammarGuideModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeGrammarModal() {
            const modal = document.getElementById('grammarGuideModal');
            if (modal) modal.classList.add('hidden');
        }

        function switchGrammarTab(tabKey) {
            const tabs = ['svo', 'tenses', 'tobe', 'dodoes', 'aan'];
            tabs.forEach(k => {
                const btn = document.getElementById(`gTabBtn-${k}`);
                const sec = document.getElementById(`gSec-${k}`);
                if (k === tabKey) {
                    if (btn) btn.className = 'g-tab-btn active shrink-0 px-2.5 py-1 rounded-xl text-[11px] font-bold bg-indigo-600 text-white';
                    if (sec) sec.classList.remove('hidden');
                } else {
                    if (btn) btn.className = 'g-tab-btn shrink-0 px-2.5 py-1 rounded-xl text-[11px] font-bold text-slate-400 hover:text-white';
                    if (sec) sec.classList.add('hidden');
                }
            });
        }

        // PRONUNCIATION STUDIO LOGIC
        function pickRandomStudioWord() {
            const pool = window.ENGLISHUB_DATA.vocabularies;
            if (pool.length === 0) return;
            const random = pool[Math.floor(Math.random() * pool.length)];
            currentStudioWord = random.word;
            renderStudioWord(random);
        }

        function renderStudioWord(wordObj) {
            document.getElementById('studioWordText').innerText = wordObj.word;
            document.getElementById('studioPhoneticText').innerText = wordObj.phonetic || '/.../';
            document.getElementById('studioTranslationText').innerText = wordObj.translation;
            document.getElementById('studioTipText').innerText = wordObj.pronunciation_tip || 'Tekankan suku kata dengan jelas dan hembuskan napas secara alami.';
            document.getElementById('speechResultCard').classList.add('hidden');
        }

        // CONVERSATION DIALOGUE SIMULATOR
        function selectConversation(convoId) {
            const convo = window.ENGLISHUB_DATA.conversations.find(c => c.id === convoId);
            if (!convo) return;
            activeConversation = convo;
            currentDialogueStep = 0;

            document.querySelectorAll('.convo-pill-btn').forEach(btn => {
                if (parseInt(btn.getAttribute('data-id')) === convoId) {
                    btn.className = 'convo-pill-btn shrink-0 px-3 py-1.5 rounded-xl text-xs font-bold transition-all border bg-indigo-600 border-indigo-500 text-white';
                } else {
                    btn.className = 'convo-pill-btn shrink-0 px-3 py-1.5 rounded-xl text-xs font-bold transition-all border bg-slate-800 border-slate-700 text-slate-400 hover:text-white';
                }
            });

            document.getElementById('convoTitle').innerText = convo.title;
            document.getElementById('convoDesc').innerText = convo.description;

            renderDialogueStream();
        }

        function renderDialogueStream() {
            const stream = document.getElementById('chatMessagesStream');
            stream.innerHTML = '';

            const lines = activeConversation.dialogue_script;
            const shownLines = lines.slice(0, currentDialogueStep + 1);

            shownLines.forEach((line, idx) => {
                const isUser = line.role === 'user';
                const bubble = document.createElement('div');
                bubble.className = `flex flex-col ${isUser ? 'items-end' : 'items-start'} space-y-1`;

                bubble.innerHTML = `
                    <div class="flex items-center gap-1.5 text-[11px] text-slate-400 ${isUser ? 'flex-row-reverse' : ''}">
                        <span class="font-bold text-slate-300">${line.speaker}</span>
                        <button onclick="speakWord('${line.text.replace(/'/g, "\\'")}')" class="text-xs hover:text-white p-0.5">🔊</button>
                    </div>
                    <div class="max-w-[85%] p-3 rounded-2xl ${isUser ? 'bg-indigo-600 text-white rounded-br-none shadow-md shadow-indigo-600/20' : 'bg-slate-800 border border-slate-700 text-slate-100 rounded-bl-none'}">
                        <p class="text-xs font-semibold leading-relaxed">${line.text}</p>
                        <p class="convo-trans text-[11px] mt-1 text-slate-300/80 italic border-t border-white/10 pt-1 ${showTranslationSpoilers ? '' : 'hidden'}">${line.translation}</p>
                    </div>
                `;
                stream.appendChild(bubble);
            });

            stream.scrollTop = stream.scrollHeight;

            // Check if there is next user response required
            const nextIdx = currentDialogueStep + 1;
            const replyContainer = document.getElementById('convoOptionButtons');
            replyContainer.innerHTML = '';

            if (nextIdx < lines.length) {
                const nextLine = lines[nextIdx];
                if (nextLine.role === 'user') {
                    const btn = document.createElement('button');
                    btn.className = 'w-full p-2.5 rounded-xl bg-slate-900 hover:bg-indigo-600 border border-indigo-500/40 text-left text-xs text-white font-semibold transition-all flex items-center justify-between group';
                    btn.innerHTML = `
                        <div class="flex-1 pr-2">
                            <div>"${nextLine.text}"</div>
                            <div class="text-[11px] text-slate-400 group-hover:text-indigo-200 italic mt-0.5">${nextLine.translation}</div>
                        </div>
                        <span class="w-6 h-6 rounded-full bg-indigo-500 text-white flex items-center justify-center text-xs shrink-0">💬</span>
                    `;
                    btn.onclick = () => advanceDialogueStep();
                    replyContainer.appendChild(btn);
                } else {
                    const autoAdvanceBtn = document.createElement('button');
                    autoAdvanceBtn.className = 'w-full py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-300';
                    autoAdvanceBtn.innerText = 'Lanjutkan Percakapan ➜';
                    autoAdvanceBtn.onclick = () => advanceDialogueStep();
                    replyContainer.appendChild(autoAdvanceBtn);
                }
            } else {
                replyContainer.innerHTML = `
                    <div class="text-center py-2 text-xs font-bold text-emerald-400">
                        🎉 Skenario Percakapan Selesai! (+30 XP)
                        <button onclick="selectConversation(${activeConversation.id})" class="mt-2 block mx-auto px-3 py-1 rounded-xl bg-slate-900 border border-slate-700 text-slate-300 text-[11px]">Ulangi Percakapan</button>
                    </div>
                `;
                addXP(30);
            }
        }

        function advanceDialogueStep() {
            playSyntheticTone('flip');
            currentDialogueStep++;
            renderDialogueStream();

            // Auto-speak latest partner line
            const latestLine = activeConversation.dialogue_script[currentDialogueStep];
            if (latestLine && latestLine.role === 'partner') {
                setTimeout(() => speakWord(latestLine.text), 300);
            }
        }

        function toggleTranslationSpoilers() {
            showTranslationSpoilers = !showTranslationSpoilers;
            document.querySelectorAll('.convo-trans').forEach(el => {
                if (showTranslationSpoilers) el.classList.remove('hidden');
                else el.classList.add('hidden');
            });
        }

        // POCKET DICTIONARY LOGIC
        function setDictFilter(filter) {
            activeDictFilter = filter;
            document.querySelectorAll('.dict-filter-chip').forEach(btn => {
                if (btn.getAttribute('data-filter') === filter) {
                    btn.className = 'dict-filter-chip shrink-0 px-2.5 py-1 rounded-xl bg-indigo-600 text-white font-bold';
                } else {
                    btn.className = 'dict-filter-chip shrink-0 px-2.5 py-1 rounded-xl bg-slate-800 text-slate-400 hover:text-white font-medium';
                }
            });
            renderDictionaryList();
        }

        function filterDictionaryWords() {
            const search = document.getElementById('dictSearchInput').value.trim();
            const clearBtn = document.getElementById('dictClearSearchBtn');
            if (search.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
            renderDictionaryList();
        }

        function clearDictSearch() {
            document.getElementById('dictSearchInput').value = '';
            document.getElementById('dictClearSearchBtn').classList.add('hidden');
            renderDictionaryList();
        }

        const DICT_PAGE_SIZE = 40;
        let dictVisibleLimit = DICT_PAGE_SIZE;

        function escapeHtml(value) {
            return String(value ?? '').replace(/[&<>"']/g, ch => ({'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[ch]));
        }

        function getFilteredDictionaryWords() {
            const search = document.getElementById('dictSearchInput').value.toLowerCase().trim();
            const categoryId = parseInt(document.getElementById('dictCategorySelect').value) || null;

            let words = window.ENGLISHUB_DATA.vocabularies;

            if (['basic', 'daily', 'advanced'].includes(activeDictFilter)) {
                words = words.filter(w => w.difficulty === activeDictFilter);
            } else if (activeDictFilter === 'saved') {
                words = words.filter(w => bookmarkedWordIds.includes(w.id));
            }

            if (categoryId) {
                words = words.filter(w => w.category_id === categoryId);
            }

            if (search.length > 0) {
                words = words.filter(w =>
                    w.word.toLowerCase().includes(search) ||
                    w.translation.toLowerCase().includes(search) ||
                    (w.example_sentence && w.example_sentence.toLowerCase().includes(search))
                );
            }

            return words;
        }

        function renderDictionaryList(resetPage = true) {
            if (resetPage) dictVisibleLimit = DICT_PAGE_SIZE;

            const container = document.getElementById('dictWordListContainer');
            const loadMoreBtn = document.getElementById('dictLoadMoreBtn');
            const words = getFilteredDictionaryWords();
            const visibleWords = words.slice(0, dictVisibleLimit);

            document.getElementById('dictResultCount').innerText = `${words.length} kata`;

            if (words.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-xs text-slate-500">
                        Tidak ada kata yang sesuai dengan pencarian.
                    </div>
                `;
                loadMoreBtn.classList.add('hidden');
                return;
            }

            const levelStyles = {
                basic: 'bg-emerald-500/20 text-emerald-300',
                daily: 'bg-amber-500/20 text-amber-300',
                advanced: 'bg-purple-500/20 text-purple-300'
            };

            container.innerHTML = visibleWords.map(w => {
                const isBookmarked = bookmarkedWordIds.includes(w.id);
                return `
                    <div class="p-3 rounded-2xl bg-slate-800/80 border border-slate-700/70 hover:border-indigo-500/40 transition-all flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                                <span class="text-sm font-bold text-white">${escapeHtml(w.word)}</span>
                                <span class="text-[11px] font-mono text-indigo-300">${escapeHtml(w.phonetic)}</span>
                                <span class="text-[10px] uppercase px-1.5 py-0.5 rounded bg-slate-900 text-slate-400 font-semibold">${escapeHtml(w.part_of_speech)}</span>
                                <span class="text-[10px] px-1.5 py-0.5 rounded font-semibold ${levelStyles[w.difficulty] || levelStyles.basic}">${w.category ? escapeHtml(w.category.name.split(/[&(,]/)[0].trim()) : ''}</span>
                            </div>
                            <div class="text-xs text-emerald-400 font-semibold mt-1">${escapeHtml(w.translation)}</div>
                            ${w.example_sentence ? `<div class="text-[11px] text-slate-400 mt-1 italic leading-snug">"${escapeHtml(w.example_sentence)}"</div>` : ''}
                        </div>
                        <div class="flex flex-col items-center gap-1.5 shrink-0">
                            <button onclick="speakWordById(${w.id})" class="w-8 h-8 rounded-xl bg-slate-900 hover:bg-slate-700 text-slate-300 text-xs">🔊</button>
                            <button onclick="practiceWordInStudio(${w.id})" class="w-8 h-8 rounded-xl bg-slate-900 hover:bg-emerald-600/30 text-emerald-400 text-xs" title="Latih di Studio">🎙️</button>
                            <button onclick="toggleBookmarkWord(${w.id})" class="w-8 h-8 rounded-xl bg-slate-900 hover:bg-amber-600/30 ${isBookmarked ? 'text-amber-400' : 'text-slate-500'} text-xs">${isBookmarked ? '⭐' : '☆'}</button>
                        </div>
                    </div>
                `;
            }).join('');

            if (words.length > visibleWords.length) {
                loadMoreBtn.innerText = `Muat lebih banyak (${words.length - visibleWords.length} kata lagi)`;
                loadMoreBtn.classList.remove('hidden');
            } else {
                loadMoreBtn.classList.add('hidden');
            }
        }

        function loadMoreDictionaryWords() {
            dictVisibleLimit += DICT_PAGE_SIZE;
            renderDictionaryList(false);
        }

        function speakWordById(wordId) {
            const word = window.ENGLISHUB_DATA.vocabularies.find(w => w.id === wordId);
            if (word) speakWord(word.word);
        }

        function toggleBookmarkWord(wordId) {
            if (bookmarkedWordIds.includes(wordId)) {
                bookmarkedWordIds = bookmarkedWordIds.filter(id => id !== wordId);
            } else {
                bookmarkedWordIds.push(wordId);
                playSyntheticTone('correct');
            }
            localStorage.setItem('englishub_bookmarks', JSON.stringify(bookmarkedWordIds));
            renderDictionaryList(false);
        }

        function practiceWordInStudio(wordId) {
            const word = window.ENGLISHUB_DATA.vocabularies.find(w => w.id === wordId);
            if (word) {
                currentStudioWord = word.word;
                renderStudioWord(word);
                switchTab('pronounce');
            }
        }

        // GAMIFICATION & BACKEND PROGRESS SYNC
        function addXP(points) {
            const xpEl = document.getElementById('xpCount');
            const profXpEl = document.getElementById('profTotalXP');
            let current = parseInt(xpEl.innerText) || 0;
            current += points;
            xpEl.innerText = current;
            if (profXpEl) profXpEl.innerText = current;
        }

        async function saveLearningProgress(vocabularyId, isMastered, score) {
            try {
                const response = await fetch("{{ route('learning.progress') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.ENGLISHUB_DATA.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        vocabulary_id: vocabularyId,
                        is_mastered: isMastered,
                        pronunciation_score: score
                    })
                });
                const res = await response.json();
                if (res.success && res.record) {
                    if (Array.isArray(window.ENGLISHUB_DATA.userRecords)) window.ENGLISHUB_DATA.userRecords = {};
                    window.ENGLISHUB_DATA.userRecords[res.record.vocabulary_id] = res.record;
                    updateCategoryProgress();
                }
                if (res.success && res.stats) {
                    document.getElementById('statMasteredWords').innerText = `${res.stats.mastered_words} kata`;
                    document.getElementById('statAvgScore').innerText = `${res.stats.avg_score}%`;
                    document.getElementById('profMastered').innerText = res.stats.mastered_words;
                    document.getElementById('profAvgScore').innerText = `${res.stats.avg_score}%`;
                    document.getElementById('xpCount').innerText = res.stats.xp;
                    document.getElementById('profTotalXP').innerText = res.stats.xp;
                }
            } catch (err) {
                console.warn('Sync error:', err);
            }
        }

        function resetLearningProgress() {
            if (confirm('Yakin ingin mereset riwayat belajar Anda?')) {
                localStorage.removeItem('englishub_bookmarks');
                bookmarkedWordIds = [];
                location.reload();
            }
        }

        // DESKTOP FRAME TOGGLE
        let isMobileFrameActive = true;
        function toggleDesktopFrame() {
            const container = document.getElementById('appContainer');
            const label = document.getElementById('frameLabel');
            const icon = document.getElementById('frameIcon');
            isMobileFrameActive = !isMobileFrameActive;

            if (isMobileFrameActive) {
                container.className = 'w-full h-full min-h-screen md:min-h-[860px] md:h-[92vh] md:max-w-[430px] md:my-auto md:rounded-[44px] md:shadow-[0_25px_80px_-15px_rgba(79,70,229,0.35),0_0_0_12px_#1e293b,0_0_0_14px_#334155] bg-slate-900 flex flex-col overflow-hidden relative border-slate-800';
                label.innerText = 'Mode Layar HP';
                icon.innerText = '📱';
            } else {
                container.className = 'w-full h-full min-h-screen max-w-4xl my-auto rounded-2xl shadow-2xl bg-slate-900 flex flex-col overflow-hidden relative border border-slate-800';
                label.innerText = 'Mode Layar Lebar';
                icon.innerText = '💻';
            }
        }

        // AUDIO SETTINGS MODAL TOGGLE
        function toggleAudioSettingsModal() {
            const modal = document.getElementById('audioSettingsModal');
            modal.classList.toggle('hidden');
        }

        function toggleSoundFx(enabled) {
            isSoundFxEnabled = enabled;
        }

        function changeVoiceAccent(accent) {
            preferredVoiceLang = accent;
            speakWord('Hello! Ready to speak English?');
        }

        function changeSpeechRate(rate) {
            preferredSpeechRate = parseFloat(rate);
            document.getElementById('speechRateLabel').innerText = `${preferredSpeechRate.toFixed(1)}x`;
        }

        // Init on load
        document.addEventListener('DOMContentLoaded', () => {
            filterCurriculum('beginner');
            updateCategoryProgress();
            activeFlashcards = window.ENGLISHUB_DATA.vocabularies.filter(v => v.category?.level === 'beginner');
            if (activeFlashcards.length === 0) activeFlashcards = window.ENGLISHUB_DATA.vocabularies;
            renderFlashcard();
            renderDictionaryList();

            // Register PWA Service Worker
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('/sw.js').catch(err => {
                    console.log('SW registration skipped:', err);
                });
            }
        });
    </script>
</body>
</html>
