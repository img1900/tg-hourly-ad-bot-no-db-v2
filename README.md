# Telegram 自动广告机器人（无数据库版，自动整点发送版）

本项目是一个基于 **PHP + Zeabur + GitHub** 的自动广告发送机器人，使用 `loop.php` 自动对齐到整点运行，无需 Zeabur 定时任务，适用于免费套餐。

---

## 🚀 功能特点

- 自动对齐整点发送广告（例如 00:00、01:00、02:00…）
- 无需 Cron（适配 Zeabur 免费版）
- 支持图片广告 + 文案（caption）
- 支持多个按钮（inline keyboard）
- 配置简单，所有内容在 `config.php` 修改
- 无数据库，轻量稳定、高可用

---

## 📁 项目结构

```
config.php       # 广告配置（chat_id、文案、按钮）
telegram.php     # Telegram API 封装
send_ads.php     # 单次广告发送逻辑
loop.php         # 自动整点执行（核心）
ad_image.jpg     # 广告图片
index.php        # 健康检查
README.md        # 项目说明
```

---

## 🛠️ 部署步骤（Zeabur + GitHub）

### 1. 上传本项目到 GitHub

确保文件结构完整。

---

### 2. 在 Zeabur 新建服务（选择 GitHub 仓库）

Zeabur 会自动识别为 PHP 项目。

---

### 3. 设置环境变量

进入：

```
设置 → 环境变量（Environment Variables）
```

添加：

```
TELEGRAM_BOT_TOKEN=你的BotToken
```

---

### 4. 修改启动命令（非常关键）

进入：

```
设置 → 启动命令（Start Command）
```

填入：

```
php loop.php
```

保存 → 重新部署（Redeploy）

机器人启动后会：

- 自动等待到下一次整点
- 每小时整点执行一次发送任务

---

## 🧠 自动整点发送如何工作？

在 `loop.php` 中：

1. 获取当前时间  
2. 计算距离下一整点的秒数  
3. sleep(剩余秒数)  
4. 进入每小时循环 → sleep(3600)

这样无需 Zeabur Cron，也能做到「每小时整点发送」。

---

## ✏️ 修改广告内容

编辑 `config.php`：

```php
'chat_id' => -100xxxxxxxxxx,    // 群 ID
'photo'   => __DIR__ . '/ad_image.jpg', 
'text'    => "你的广告内容",
'buttons' => [
    ['text' => '按钮1', 'url' => 'https://example.com'],
    ['text' => '按钮2', 'url' => 'https://example.com'],
    ['text' => '按钮3', 'url' => 'https://example.com'],
],
```

可修改内容包括：

- 广告文案  
- 按钮文字 + 链接  
- 群组 chat_id  
- 广告图片（替换 ad_image.jpg）  

---

## ❓ 如何获取 chat_id？

1. 拉机器人进群  
2. 群里随便发一句话  
3. 在浏览器访问：

```
https://api.telegram.org/bot<你的TOKEN>/getUpdates
```

找到：

```
"chat":{"id": -100xxxxxxxx }
```

这就是群组 ID。

---

## 🔍 测试机器人运行

在 Zeabur 控制台：

```
命令 → php send_ads.php
```

群里应立即收到一条广告。

---

## ❤️ 作者说明

本项目由 ChatGPT 辅助生成与优化，支持自由使用、商用与二次开发。

如需扩展功能：

- 多广告轮播  
- 随机广告  
- 指定每日某个小时发送  
- Telegram 菜单  
- Webhook 模式  

都可以继续找我，我会帮你进一步升级你的机器人。
