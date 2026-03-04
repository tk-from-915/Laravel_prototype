# Laravel_prototype

## Overview & Background / 概要と背景

Laravel + Nuxt による Web アプリケーションのプロトタイプ。
バックエンドは Laravel 12 + Lighthouse による GraphQL API、フロントエンドは公開HP（hp/）と管理画面（admin-portal/）の 2 つの Nuxt 4 アプリで構成される。

バックエンドは **DDD（ドメイン駆動設計）/ Layered Architecture / 軽量CQRS** を採用し、ビジネスロジックをフレームワークから独立させることを基本方針とする。


## Architecture Desigh / 全体アーキテクチャ設計

### Dependency Direction / 依存方向（絶対ルール）

```
Presentation → Application → Domain ← Infrastructure
```

| Layer | 役割 | 依存してよいもの |
|-------|------|-----------------|
| **Presentation** | GraphQL リゾルバー（Lighthouse） | Application のみ |
| **Application** | ユースケース（Command / Query / Handler） | Domain のみ |
| **Domain** | ビジネスルール（Entity / ValueObject / Repository I/F） | 誰にも依存しない（純粋 PHP） |
| **Infrastructure** | 技術実装（Eloquent / Repository 実装 / Bus） | Domain のインターフェースを実装する |

### Tech Stack / 使用技術
```
- Frontend / フロントエンド：Nuxt 4.x / TypeScript / Apollo Client v3 / @vue/apollo-composable v4
- Backend / バックエンド：Laravel 12.x (PHP 8.4) / Lighthouse 6.x (GraphQL API)
- Database / データベース：MySQL 8.0
- Cache / キャッシュ：Redis 7
- Infrastructure / インフラ：Docker / Docker Compose / Nginx
- Version / バージョン管理：GitHub
```

### Directory Structure / ディレクトリ構成
```
.
├── app/                        # Laravel アプリケーション (DDD / Layered Architecture)
│   ├── GraphQL/                # Presentation Layer（Lighthouse リゾルバー）
│   │   ├── Mutations/          # Write 系リゾルバー（Command を dispatch）
│   │   │   ├── Content/
│   │   │   ├── Product/
│   │   │   ├── User/
│   │   │   ├── Contact/
│   │   │   └── Page/
│   │   └── Queries/            # Read 系リゾルバー（Query を dispatch）
│   │       ├── Content/
│   │       ├── Product/
│   │       ├── User/
│   │       ├── Contact/
│   │       └── Page/
│   ├── Application/            # Application Layer（ユースケース）
│   │   ├── Shared/
│   │   │   ├── Bus/
│   │   │   │   ├── CommandBusInterface.php
│   │   │   │   └── QueryBusInterface.php
│   │   │   └── DTO/
│   │   │       └── PaginationInput.php
│   │   ├── Content/
│   │   │   ├── Commands/
│   │   │   │   ├── CreatePost/
│   │   │   │   │   ├── CreatePostCommand.php
│   │   │   │   │   └── CreatePostHandler.php
│   │   │   │   ├── UpdatePost/
│   │   │   │   └── DeletePost/
│   │   │   └── Queries/
│   │   │       ├── GetPost/
│   │   │       │   ├── GetPostQuery.php
│   │   │       │   ├── GetPostHandler.php
│   │   │       │   └── PostDTO.php    # Read Model（Domain Entity ではなく軽量 DTO）
│   │   │       └── ListPosts/
│   │   ├── Product/
│   │   ├── User/
│   │   ├── Contact/
│   │   └── Page/
│   ├── Domain/                 # Domain Layer（ビジネスルール・純粋 PHP）
│   │   ├── Content/
│   │   │   ├── Entities/
│   │   │   │   └── Post.php
│   │   │   ├── ValueObjects/
│   │   │   │   ├── PostId.php
│   │   │   │   ├── PostTitle.php
│   │   │   │   ├── PostBody.php
│   │   │   │   ├── PostStatus.php  # enum: DRAFT / PUBLISHED
│   │   │   │   └── PostType.php    # enum: NEWS / BLOG
│   │   │   └── Repositories/
│   │   │       └── PostRepositoryInterface.php
│   │   ├── Product/
│   │   ├── User/
│   │   ├── Contact/
│   │   └── Page/
│   ├── Infrastructure/         # Infrastructure Layer（技術実装）
│   │   ├── Bus/
│   │   │   ├── LaravelCommandBus.php   # DB::transaction を自動適用
│   │   │   └── LaravelQueryBus.php
│   │   └── Persistence/
│   │       ├── Eloquent/               # Eloquent モデル（DB アクセス専用）
│   │       │   ├── PostModel.php
│   │       │   ├── ProductModel.php
│   │       │   └── UserModel.php
│   │       └── Repositories/           # Repository インターフェースの実装
│   │           ├── EloquentPostRepository.php
│   │           ├── EloquentProductRepository.php
│   │           └── EloquentUserRepository.php
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
├── graphql/                    # Lighthouse GraphQL スキーマ（ドメイン別に分割管理）
│   ├── schema.graphql          # エントリポイント（#import で各ファイルを読み込み）
│   ├── content.graphql
│   ├── product.graphql
│   ├── user.graphql
│   ├── contact.graphql
│   └── page.graphql
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

### DataFlow / データフロー
```
Write（Command）
  GraphQL Mutation
    ↓
  CreatePostMutation（Resolver）
    ↓ CommandBus::dispatch(CreatePostCommand)
  CreatePostHandler::handle()
    ↓ DBトランザクション自動適用（Bus内）
  PostRepositoryInterface::save(Post $entity)
    ↓ DIコンテナで解決
  EloquentPostRepository → PostModel → DB

  Read（Query）
  GraphQL Query
    ↓
  GetPostResolver
    ↓ QueryBus::dispatch(GetPostQuery)
  GetPostHandler::handle()
    ↓
  PostRepositoryInterface::findById(PostId)
    ↓
  EloquentPostRepository → PostModel → DB
    ↓ Domain EntityではなくDTOを返す（読み取り最適化）
  PostDTO → Resolver → GraphQL Response
