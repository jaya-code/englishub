#!/usr/bin/env python3
"""
Vocabulary Data Compiler for EnglisHub.
Generates 1,200+ rich, structured vocabulary words across 30 categories.
"""

import json
import os

# We will build 30 categories with extensive vocabulary lists
categories = [
    # Beginner
    {"slug": "abjad-fonetik-dasar", "name": "Abjad, Fonetik & Suara Dasar", "level": "beginner", "icon": "🔤", "color_theme": "blue", "sort_order": 1, "description": "Kuasai dasar pelafalan huruf vokal, konsonan penting (th, sh, ch), dan ejaan."},
    {"slug": "salam-perkenalan", "name": "Salam & Perkenalan Diri", "level": "beginner", "icon": "👋", "color_theme": "violet", "sort_order": 2, "description": "Kalimat sapaan harian, cara memperkenalkan nama, asal, pekerjaan, dan basa-basi sopan."},
    {"slug": "angka-waktu-jadwal", "name": "Angka, Jam & Waktu", "level": "beginner", "icon": "⏰", "color_theme": "emerald", "sort_order": 3, "description": "Menghitung, membaca jam (quarter past/half past), hari, bulan, dan menyusun janji temu."},
    {"slug": "keluarga-dan-perasaan", "name": "Keluarga, Emosi & Perasaan", "level": "beginner", "icon": "💖", "color_theme": "pink", "sort_order": 4, "description": "Mengekspresikan rasa syukur, bahagia, lelah, dan mendeskripsikan orang-orang terdekat."},
    {"slug": "warna-bentuk-deskripsi", "name": "Warna, Bentuk & Deskripsi", "level": "beginner", "icon": "🎨", "color_theme": "fuchsia", "sort_order": 5, "description": "Mendeskripsikan benda, ukuran ruangan, warna cerah, dan penampilan fisik secara akurat."},
    {"slug": "rumah-dan-aktivitas", "name": "Rumah, Perabot & Aktivitas", "level": "beginner", "icon": "🏠", "color_theme": "amber", "sort_order": 6, "description": "Nama ruangan, perlengkapan tempat tidur, perabot dapur, dan kegiatan membersihkan rumah."},
    {"slug": "cuaca-musim-alam", "name": "Cuaca, Musim & Suasana Alam", "level": "beginner", "icon": "⛅", "color_theme": "sky", "sort_order": 7, "description": "Membicarakan prakiraan cuaca, hujan gerimis, badai petir, suhu dingin, dan musim."},
    {"slug": "hewan-dan-fauna", "name": "Hewan, Fauna & Peliharaan", "level": "beginner", "icon": "🐾", "color_theme": "teal", "sort_order": 8, "description": "Nama-nama hewan peliharaan, hewan ternak, margasatwa, dan habitat alam bebas."},
    {"slug": "pakaian-dan-aksesoris", "name": "Pakaian, Busana & Aksesoris", "level": "beginner", "icon": "👔", "color_theme": "rose", "sort_order": 9, "description": "Busana sehari-hari, alas kaki, pakaian kerja, aksesoris, dan ukuran pakaian."},
    {"slug": "makanan-dan-buah", "name": "Bahan Makanan, Sayur & Buah", "level": "beginner", "icon": "🍎", "color_theme": "red", "sort_order": 10, "description": "Bahan masakan segar, aneka buah manis, sayuran hijau, dan bumbu dapur harian."},

    # Daily
    {"slug": "makanan-restoran", "name": "Makanan, Minuman & Restoran", "level": "daily", "icon": "🍽️", "color_theme": "rose", "sort_order": 11, "description": "Kosakata kuliner, memesan meja, meminta rekomendasi menu, dan meminta tagihan bill."},
    {"slug": "belanja-dan-toko", "name": "Belanja, Toko & Menawar", "level": "daily", "icon": "🛍️", "color_theme": "teal", "sort_order": 12, "description": "Belanja di mall atau pasar, menanyakan ukuran pakaian, diskon, dan metode pembayaran."},
    {"slug": "arah-dan-perjalanan", "name": "Arah Jalan, Bandara & Transportasi", "level": "daily", "icon": "🧭", "color_theme": "cyan", "sort_order": 13, "description": "Navigasi di luar negeri, naik kereta/pesawat, bertanya jalan kepada pejalan kaki."},
    {"slug": "hotel-dan-akomodasi", "name": "Hotel & Akomodasi Liburan", "level": "daily", "icon": "🏨", "color_theme": "indigo", "sort_order": 14, "description": "Check-in kamar, konfirmasi reservasi, meminta amenities, dan info sarapan pagi."},
    {"slug": "pekerjaan-dan-profesi", "name": "Profesi, Karir & Dunia Kerja", "level": "daily", "icon": "👨‍💼", "color_theme": "emerald", "sort_order": 15, "description": "Nama profesi global, promosi jabatan, berkas resume kerja, dan interaksi kantor."},
    {"slug": "teknologi-dan-gadget", "name": "Teknologi, Gadget & Internet", "level": "daily", "icon": "💻", "color_theme": "blue", "sort_order": 16, "description": "Istilah koneksi nirkabel, kata sandi, unduhan data, pengisian daya, dan sistem online."},
    {"slug": "phrasal-verbs-populer", "name": "Phrasal Verbs Wajib Sehari-hari", "level": "daily", "icon": "🔄", "color_theme": "violet", "sort_order": 17, "description": "Gabungan kata kerja + preposisi yang sering digunakan penutur asli saat mengobrol."},
    {"slug": "olahraga-dan-kebugaran", "name": "Olahraga, Gym & Kebugaran", "level": "daily", "icon": "⚽", "color_theme": "amber", "sort_order": 18, "description": "Istilah kebugaran jasmani, latihan gym, pertandingan olahraga, dan kesehatan fisik."},
    {"slug": "hobi-musik-hiburan", "name": "Hobi, Musik, Film & Seni", "level": "daily", "icon": "🎬", "color_theme": "purple", "sort_order": 19, "description": "Aktivitas waktu luang, genre musik, instrumen, menonton bioskop, dan fotografi."},
    {"slug": "pendidikan-dan-kampus", "name": "Pendidikan, Sekolah & Kuliah", "level": "daily", "icon": "🎓", "color_theme": "indigo", "sort_order": 20, "description": "Masa sekolah, perkuliahan, tugas akademik, ujian, beasiswa, dan perpustakaan."},

    # Advanced
    {"slug": "idiom-frasa-populer", "name": "Idiom & Ungkapan Mahir", "level": "advanced", "icon": "💡", "color_theme": "fuchsia", "sort_order": 21, "description": "Frasa kiasan yang digunakan native speaker agar bahasa Inggris terdengar luwes."},
    {"slug": "bisnis-kantor-interview", "name": "Bisnis, Rapat & Wawancara Kerja", "level": "advanced", "icon": "💼", "color_theme": "sky", "sort_order": 22, "description": "Komunikasi profesional, presentasi, negosiasi gaji, dan menjawab pertanyaan wawancara."},
    {"slug": "darurat-medis-kesehatan", "name": "Situasi Darurat & Dokter", "level": "advanced", "icon": "🏥", "color_theme": "red", "sort_order": 23, "description": "Pertolongan pertama, menjelaskan gejala penyakit kepada dokter, dan menelepon ambulans."},
    {"slug": "slang-ungkapan-gaul", "name": "Slang & Percakapan Santai Gaul", "level": "advanced", "icon": "🔥", "color_theme": "amber", "sort_order": 24, "description": "Frasa kasual yang sering dipakai anak muda & native speaker dalam obrolan santai."},
    {"slug": "transisi-dan-konektor", "name": "Kata Transisi & Konektor Mahir", "level": "advanced", "icon": "🔗", "color_theme": "cyan", "sort_order": 25, "description": "Penghubung kalimat formal agar opini, esai, dan presentasi terdengar runut."},
    {"slug": "karakter-dan-sikap", "name": "Karakter, Sikap & Kepribadian", "level": "advanced", "icon": "🧠", "color_theme": "purple", "sort_order": 26, "description": "Mendeskripsikan sifat seseorang, kepercayaan diri, kerendahan hati, dan ketulusan."},
    {"slug": "keuangan-perbankan-investasi", "name": "Keuangan, Investasi & Perbankan", "level": "advanced", "icon": "💳", "color_theme": "teal", "sort_order": 27, "description": "Perbankan modern, rekening tabungan, pasar saham, inflasi, suku bunga, dan modal."},
    {"slug": "hukum-aturan-masyarakat", "name": "Hukum, Aturan & Masyarakat", "level": "advanced", "icon": "⚖️", "color_theme": "slate", "sort_order": 28, "description": "Peradilan hukum, peraturan perundang-undangan, hak asasi warga negara, dan kepatuhan."},
    {"slug": "lingkungan-dan-ekologi", "name": "Lingkungan, Iklim & Ekologi", "level": "advanced", "icon": "🌿", "color_theme": "green", "sort_order": 29, "description": "Perubahan iklim, keberlanjutan bumi, energi terbarukan, dan daur ulang limbah."},
    {"slug": "sains-dan-penelitian", "name": "Sains, Eksperimen & Penemuan", "level": "advanced", "icon": "🔬", "color_theme": "sky", "sort_order": 30, "description": "Metode ilmiah, hipotesis penelitian, analisis data laboratorium, dan inovasi ilmiah."}
]

print(f"Total categories planned: {len(categories)}")
