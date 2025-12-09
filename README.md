# Telegram 自动发广告机器人（无数据库版）

一个基于 **PHP + Zeabur + GitHub** 的轻量级 Telegram 自动发广告机器人。

特点：

- 纯文件配置 **无需数据库**
- 支持 **定时自动发送广告**
- 支持 **发送图片广告（sendPhoto）**
- 广告可附带 **多个按钮（inline keyboard）**
- 广告内容统一写在 `config.php`，非常容易修改
- 适合 Zeabur 定时任务部署

---

## 🚀 功能说明

该机器人支持：

- 每小时自动发送广告（可通过定时任务调整频率）
- 自动发送图片 + 文案（caption）
- 文案支持 HTML 格式，如 `<code>` 用于可复制地址
- 三个按钮（可自行修改文本和链接）
- 支持多条广告（自由扩展）

---

## 📦 项目结构

```
├── config.php         # 广告内容配置（重点）
├── telegram.php       # 与 Telegram API 交互
├── send_ads.php       # 定时执行入口
├── ad_image.jpg       # 广告图片
├── index.php          # 健康检查页面
├── .gitignore
└── README.md
```

---

## ✏️ 如何修改广告内容？

所有广告内容都在 `config.php`：

- 修改文案（text）
- 修改图片（photo）
- 修改按钮（text + url）
- 启用/禁用广告（enabled）

你不需要懂 PHP，只改里面的值即可。

---

## 🧩 config.php 示例（简化版）

```php
$ADS = [
    [
        'chat_id' => -1001234567890,          // 群组ID
        'type'    => 'photo',                 // photo 或 text
        'photo'   => __DIR__ . '/ad_image.jpg',
        'text'    => "这里写广告文案",
        'buttons' => [
            ['text' => '按钮1', 'url' => 'https://example.com'],
            ['text' => '按钮2', 'url' => 'https://example.com'],
            ['text' => '按钮3', 'url' => 'https://example.com'],
        ],
        'enabled' => true
    ],
];
```

修改完成后 **推送到 GitHub**，Zeabur 会自动重新部署。

---

## 🌐 如何部署到 Zeabur？

### **1️⃣ 上传项目到 GitHub**

把 zip 解压 → 用 Git 推送到你的仓库。

---

### **2️⃣ Zeabur 创建服务**

- New Service → Import from GitHub  
- 自动识别 PHP → 部署成功后打开 service

---

### **3️⃣ 设置环境变量**

进入：

```
Settings → Environment Variables
```

添加：

```
TELEGRAM_BOT_TOKEN=你的机器人token
```

---

### **4️⃣ 配置定时任务（Scheduled Jobs）**

进入：

```
Scheduled Jobs → Add Job
```

Command 填：

```
php /app/send_ads.php
```

Cron 时间可以设置为：

```
0 * * * *   # 每小时执行一次
```

---

## 🔍 测试是否正常运行

在 Zeabur 控制台运行：

```
php /app/send_ads.php
```

若群组收到广告，说明一切正常。

---

## ❓ 如何获取群组 chat_id？

1. 把机器人拉进群组  
2. 发一条消息  
3. 浏览器打开：

```
https://api.telegram.org/bot<你的TOKEN>/getUpdates
```

4. 查找：

```
message.chat.id
```

这就是群组 ID。

---

## 📄 开源协议 & 备注

该项目为简单自动化脚本，你可自由修改、商用或扩展功能。

如需增加更多广告、定时配置、按钮样式、图片轮播等功能，可联系 ChatGPT 帮助你继续扩展。

---

## ❤️ 作者

本项目由 ChatGPT 协助自动生成，并根据你的广告需求定制。

如需继续优化机器人、加入多广告轮播、多语种版本、或者添加用户交互功能，我可以继续协助。
