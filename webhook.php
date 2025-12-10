<?php

//Terima data dari API
$input = json_decode(file_get_contents("php://input"), true);

$from = $input["sender"] ?? "";
$text = strtolower(trim($input["message"] ?? ""));
$name = $input["name"] ?? "customer";

if (!$input){ echo "No Data"; exit; }


//Fungsi balas pesan
$API_KEY = "6RtjpBVYHSwFTCrBHxs7"; //Sesuaikan token API nya

function reply($to, $msg, $API_KEY){

    $ch = curl_init("https://api.fonnte.com/send");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Authorization: $API_KEY"],
        CURLOPT_POSTFIELDS => [
            "target"  => $to,
            "message" => $msg
        ]
    ]);
    curl_exec($ch);
    curl_close($ch);
}

//Ambil state percakapan dari file JSON
$state_file = "state.json";
$state = file_exists($state_file)
    ? json_decode(file_get_contents($state_file), true)
    : [];

if (!isset($state[$from])) {
    $state[$from] = ["step" => "tanya_nama"];
}

$step = $state[$from]["step"];

//LOGIKA PROSES PERCAKAPAN

$MENU =
"1. Ketersediaan kamar\n".
"2. Harga\n".
"3. Fasilitas\n".
"4. Lokasi\n".
"5. Foto kamar\n".
"6. Cara Reservasi";


//1. Bot tanya nama user diawal percakapan
if ($step === "tanya_nama") {
    reply($from, "Halo ka, boleh disebutkan namanya? 😊", $API_KEY);
    $state[$from]["step"] = "dapat_nama";
}

//2. Simpan nama user
elseif ($step === "dapat_nama") {

    $state[$from]["nama"] = ucfirst($text);

    reply($from,
        "Hai *{$state[$from]['nama']}*, selamat datang di Vilaza Kost! \n\n".
        "Ada yang bisa kami bantu ka?",
        $API_KEY);

    $state[$from]["step"] = "menu";
}

// Jawab pertanyaan berdasarkan keyword

elseif ($step === "menu") {

    // Tentukan keyword dari input user
    $map = [
        "1" => "ketersediaan",
        "2" => "harga",
        "3" => "fasilitas",
        "4" => "lokasi",
        "5" => "foto",
        "6" => "reservasi"
    ];
    if (isset($map[$text])) $text = $map[$text];

    // Buat variasi keyword
    $keywords = [
        "ketersediaan" => ["kamar", "kosong", "available", "ready"],
        "harga"       => ["harga","biaya"],
        "fasilitas"   => ["fasilitas"],
        "lokasi"      => ["lokasi", "alamat"],
        "foto"        => ["foto", "gambar"],
        "reservasi"   => ["reservasi", "booking", "sewa"]
    ];

    foreach ($keywords as $key => $arr) {
        foreach ($arr as $word) {
            if (strpos($text, $word) !== false) {
                $text = $key;
                break 2;
            }
        }
    }

    //Jawab pertanyaan berdasarkan keyword
    switch ($text) {

        case "ketersediaan":
            reply($from, "Untuk ketersediaan kamar bisa dicek saat reservasi ya ka, ketik aja 6 untuk reservasi 😊", $API_KEY);
            break;

        case "harga":
            reply($from, "Harga kamar mulai dari *Rp.1.400.000/bulan* \n\nKamar bisa ditempati maksimal 2 orang ya ka, tapi ada tambahan biayanya *Rp.200.000/bulan*", $API_KEY);
            break;

        case "fasilitas":
            reply($from,
                "*Fasilitas Vilaza Kost:*\n".
                "• Kamar AC\n• Free Wifi\n• Kamar mandi dalam\n• Kasur & Dipan\n• Meja & Kursi\n• Lemari\n• Smart TV",
                $API_KEY);
            break;

        case "lokasi":
            reply($from,
                "Ini lokasi Vilaza Kost kak:\nhttps://maps.app.goo.gl/8kVPN1ciGkFr6C5K9",
                $API_KEY);
            break;

        case "foto":
            $FOTO = "https://ibb.co.com/album/SNg510";

            reply($from,
                "Berikut foto kamar ya kak 😊\n\n🖼️ $FOTO\n\n(Klik untuk melihat gambarnya)",
                $API_KEY);
            break;

        case "reservasi":
            reply($from,
                "Untuk reservasi silahkan isi data berikut ya kak 😊\n\n".
                "🔗 https://forms.gle/a7ppvMU1cxn1dmfZ8\n\n".
                "Jika datanya sudah diisi, kami akan segera menghubungi kembali 🙏",
                $API_KEY);
            break;

        default:
            reply($from,
                "Maaf ka, aku belum paham maksudnya 😅\n\nMungkin bisa dipilih informasi berikut:\n$MENU\n\nBisa ketik aja nomornya ya ka",
                $API_KEY);
    }
}


//Simpan histori dan step user di file JSON
file_put_contents($state_file, json_encode($state, JSON_PRETTY_PRINT));

echo "OK";
?>
