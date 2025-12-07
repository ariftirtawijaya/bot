<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json; charset=utf-8');
require_once "config.php";
require_once "helpers.php";

// Ambil data webhook Fonnte
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// Simpan ke log
file_put_contents("logs/webhook.log", date("Y-m-d H:i:s") . " | " . $raw . "\n", FILE_APPEND);

// Ambil variabel penting
$sender = $data['sender'];
$name = $data['name'];
$message = strtolower(trim($data['message']));

// ==========================
//   MENU BOT RELAYLAB
// ==========================

// 1. Menu Utama
if (in_array($message, ["menu", "start", "halo", "hi", "hai"])) {
    sendMessage(
        $sender,
        "Halo *$name*! 👋\nSelamat datang di *RelayLab Autolight*.\n\nSilakan pilih menu:",
        [
            "button" => "Menu|Cek Harga Relay|Cek Stok|Hubungi Admin"
        ]
    );
    exit;
}

// 2. Cek Harga Relay
if ($message == "cek harga relay") {
    sendMessage(
        $sender,
        "*Daftar Harga RelayLab Autolight*\n\n" .
        "• Foglamp Standard : 146.000\n" .
        "• Foglamp Auto Off Devil : 176.000\n" .
        "• Headlamp Motor : 150.000\n" .
        "• Headlamp Mobil : 219.000\n"
    );
    exit;
}

// 3. Cek Stok (Integrasi DB bisa ditambahkan)
if ($message == "cek stok") {
    sendMessage(
        $sender,
        "Silakan masukkan *kode produk* untuk cek stok.\n\nContoh:\n`H11`, `HB3`, `Foglamp Standard`"
    );
    exit;
}

// 4. Hubungi Admin
if ($message == "hubungi admin") {
    sendMessage(
        $sender,
        "Silakan chat admin:\nhttps://wa.me/" . ADMIN_NUMBER
    );
    exit;
}

// 5. Jika user memberikan kode produk (otomatis cek stok dari DB)
if (preg_match("/^[a-zA-Z0-9 ]+$/", $message)) {

    // ==== NANTI DI SINI BISA DISAMBUNGKAN KE DATABASE ====
    // Contoh jawaban dummy
    sendMessage(
        $sender,
        "Cek stok untuk *$message*:  
Masih tersedia 12 pcs 👍  
Jika ingin pesan silakan klik tombol di bawah:",
        [
            "button" => "Aksi|Pesan Sekarang|Kembali ke Menu"
        ]
    );
    exit;
}

// 6. Fallback (default reply)
sendMessage(
    $sender,
    "Maaf, saya tidak mengerti perintah tersebut.\nSilakan pilih menu:",
    [
        "button" => "Menu|Cek Harga Relay|Cek Stok|Hubungi Admin"
    ]
);
