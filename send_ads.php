<?php
require_once __DIR__ . '/telegram.php';
require_once __DIR__ . '/config.php';

date_default_timezone_set('Asia/Taipei');

foreach ($ADS as $ad) {
    if (empty($ad['enabled'])) continue;

    $chat_id = $ad['chat_id'];
    $photo   = $ad['photo'];
    $text    = $ad['text'];
    $buttons = $ad['buttons'];

    // 纵向按钮
    $inlineKeyboard = [];
    foreach ($buttons as $btn) {
        $inlineKeyboard[] = [
            ['text' => $btn['text'], 'url' => $btn['url']]
        ];
    }

    tg_send_photo($chat_id, $photo, $text, $inlineKeyboard);
}
echo "Ads sent.\n";
