# ドキュメント 10: MVP開発方針

## 1. 本書の目的

本書は、**日帰り地図帳（Daytrip Atlas）** のMVP（実用最小限の製品）開発における全体方針と段階的な実装計画を定義します。

`0_DocumentationPolicy.md` に基づき、開発チームが効率的に実装を進めるための指針となることを目的とします。

## 2. MVPスコープの再確認

### 2.1. 対象機能（コア体験フロー）

`1_proposal.md` (6.3. プロダクトロードマップ) および `3_FunctionSpecification.md` (2. 対象機能) で定義された4つの主要機能：

1. **トップページ**（出発地入力）
2. **提案待機ページ**（進捗表示）
3. **提案結果一覧ページ**（カード表示）
4. **観光地域詳細ページ**（モデルプラン表示）

### 2.2. MVP除外機能（MVP完了後に実装予定）

- 会員登録・ログイン機能
- タグによる絞り込み機能
- フィードバック・評価機能
- お気に入り・保存機能
- ソーシャルシェア機能
- 管理画面

## 3. 開発フェーズ戦略

MVP開発を6つのフェーズに分割し、段階的にリスクを低減しながら実装を進めます。

### Phase 1: 基盤構築

**目的:** データベース、モデル、基本アーキテクチャの確立

**成果物:**
- データベースマイグレーション全件
- Eloquentモデル全件
- Enum定義全件
- Docker開発環境構築

### Phase 2: コア機能スケルトン実装

**目的:** 外部API統合なしでエンドツーエンドのフロー確立

**成果物:**
- コントローラー実装（TopController, SuggestionController, ClusterController）
- ルート定義
- Inertia.js統合
- フロントエンドページコンポーネント（Top/Index, Suggestion/Show, Cluster/Detail）
- ジョブ実装（GenerateSuggestionsJob）
- サービス層ダミー実装（ClusterSelectorService, TravelTimeCalculatorService, CatchphraseGeneratorService）
- APIリソース実装（Props定義準拠）
- Seederデータ拡充

**想定される動作:**
- 出発地（緯度経度）を手動入力
- ダミーデータで提案生成（固定3件のクラスター）
- ステータス遷移の動作確認可能
- モデルプラン表示可能

### Phase 3: UI/UXブラッシュアップ

**目的:** ユーザー体験の向上とデザイン完成度の向上

**主要タスク:**
1. フロントエンドコンポーネント実装
   - SuggestionCard コンポーネント完成
   - ModelPlanTimeline コンポーネント完成
   - SuggestionLoading コンポーネント完成
   - その他共有コンポーネント（Button, Card等）の拡充

2. レスポンシブデザイン対応
   - モバイル（〜768px）の表示最適化
   - タブレット（768px〜1024px）の表示最適化
   - デスクトップ（1024px〜）の表示最適化

3. アニメーション・トランジション追加
   - ページ遷移アニメーション
   - ローディング表示の改善
   - カードホバーエフェクト

4. エラーハンドリング強化
   - バリデーションエラー表示の改善
   - ネットワークエラー対応
   - 404/500エラーページ

5. アクセシビリティ対応
   - セマンティックHTML
   - キーボードナビゲーション
   - ARIAラベル

**完了条件:**
- デザインカンプとの一致度80%以上
- モバイル・デスクトップ両方で正常表示
- Lighthouse Accessibility スコア90以上

### Phase 4: AI統合（キャッチコピー生成）

**目的:** Gemini APIを活用したパーソナライズ機能の実装

**主要タスク:**
1. Gemini API統合準備
   - APIキー設定
   - Gemini PHP SDKインストール
   - レート制限・エラーハンドリング設計

2. CatchphraseGeneratorService 本実装
   - プロンプトエンジニアリング
   - 生成結果のパース・バリデーション
   - フォールバック戦略（API失敗時）

3. キャッチコピーA/Bテスト基盤
   - catchphrases テーブルの活用
   - 生成バリエーション管理
   - パフォーマンス追跡（view_count, click_count）

4. テスト・評価
   - 生成品質の評価
   - レスポンスタイム計測
   - コスト試算

**完了条件:**
- 各クラスターに対して魅力的なキャッチコピーが生成される
- 生成時間が5秒以内
- API呼び出し成功率95%以上

### Phase 5: 位置情報統合（GPS・Google Places）

