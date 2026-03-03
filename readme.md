# Laravel_prototype

## Overview & Background / 概要と背景


## Tech Stack / 使用技術
- Frontend / フロントエンド：Nuxt 4.x / TypeScript / Apollo Client v3 / @vue/apollo-composable v4
- Backend / バックエンド：Laravel 12.x (PHP 8.4) / Lighthouse 6.x (GraphQL API)
- Database / データベース：MySQL 8.0
- Cache / キャッシュ：Redis 7
- Infrastructure / インフラ：Docker / Docker Compose / Nginx
- Version / バージョン管理：GitHub

## Directory Structure / ディレクトリ構成

```
.
├── app/                        # Laravel アプリケーション (DDD / Layered Architecture)
│   ├── Http/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
│   ├── cors.php                # CORS 設定
│   └── lighthouse.php          # Lighthouse 設定
├── database/
│   ├── migrations/
│   └── seeders/
├── docker/                     # Docker 設定
│   ├── nginx/default.conf      # Nginx 設定
│   ├── nuxt/Dockerfile         # Nuxt コンテナ共通
│   └── php/Dockerfile          # PHP-FPM コンテナ
├── graphql/
│   └── schema.graphql          # Lighthouse GraphQL スキーマ
├── hp/                         # Nuxt 4 公開HP (port 3001)
│   ├── assets/css/             # グローバルCSS
│   ├── components/common/      # 共通コンポーネント
│   ├── composables/            # カスタム composables
│   ├── layouts/                # レイアウト
│   ├── pages/                  # ページ
│   ├── public/images/          # 静的画像
│   ├── plugins/
│   │   └── apollo.client.ts    # Apollo Client 設定
│   └── nuxt.config.ts
├── admin-portal/               # Nuxt 4 管理画面 (port 3000)
│   ├── components/
│   ├── pages/
│   ├── plugins/
│   │   └── apollo.client.ts    # Apollo Client 設定
│   └── nuxt.config.ts
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
| 公開HP | http://localhost:3001 |
| 管理画面 | http://localhost:3000 |

### よく使うコマンド

```bash
# コンテナ停止
docker compose down

# ログ確認
docker compose logs -f

# Laravel artisan
docker compose exec app php artisan <command>

# 公開HP (Nuxt)
docker compose exec hp npm run <command>

# 管理画面 (Nuxt)
docker compose exec admin-portal npm run <command>
```
