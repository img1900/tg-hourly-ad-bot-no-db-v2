<?php
$BOT_TOKEN = getenv('TELEGRAM_BOT_TOKEN');

$ADS = [
    [
        'chat_id' => -1003220922535,
        'type' => 'photo',
        'photo' => __DIR__ . '/ad_image.jpg',
        'text' => "✈️转账  3  TRX= 1笔能量—6TRX=2笔能量
➖➖➖➖➖➖➖➖➖
💎 使用指南
转  3 TRX 到下面地址，3秒后再去转U不再扣 TRX手续费！

<code>TCFbXKE25Q8iRu55fkqz8vxV7pvepyAnkz</code> （点击地址自动复制）
",
        'buttons' => [
            ['text' => '按钮1', 'url' => 'https://example.com'],
            ['text' => '按钮2', 'url' => 'https://example.com'],
            ['text' => '按钮3', 'url' => 'https://example.com'],
        ],
        'enabled' => true,
    ],
];
