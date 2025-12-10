# Telegram 自动广告机器人（纵向按钮 + 自动整点发送版）

本项目是一个基于 **PHP + Telegram Bot API + Zeabur + GitHub** 的自动化广告机器人，适配 **Zeabur 免费版**，无需 Cron 定时任务、无需数据库。

核心特性：

- 📸 发送「图片 + 文案」形式的广告
- 🔽 按钮为**纵向排列**（一行一个按钮，更适合移动端点击）
- ⏰ 使用 `loop.php` 自动对齐到 **整点**，每小时自动发送一次
- 🧩 所有业务配置集中在 `config.php`，方便修改和复制
- 🧱 代码结构简单，方便二次开发和扩展

---

## 1️⃣ 项目文件结构说明

```
config.php        # 广告配置（群ID、文案、按钮、图片路径）
telegram.php      # 与 Telegram Bot API 交互（sendPhoto）
send_ads.php      # 发送一轮广告（读取 config.php）
loop.php          # 自动整点循环执行 send_ads.php
ad_image.jpg      # 广告配图
index.php         # 健康检查页面（浏览器访问用）
README.md         # 使用说明（本文件）
```

---

## 2️⃣ 核心运行原理

### (1) 广告配置：`config.php`

- 配置机器人要发到哪个群（`chat_id`）
- 配置广告文案（`text`）
- 配置图片路径（`photo`）
- 配置按钮文字和链接（`buttons`）
- 打开/关闭某条广告（`enabled`）

**你当前版本的 `config.php` 内容大致如下：**

```php
<?php
$BOT_TOKEN = getenv('TELEGRAM_BOT_TOKEN');

// 广告配置
$ADS = [
    [
        'chat_id' => -1003220922535,   // 你的群ID
        'type' => 'photo',
        'photo' => __DIR__ . '/ad_image.jpg',

        'text' => "✈️转账  3  TRX= 1笔能量—6TRX=2笔能量
➖➖➖➖➖➖➖➖➖
💎 使用指南
转  3 TRX 到下面地址，3秒后再去转U不再扣 TRX手续费！

<code>TCFbXKE25Q8iRu55fkqz8vxV7pvepyAnkz</code> （点击地址自动复制）
",

        'buttons' => [
            ['text' => '🔗 3TRX能量', 'url' => 'https://t.me/lanmaonlBot'],
            ['text' => '🤖 TG大会员', 'url' => 'https://t.me/asd89894'],
            ['text' => '💬 联系客服', 'url' => 'https://t.me/asd89894'],
        ],

        'enabled' => true,
    ],
];
```

如需调整内容：

- 修改 `chat_id` → 发送到其他群
- 修改 `text` → 替换文案
- 修改 `buttons` → 替换按钮文字和链接
- 修改 `photo` → 指向其他图片文件

---

### (2) 发送逻辑：`send_ads.php`

- 载入 `config.php`
- 遍历 `$ADS` 数组中所有 `enabled = true` 的广告
- 对每条广告：
  - 构造「纵向排列」按钮
  - 调用 `tg_send_photo()` 发送图片 + 文案 + 按钮

按钮纵向排列逻辑示例（伪代码简化）：

```php
$inlineKeyboard = [];
foreach ($buttons as $btn) {
    $inlineKeyboard[] = [
        ['text' => $btn['text'], 'url' => $btn['url']]
    ];
}
```

最终在 Telegram 中显示效果为：

```
[ 🔗 3TRX能量 ]
[ 🤖 TG大会员 ]
[ 💬 联系客服 ]
```

---

### (3) 自动整点执行：`loop.php`

由于 Zeabur 免费版没有 Cron 定时任务，这里使用了一个简单的 **循环调度器**：

1. 启动时：
   - 获取当前时间（秒）
   - 计算距离下一整点还剩多少秒
   - `sleep(剩余秒数)`，等待到整点
2. 进入死循环：
   - 每次执行一次 `send_ads.php`
   - 然后 `sleep(3600)` 等待下一个小时

示意逻辑如下：

```php
date_default_timezone_set('Asia/Taipei');

// 对齐整点
$now = time();
$sec = 3600 - ($now % 3600);
sleep($sec);

// 定时循环
while (true) {
    include __DIR__ . '/send_ads.php';
    sleep(3600);
}
```

这样，即便没有 Zeabur 的定时任务，也可以实现「每小时整点自动发一次广告」。

