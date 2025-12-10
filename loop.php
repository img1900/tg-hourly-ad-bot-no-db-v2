<?php
// loop.php
// 自动对齐整点，每小时执行一次 send_ads.php

date_default_timezone_set('Asia/Taipei');

echo "Loop started. Timezone: " . date_default_timezone_get() . "\n";

// 1. 启动时先对齐到“下一个整点”
$now = time();
$secondsToNextHour = 3600 - ($now % 3600);
if ($secondsToNextHour > 0 && $secondsToNextHour < 3600) {
    $targetTime = date('Y-m-d H:i:s', $now + $secondsToNextHour);
    echo "Current time: " . date('Y-m-d H:i:s', $now) . "\n";
    echo "Aligning to next full hour at {$targetTime}, sleeping {$secondsToNextHour} seconds...\n";
    sleep($secondsToNextHour);
}

// 2. 进入循环：每个整点执行一次 send_ads.php
while (true) {
    $nowStr = date('Y-m-d H:i:s');
    echo "[{$nowStr}] Running send_ads.php...\n";

    include __DIR__ . '/send_ads.php';

    // 休眠 3600 秒，等下一个整点
    sleep(3600);
}
