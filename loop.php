<?php
date_default_timezone_set('Asia/Taipei');

$now = time();
$sec = 3600 - ($now % 3600);
sleep($sec);

while (true) {
    include __DIR__ . '/send_ads.php';
    sleep(3600);
}