**目的:** ユーザビリティ向上のための位置情報機能実装

**主要タスク:**
1. Google Places API統合
   - Places Autocomplete実装
   - Geocoding API統合
   - APIキー設定・セキュリティ対策

2. トップページUI改修
   - Places Autocompleteサジェスト表示
   - 現在地取得ボタン実装
   - GPS権限リクエスト処理

3. 逆ジオコーディング
   - GPS座標から地名表示
   - エラーハンドリング

4. テスト
   - 各種デバイスでのGPS動作確認
   - Places API レスポンスの検証

**完了条件:**
- トップページで地名入力がサジェストされる
- 現在地ボタンで位置情報が取得される
- 緯度経度の手動入力が不要になる

### Phase 6: PostGIS統合（地理空間クエリ）

**目的:** 出発地からの距離に基づく適切なクラスター選定

**主要タスク:**
1. PostGIS機能確認
   - PostGIS拡張有効化確認
   - Laravel Magellanパッケージ動作確認
   - 空間インデックス設定確認

2. ClusterSelectorService 本実装
   - ST_Distance を使用した距離計算
   - 適切な範囲内（50km〜150km）のクラスター抽出
   - 距離・人気度・多様性を考慮したランキングアルゴリズム

3. TravelTimeCalculatorService 本実装
   - Google Maps Distance Matrix API統合（または）
   - 距離ベースの推定計算アルゴリズム
   - 移動手段（car/train）の考慮

4. パフォーマンス最適化
   - 空間インデックスの活用
   - クエリパフォーマンス計測
   - キャッシュ戦略

**完了条件:**
- 出発地から適切な距離のクラスターが選定される
- 提案の多様性が確保される（同じエリアに偏らない）
- 選定処理が3秒以内に完了

## 4. 技術スタック概要

### 4.1. バックエンド

| 技術 | バージョン | 用途 |
|-----|----------|------|
| PHP | 8.2+ | アプリケーション言語 |
| Laravel | 12 | Webフレームワーク |
| PostgreSQL | 16 | データベース |
| PostGIS | 3.4 | 地理空間拡張 |
| Redis | 7 | キュー・セッション・キャッシュ |
| Pest | 4 | テストフレームワーク |

### 4.2. フロントエンド

| 技術 | バージョン | 用途 |
|-----|----------|------|
| React | 19 | UIライブラリ |
| Inertia.js | 2 | Laravel-React統合 |
| Tailwind CSS | 4 | CSSフレームワーク |
| Vite | 5 | ビルドツール |

### 4.3. 外部API

| API | 用途 | 導入フェーズ |
|-----|------|------------|
| Google Places API | 地名サジェスト・座標特定 | Phase 5 |
| Gemini API | キャッチコピー生成 | Phase 4 |
| Google Maps Distance Matrix API | 移動時間計算（検討中） | Phase 6 |

## 5. 開発原則

### 5.1. MVP優先原則

**開発速度を最優先し、過度な最適化を避ける**

- モノリシック構成を維持（マイクロサービス化は見送り）
- 初期段階では既存ライブラリ・サービスを最大限活用
- パフォーマンス最適化は必要になってから実施

### 5.2. 段階的リスク低減

**各フェーズで動作可能な状態を維持**

- 外部API依存を後のフェーズに配置
- ダミー実装 → 本実装の2段階アプローチ
- 各フェーズ完了時に動作確認可能

### 5.3. ドキュメント駆動開発

**実装前にドキュメントで仕様を明確化**

- `6_PagePropsDefinition.md` によるフロントエンド・バックエンド契約の明確化
- BDDシナリオ（`3_FunctionSpecification.md`）による振る舞いの定義
- 実装の前にドキュメントをレビュー

### 5.4. テスト戦略

**重要な機能から優先的にテストを記述**

- Feature Test: コア体験フローのエンドツーエンドテスト
- Unit Test: ビジネスロジック（Services, Jobs）
- Frontend Test: 主要コンポーネント（検討中）

**Phase 3以降で優先的にテストを拡充**

## 6. コーディング規約

### 6.1. バックエンド（Laravel）

- PSR-12 準拠（Laravel Pint使用）
- ファイル命名: PascalCase（例: `SuggestionController.php`）
- メソッド命名: camelCase（例: `selectClusters()`）
- DBカラム: snake_case（例: `input_latitude`）

