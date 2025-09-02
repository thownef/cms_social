# Social API

Laravel-based backend for a social networking application with real-time messaging powered by Laravel Reverb.

## Features

- **Authentication**: API auth via Sanctum.
- **User Profiles**: Profile details, avatar, work history.
- **Friends & Requests**: Send/accept/decline friend requests, manage friends.
- **Posts**: Create/view/delete posts, file uploads (S3-ready).
- **Conversations & Messages**: Private conversations, message attachments.
- **Real-time**: WebSocket broadcasting with Laravel Reverb (`online`, `conversation.{conversationId}`).

## Requirements

- PHP 8.2+, Composer
- MySQL/MariaDB (or your configured DB)
- Node.js 18+ (optional, for assets)
- Redis (optional, only if you enable Reverb scaling)

## Setup

```bash
# Install PHP dependencies
composer install

# (Optional) Install frontend dependencies
npm install
```

Create environment file:
```bash
cp .env.example .env
```
BROADCAST_CONNECTION=reverb

Generate APP_KEY:
```bash
php artisan key:generate
```

Set up your database in `.env`, then migrate and seed:
```bash
php artisan migrate --seed
```

## Run

Open 2–3 terminal windows.

1) API (HTTP):
```bash
php artisan serve
```

2) WebSocket (Reverb):
```bash
php artisan reverb:start
```

3) Queue (optional, if you broadcast via queue or have jobs):
```bash
php artisan queue:work
```

4) Assets dev server (optional):
```bash
npm run dev
```
```

- Replaced the README with an English intro, feature list, and minimal run commands (no code-level configuration details).