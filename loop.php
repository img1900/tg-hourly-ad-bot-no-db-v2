<?php
// loop.php
// 简单的轮询脚本：每小时执行一次 send_ads.php

date_default_timezone_set('Asia/Taipei');

while (true) {
    $now = date('Y-m-d H:i:s');
    echo "[{$now}] Running send_ads.php...\n";

    // 执行一次发送广告脚本
    include __DIR__ . '/send_ads.php';

    // 休眠 3600 秒（1 小时）
    sleep(3600);
}