### 6.2. フロントエンド（React）

- ESLint + Prettier 準拠
- コンポーネント命名: PascalCase（例: `SuggestionCard.jsx`）
- 関数命名: camelCase（例: `handleSubmit()`）
- Propsインターフェース: TypeScript型定義（将来的に導入検討）

### 6.3. コメント・ドキュメント

- PHPDoc による関数・クラスのドキュメント記述
- 複雑なロジックには日本語コメント推奨
- TODOコメントにはフェーズ番号を含める（例: `// TODO(Phase4): Gemini API統合`）

## 7. Git戦略

### 7.1. ブランチ戦略

**GitHub Flow の簡易版を採用**

- `main`: 本番環境デプロイ可能な安定版（MVPまでは未使用）
- `develop`: 開発ベースブランチ（現在未設定）
- `feat/*`: 機能開発ブランチ（例: `feat/phase3-ui-components`）
- `fix/*`: バグ修正ブランチ

### 7.2. コミットメッセージ

**Conventional Commits 準拠**

```
<type>: <subject>

<body>（任意）
```

**Type一覧:**
- `feat`: 新機能追加
- `fix`: バグ修正
- `refactor`: リファクタリング
- `docs`: ドキュメント変更
- `test`: テスト追加・修正
- `chore`: ビルド・設定変更

**例:**
```
feat: Google Places Autocompleteをトップページに統合

Phase 5の要件に基づき、出発地入力欄にPlaces APIサジェストを実装。
緯度経度の手動入力を廃止し、UXを改善。
```

## 8. 開発環境・ツール

### 8.1. 必須ツール

- Docker Desktop（またはDocker + Docker Compose）
- IDE: PhpStorm（推奨）/ VSCode
- Node.js 20+（Viteビルド用）
- Git

### 8.2. IDE設定

**PhpStorm推奨設定:**
- Laravel Ideaプラグインインストール
- `php artisan ide-helper:generate` でオートコンプリート強化
- PSR-12自動フォーマット設定

**VSCode推奨拡張:**
- Laravel Extension Pack
- Tailwind CSS IntelliSense
- ESLint
- Prettier

## 9. パフォーマンス目標（MVP）

| 指標 | 目標値 | 計測タイミング |
|-----|--------|--------------|
| トップページ表示 | 2秒以内 | Phase 3完了時 |
| 提案生成（全体） | 15秒以内 | Phase 6完了時 |
| クラスター詳細表示 | 2秒以内 | Phase 3完了時 |
| Lighthouse Performance | 70以上 | Phase 3完了時 |
| Lighthouse Accessibility | 90以上 | Phase 3完了時 |

## 10. セキュリティ方針（MVP）

### 10.1. 基本方針

- OWASP Top 10 の主要脆弱性に対応
- 会員機能なしのためセッション・CSRF対策のみ
- APIキーの適切な管理（.env、環境変数）

### 10.2. 実装要件

- CSRF保護（Laravel標準機能）
- SQLインジェクション対策（Eloquent ORM使用）
- XSS対策（React自動エスケープ、Laravel Blade使用時は手動対策）
- 入力バリデーション（各Controllerで実装）
- レート制限（Phase 5以降でAPI保護）
- 認証・認可（MVP対象外、将来実装予定）

## 11. デプロイ戦略（検討中）

**MVP時点では未確定。以下は候補:**

### Option A: PaaS（推奨）
- **Laravel Forge + DigitalOcean/AWS Lightsail**
- 自動デプロイ・SSL対応
- コスト: 月額 $15〜$30

### Option B: コンテナPaaS
- **AWS App Runner / Google Cloud Run**
- Dockerイメージデプロイ
- スケーラビリティ高

### Option C: VPS自前構築
- **さくらVPS / Vultr**
- コスト最小
- 運用負荷高

**決定タイミング:** Phase 6完了後、MVP動作確認完了時

## 12. 実装の流れ

各フェーズは以下の流れで進めることを推奨します：

1. **フェーズ開始前**: `11_ProgressTracking.md` でタスクを詳細化
2. **実装中**: 進捗を `11_ProgressTracking.md` に記録
3. **フェーズ完了時**: 完了条件を満たしているか確認し、次フェーズへ移行判断

---

**最終更新:** 2025-11-09
**作成者:** Claude Code
**レビュー:** 未実施
