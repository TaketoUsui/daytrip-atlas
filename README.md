# 日帰り地図帳 (Daytrip Atlas)

AIによる徹底したパーソナライズで、ユーザー一人ひとりの心に響く「旅の発見」体験を創出するWebサービス。

![日帰り地図帳_バナー](https://github.com/user-attachments/assets/2525accc-19ac-42e0-95f8-0c81c0ea33aa)


## 概要

本プロジェクトは、日帰り旅行先の調査・計画段階で多くの人が感じる「検索疲れ」や「意思決定の面倒さ」という精神的負担を解消することを目的としています。

出発地を入力するだけで、AIがユーザーの潜在的な好みまでを汲み取り、最適な日帰り旅行プランを複数提案。ユーザーを「探す」行為から解放し、純粋な「選ぶ」楽しみと「発見」の喜びを提供します。

## 主な機能 (MVP)

- **旅行提案機能**: 出発地といくつかのタグを選択するだけで、複数の日帰り旅行プランが提案されます。
- **2フェーズAI分析アーキテクチャ**:
  - **Phase 1**: バックグラウンドで継続的にAI分析を実行し、スポット詳細、優先度、プラン、キャッチフレーズなどを事前生成
  - **Phase 2**: ユーザーリクエスト時に事前分析データを活用し、1分以内に高品質な提案を生成
- **モデルプラン表示**: 提案された各地域について、タイムライン形式のモデルプランやスポット情報を地図と共に確認できます。
- **AI モデル管理**: 複数のAIモデルを性能優先度に基づいて動的に選択し、日次利用上限を管理

## 技術スタック

- **バックエンド**: Laravel 12 (PHP 8.2+)
- **フロントエンド**: React 19 + Inertia.js 2
- **データベース**: PostgreSQL 16 + PostGIS 3.4
- **テスト**: Pest 4
- **CSS**: Tailwind CSS 4
- **開発環境**: Docker Compose（nginx, php-fpm, PostgreSQL, queue worker, scheduler, Node.js）
- **AI統合**: Google Gemini API (google-gemini-php/client)
- **型安全**: spatie/laravel-data (JSONB スキーマ管理)

## アーキテクチャ

開発速度を優先するMVPフェーズでは、`Laravel` + `Inertia.js` + `React`による**Inertia.jsモノリス**構成を採用しています。

### ルーティング設計

- **Inertia.jsルート** (`routes/web.php`): すべてのページレンダリングとナビゲーション
  - Reactコンポーネントを Inertia レスポンスで返却
  - ページ間の遷移とデータ操作を処理
- **APIルート** (`routes/api.php`): 現在未使用（将来のマイクロサービス統合用に予約）

### 非同期処理アーキテクチャ

AI駆動の提案生成には、最適なユーザー体験のための**2フェーズアーキテクチャ**を採用:

#### Phase 1: 非同期AI分析（バックグラウンド処理）

AIタスクディスパッチャー（`DispatchAsyncAnalysisTasksJob`）が継続的に以下を実行:

- **Aタイプタスク（50%）**: スポット関連分析
  1. スポット詳細分析 (`AnalyzeSpotDetailJob`)
  2. スポット優先度決定 (`AnalyzeSpotPriorityJob`)
  3. スポット一覧生成 (`AnalyzeSpotListingJob`)
- **Bタイプタスク（50%）**: プラン関連分析
  1. 画像選択 (`AnalyzeImageSelectionJob`)
  2. メインスポット選択 (`AnalyzeMainSpotJob`)
  3. モデルプラン生成 (`AnalyzeModelPlanJob`)
  4. キャッチフレーズ生成 (`AnalyzeCatchphraseJob`)

**ポイント**:
- AI モデル管理（`app/Models/AiModel.php`）による動的なモデル選択と日次上限管理
- 楽観的ロック（`app/Services/AI/LockManager.php`）による重複分析の防止
- 優先度ベースのタスク選択（`app/Services/AI/TaskSelector.php`）

#### Phase 2: リアルタイム提案生成（ユーザーリクエスト）

ユーザーが提案をリクエストした際、事前分析済みデータを活用:

- `GenerateSuggestionsJob`: 簡素化されたパイプライン
  1. クラスター選択（事前分析済みクラスターから確率的重み付け）
  2. モデルプラン選択（事前生成済みプランから選択）
  3. 移動時間計算
  4. `suggestion_set_model_plans` ピボットテーブル経由での結果構成

**結果**: ユーザー待機時間を3-5分から1分未満に短縮しながら、高品質なAI生成コンテンツを維持。

### Docker構成

本プロジェクトは以下の6つのサービスで構成されています:

- **nginx**: Webサーバー
- **php**: Laravel アプリケーション（php-fpm）
- **db**: PostgreSQL 16 + PostGIS 3.4
- **queue**: Laravel キューワーカー（非同期ジョブ処理）
- **scheduler**: Laravel スケジューラー（定期タスク実行）
- **node**: Vite開発サーバー（自動起動）

## ドキュメント

本プロジェクトに関する主要なドキュメントは`documents`ディレクトリに格納されています。

- **企画書**: [`documents/1_proposal.md`](documents/1_proposal.md)
- **技術仕様書**: [`documents/2_technical_spec.md`](documents/2_technical_spec.md)
- **開発ガイド**: [`CLAUDE.md`](CLAUDE.md) - Claude Code向けのプロジェクトガイド

## セットアップ

```bash
# 1. リポジトリをクローン
git clone https://github.com/TaketoUsui/daytrip-atlas.git
cd daytrip-atlas

# 2. 環境変数ファイルを作成
cp .env.example .env
# 必要に応じて .env を編集（APP_PORT, DB設定など）

# 3. 初期化スクリプトを実行
# - Dockerコンテナの起動（nginx, php, db, queue, scheduler, node）
# - .envファイルの自動生成（未作成の場合）
# - アプリケーションキーの生成
# - データベースマイグレーション
./scripts/init.sh

# 4. アプリケーションにアクセス
# http://localhost:${APP_PORT} (デフォルト: http://localhost:8080)
# Vite開発サーバーは自動起動（http://localhost:5173）
```

### 開発コマンド

```bash
# コンテナに入る
docker compose exec php bash

# マイグレーション実行
docker compose exec php php artisan migrate

# IDE補完生成
docker compose exec php php artisan ide-helper:generate

# キャッシュクリア
docker compose exec php php artisan config:clear
docker compose exec php php artisan cache:clear

# Tinker（REPL）
docker compose exec php php artisan tinker

# テスト実行
docker compose exec php php artisan test

# コードフォーマット（Laravel Pint）
docker compose exec php ./vendor/bin/pint

# ログ監視
docker compose exec php php artisan pail --timeout=0

# 統合開発コマンド（サーバー、キュー、ログ、Viteを同時起動）
composer dev
```

### トラブルシューティング

```bash
# ログ確認
docker compose logs -f node    # Vite開発サーバー
docker compose logs -f queue   # キューワーカー
docker compose logs -f scheduler # スケジューラー

# コンテナ再起動
docker compose restart

# コンテナ再ビルド
docker compose up -d --build
```

## データベース設計

### スポット中心アプローチ

すべての情報の最小単位を「スポット」と定義し、これを中心にデータ構造を設計することで、柔軟なプランニングと高い再利用性を実現しています。

**主要テーブル**:
- **`spots`**: 個別の場所・観光スポット
- **`clusters`**: スポットの地理的グルーピング（日帰り圏内）
- **`model_plans`** & **`model_plan_items`**: キュレーションされた旅程管理
- **`suggestion_sets`**: ユーザー提案リクエスト（`suggestion_set_model_plans` ピボットテーブルで ModelPlans にリンク）
- **`catchphrases`**: AI生成マーケティングコピー（ModelPlan にリンク）
- **`ai_models`**: AIモデル管理（性能優先度、日次上限）
- **`user_profiles`**, **`user_action_logs`**, **`user_spot_interests`**: ユーザーデータと行動

### JSONB スキーマ管理

すべての JSONB カラムは `spatie/laravel-data` による型安全なスキーマ管理:

**Dataクラス** (`app/Data/`):
- `UserPreferencesData`: `user_profiles.preferences` のスキーマ
- `ProcessingDetailsData`: `suggestion_sets.processing_details` のスキーマ
- `InputTagsData`: `suggestion_sets.input_tags_json` のスキーマ
- `SourceAnalysisData`: `catchphrases.source_analysis` のスキーマ

**メリット**:
- 型安全性とIDE自動補完
- Dataクラスレベルでのバリデーション
- アプリケーション全体で一貫したスキーマ
- スキーマ進化時の容易な移行

### PostGIS対応

- **PostGIS拡張**: 空間クエリ対応（距離計算、地理的検索）
- **Laravel Magellan**: (`clickbar/laravel-magellan`) PostGIS統合と空間クエリヘルパー
- 地理座標は `latitude`/`longitude` ペアで格納
- 位置カラムに空間インデックスを設定してパフォーマンス向上

詳細は[技術仕様書](documents/2_technical_spec.md)を参照してください。
