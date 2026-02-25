# Laravel_prototype

## Overview & Background / 概要と背景


## Directory Structure / ディレクトリ構成

```
.
├── app/                        # Laravel アプリケーションコード
│   ├── Http/Controllers/
│   ├── Models/
│   └── Providers/
├── bootstrap/                  # Laravel 起動設定
├── config/                     # 各種設定ファイル
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docker/                     # Docker 設定
│   ├── nginx/default.conf      # Nginx 設定
│   ├── nuxt/Dockerfile         # Nuxt コンテナ
│   └── php/Dockerfile          # PHP-FPM コンテナ
├── frontend/                   # Nuxt 4 フロントエンド
│   ├── plugins/
│   │   └── apollo.client.ts    # Apollo Client (GraphQL) 設定
│   ├── app.vue
│   ├── nuxt.config.ts
│   └── package.json
├── graphql/
│   └── schema.graphql          # Lighthouse GraphQL スキーマ
├── routes/
│   ├── api.php
│   └── web.php
├── .env.example
└── docker-compose.yml
```

## Getting Started / 起動方法

### 必要環境

- Docker / Docker Compose

### 手順

**1. 環境変数ファイルを作成**

```bash
cp .env.example .env
cp frontend/.env.example frontend/.env
```

**2. コンテナをビルド・起動**

```bash
docker compose up -d --build
```

**3. マイグレーションを実行（初回のみ）**

```bash
docker compose exec app php artisan migrate
```

### アクセス先

| サービス | URL |
|---------|-----|
| Laravel (GraphQL) | http://localhost:8000/graphql |
| Nuxt (フロントエンド) | http://localhost:3000 |

### よく使うコマンド

```bash
# コンテナ停止
docker compose down

# ログ確認
docker compose logs -f

# Laravel artisan
docker compose exec app php artisan <command>

# Nuxt
docker compose exec nuxt npm run <command>
```
