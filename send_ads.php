<?php
require_once __DIR__ . '/telegram.php';
require_once __DIR__ . '/config.php';

date_default_timezone_set('Asia/Taipei');

foreach ($ADS as $ad) {
    if (empty($ad['enabled'])) continue;

    $chat_id = $ad['chat_id'];
    $text = $ad['text'];
    $buttons = $ad['buttons'];
    $photo = $ad['photo'];

    $inlineKeyboard = [];
    $row=[];
    foreach($buttons as $b){
        $row[]=['text'=>$b['text'],'url'=>$b['url']];
    }
    $inlineKeyboard[]=$row;

    tg_send_photo($chat_id, $photo, $text, $inlineKeyboard);
}

echo "Ads sent.";