---

## 3️⃣ 部署步骤（Zeabur + GitHub）

### 步骤 1：上传代码到 GitHub

1. 新建一个 GitHub 仓库
2. 把这些文件上传：
   - config.php
   - telegram.php
   - send_ads.php
   - loop.php
   - ad_image.jpg
   - index.php
   - README.md
3. 确认 `config.php` 里的 `chat_id`、文案、按钮配置正确无误。

---

### 步骤 2：在 Zeabur 通过 GitHub 创建服务

1. 登录 Zeabur
2. 点击 **新建服务**
3. 选择 **GitHub 仓库**
4. 选择对应仓库（你上传本项目的那个）
5. 等待部署完成

---

### 步骤 3：配置环境变量

进入：

> 服务 → 设置（Settings）→ 环境变量（Environment Variables）

添加：

```text
TELEGRAM_BOT_TOKEN = 你的机器人 Token
```

> Bot Token 来自 `@BotFather` 创建机器人时提供的字符串。

---

### 步骤 4：修改启动命令（非常重要）

进入：

> 服务 → 设置（Settings）→ 启动命令（Start Command）

填入：

```bash
php loop.php
```

保存后，**重新部署（Redeploy）** 服务。

- 服务启动后会先 sleep 到下一个整点
- 然后在每个整点执行一次 `send_ads.php`

---

## 4️⃣ 如何测试是否正常工作？

### 方法一：命令行测试

在 Zeabur 服务的「命令 / Console」界面执行：

```bash
php send_ads.php
```

如果一切正常：

- 你所在的群 `-1003220922535` 会立即收到一条广告（图片 + 文案 + 纵向按钮）

---

### 方法二：查看日志

进入：

> 服务 → 日志（Logs）

你应该能看到类似输出：

```text
[2025-12-10 10:00:00] Sending Ad #0 to chat -1003220922535...
Ads sent.
```

如果有错误（例如 Token 不对、图片不存在等），也会在这里显示。

---

## 5️⃣ 常见问题 & 排查

### ❓ 1. 群里没有收到消息？

检查：

1. `chat_id` 是否是群 ID？  
   - 群组 ID 一般形如 `-100xxxxxxxxxx`
   - 可通过访问 `https://api.telegram.org/bot<你的TOKEN>/getUpdates` 获取

2. 机器人是否加入群组？是否被禁言？

3. `TELEGRAM_BOT_TOKEN` 是否配置正确？

4. `ad_image.jpg` 是否确实存在于项目根目录？文件名是否对？

---

### ❓ 2. 按钮没有显示成纵向？

确认你使用的是当前版本的 `send_ads.php`，且按钮在 `config.php` 中以 **一维数组** 形式配置：

```php
'buttons' => [
    ['text' => '🔗 3TRX能量', 'url' => 'https://t.me/lanmaonlBot'],
    ['text' => '🤖 TG大会员', 'url' => 'https://t.me/asd89894'],
    ['text' => '💬 联系客服', 'url' => 'https://t.me/asd89894'],
],
```

而不是已经预先嵌套为二维结构（不需要你来嵌套，脚本会自动处理）。

---

### ❓ 3. 想添加第二条广告怎么办？

只要在 `$ADS` 里再加一个数组即可：

```php
$ADS = [
    [ /* 第一条广告 */ ],
    [ /* 第二条广告 */ ],
];
```

脚本会在每次整点 **依次发送所有 enabled = true 的广告**。

---

## 6️⃣ 可扩展方向（如果以后要升级）

- 支持多种广告类型（文字广告 / 图片广告 / 视频广告）
- 支持不同时间段发送不同广告
- 支持随机广告轮播，避免内容单一
- 增加简单的日志记录到文件
- 增加 Webhook 接入，实现「命令控制 + 自动投放」一体化

---

## 7️⃣ 作者说明

本项目当前版本已为你的业务进行了定制：

- 已写入你的专属文案  
- 已配置你的按钮链接  
- 已适配纵向按钮展示  
- 已适配 Zeabur 免费版（使用 loop.php 自动整点发送）

如需后续：

- 多机器人版本
- 多群、多广告位管理
- 更复杂调度规则（如某个时间段暂停、某些小时不发）
- 统计点击/转化（可结合短链或跳转页）

都可以基于当前结构继续演进。
