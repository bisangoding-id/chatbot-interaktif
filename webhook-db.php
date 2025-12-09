<?php

// ========================
// 1. KONFIGURASI DASAR
// ========================
$API_KEY = "**"; 
$mysqli = @new mysqli("localhost", "root", "", "chatbot");
if ($mysqli->connect_error) exit;

// ========================
// 2. AMBIL DATA WEBHOOK
// ========================
$raw  = file_get_contents("php://input");
$data = json_decode($raw, true);
if (!$data) exit;

$from  = $data["sender"] ?? "";
$text  = trim($data["message"] ?? "");
$name  = trim($data["name"] ?? "");
$lower = strtolower($text);


// ========================
// 3. FUNGSI KIRIM PESAN
// ========================
function reply($to, $msg, $API_KEY, $footer = true){

    if ($footer) {
        $msg .= "\n\nKetik *0* untuk melihat menu informasi lainnya";
    }

    $ch = curl_init("https://api.fonnte.com/send");
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => ["Authorization: $API_KEY"],
        CURLOPT_POSTFIELDS => ["target"=> $to, "message" => $msg]
    ]);
    curl_exec($ch);
    curl_close($ch);
}


// ========================
// 4. CEK USER DI DATABASE
// ========================
$user = $mysqli->query("SELECT name, step FROM user_state WHERE phone='$from'")->fetch_assoc();

if ($user) {
    $savedName = $user["name"];
    $step      = $user["step"];
} else {
    $mysqli->query("INSERT INTO user_state (phone, step) VALUES ('$from','tanya_nama')");
    $savedName = "";
    $step      = "tanya_nama";
}


// ========================
// 5. AMBIL MENU DARI DATABASE
// ========================
$MENU_TEXT = "";
$menuMap   = [];

$q = $mysqli->query("SELECT id, keyword FROM qa_list  ORDER BY id ASC");
while ($row = $q->fetch_assoc()) {
    $id  = (string)$row["id"];
    $key = strtolower(trim($row["keyword"]));

    if ($id == "7" || $key == "terima kasih") {
        continue;
    }
    
    $MENU_TEXT .= "$id. " . ucfirst($key) . "\n";
    $menuMap[$id] = $key;
}


// ========================
// 6. USER PILIH MENU ("0")
// ========================
if ($lower === "0") {
    reply($from, "Silakan pilih informasi berikut:\n\n$MENU_TEXT", $API_KEY, false);
    $mysqli->query("UPDATE user_state SET updated_at = NOW() WHERE phone='$from'");
    exit;
}


// ========================
// 7. ALUR PERCAPAKAN (STEP)
// ========================
switch ($step) {

    // MINTA NAMA
    case "tanya_nama":
        reply($from, "Halo ka, boleh disebutkan namanya? 😊", $API_KEY, false);
        $mysqli->query("UPDATE user_state SET step='simpan_nama' WHERE phone='$from'");
        exit;


    // SIMPAN NAMA USER
    case "simpan_nama":

        $nama_baru = ucfirst($text);
        $mysqli->query("UPDATE user_state 
                        SET name='$nama_baru', step='menu', updated_at=NOW() 
                        WHERE phone='$from'");

        reply($from,
            "Hai *$nama_baru*, selamat datang di Vilaza Kost! 😊\n\nAda yang bisa kami bantu ka?",
            $API_KEY,
            false
        );
        exit;
}


// =========================================
// 8. MENU UTAMA (PENCARIAN KEYWORD DATABASE)
// =========================================

$search = $menuMap[$lower] ?? $lower;
$words = explode(" ", strtolower($search));

$replyMsg = "";
$found = false;

foreach ($words as $word) {
    $word = $mysqli->real_escape_string($word);

    $query = $mysqli->query("
        SELECT response FROM qa_list 
        WHERE 
            FIND_IN_SET('$word', variations)
            OR keyword = '$word'
        LIMIT 1
    ");

    if ($row = $query->fetch_assoc()) {
        $replyMsg = $row['response'];
        $found = true;
        break;
    }
}

if (!$found) {
    $replyMsg = 
        "Maaf ka, aku belum menemukan jawabannya 😅\n\n".
        "Mungkin bisa dipilih informasi berikut:\n\n$MENU_TEXT";
}

reply($from, $replyMsg, $API_KEY, false);

$mysqli->query("UPDATE user_state SET updated_at = NOW() WHERE phone='$from'");

exit;

?>