```

### Naming Conventions / 命名規則

| 種別 | 規則 | 例 |
|------|------|----|
| GraphQL Mutation Resolver | `{動詞}{Entity}Mutation` | `CreatePostMutation` |
| GraphQL Query Resolver | `{Get\|List}{Entity}Resolver` | `GetPostResolver`, `ListPostsResolver` |
| Command | `{動詞}{Entity}Command` | `CreatePostCommand` |
| Command Handler | `{動詞}{Entity}Handler` | `CreatePostHandler` |
| Query | `{Get\|List}{Entity}Query` | `GetPostQuery`, `ListPostsQuery` |
| Query Handler | `{Get\|List}{Entity}Handler` | `GetPostHandler` |
| Read Model | `{Entity}DTO`, `{Entity}ListItemDTO` | `PostDTO`, `PostListItemDTO` |
| Domain Entity | `{Entity}` | `Post`, `Product`, `User` |
| Value Object | 概念名（単数） | `PostTitle`, `Email`, `UserRole` |
| Eloquent Model | `{Entity}Model` | `PostModel`, `UserModel` |
| Repository Interface | `{Entity}RepositoryInterface` | `PostRepositoryInterface` |
| Repository 実装 | `Eloquent{Entity}Repository` | `EloquentPostRepository` |

#### Bounded Contexts / 境界コンテキスト

| Context | 含まれる概念 | 備考 |
|---------|------------|------|
| `Content` | News / Blog | `Post` エンティティを `PostType`（NEWS / BLOG）で区別 |
| `Product` | 商品 / カテゴリ | |
| `User` | ユーザー / 認証 / ロール | Sanctum による認証 |
| `Contact` | お問い合わせ | |
| `Page` | 固定ページ | |

#### CQRS Policy / CQRS 方針

- **Command**（Write）: `CommandBus::dispatch()` 経由で Handler を呼び出す。Bus 内で `DB::transaction` を自動適用。
- **Query**（Read）: `QueryBus::dispatch()` 経由で Handler を呼び出す。Handler は Domain Entity ではなく **DTO** を返す。
- **Lighthouse リゾルバー**: ビルトインディレクティブ（`@create` / `@update` 等）は使用しない。全て `@field` でカスタムリゾルバーに委譲する。


## Getting Started / 起動方法

### Requirements / 必要環境

- Docker / Docker Compose

### Steps / 手順

**1.Copy env file / 環境変数ファイルを作成**

```bash
cp .env.example .env
```

**2.build a containers / コンテナをビルド・起動**

```bash
docker compose up -d --build
```

**3.migration / マイグレーションを実行（初回のみ）**

```bash
docker compose exec app php artisan migrate
```

### Open in browser / ブラウザで確認

| サービス | URL |
|---------|-----|
| Laravel (GraphQL) | http://localhost:8000/graphql |
| 公開HP | http://localhost:3001 |
| 管理画面 | http://localhost:3000 |

### commands / コマンド

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
