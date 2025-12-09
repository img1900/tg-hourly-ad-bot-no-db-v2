<?php
require_once __DIR__ . '/config.php';

function tg_send_photo($chat_id, $photoPath, $caption, $inlineKeyboard = null)
{
    global $BOT_TOKEN;
    $url = "https://api.telegram.org/bot{$BOT_TOKEN}/sendPhoto";

    $payload = [
        'chat_id' => $chat_id,
        'caption' => $caption,
        'parse_mode' => 'HTML'
    ];

    if (is_array($inlineKeyboard) && !empty($inlineKeyboard)) {
        $payload['reply_markup'] = json_encode(['inline_keyboard' => $inlineKeyboard], JSON_UNESCAPED_UNICODE);
    }

    $payload['photo'] = curl_file_create($photoPath);

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_TIMEOUT => 20,
    ]);

    $resp = curl_exec($ch);
    curl_close($ch);
    return $resp;
}
