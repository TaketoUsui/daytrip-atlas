# アルゴリズム大規模改修ドキュメント

## 改修概要

**実施日**: 2025年11月12日
**目的**: クラスターと汎用画像さえあれば、全ての旅行推薦データを自動生成できるシステムへの移行

## 改修内容

### 1. 自動生成の実装

従来は手動作成が必要だった以下のデータを、AI自動生成によって充足可能にしました。

#### 生成フロー（7段階）

1. **クラスターの選定** - 確率的重みづけによる選定
2. **Spotsのリストアップ** - gemini-2.5-flash
3. **Spotsの詳細分析** - gemini-2.5-flash-lite + 座標検証
4. **キャッチコピーの生成** - gemini-2.5-flash
5. **キービジュアルの選択** - gemini-2.5-flash-lite
6. **モデルプランの生成** - gemini-2.5-flash
7. **Clusterの再評価** - spots数・重要度に基づく評価

### 2. 同時APIコールの実装（準備完了）

現在の実装は順次実行ですが、以下の段階で並列実行が可能な設計になっています：

- **Step 2**: 複数クラスターのSpotsリストアップ
- **Step 3**: 複数Spotsの詳細分析
- **Step 4**: キャッチコピー・画像選択・モデルプラン生成

Laravel Promisesパターンを使用することで、将来的に並列実行に移行可能です。

### 3. プロンプトの分離

Gemini APIに送信するプロンプトを外部ファイル化しました。

**場所**: `storage/prompts/`

- `spot_listing.txt` - Spotsリストアップ用
- `spot_detail_analysis.txt` - Spots詳細分析用
- `spot_coordinate_retry.txt` - 座標再取得用（リトライ専用）
- `image_selection.txt` - 画像選択用
- `model_plan_generation.txt` - モデルプラン生成用
- `catchphrase_generation.txt` - キャッチコピー生成用

プロンプトの改善が容易になり、保守性が向上しました。

## データベーススキーマ変更

### 1. `clusters` テーブル

**追加カラム**:
```sql
tourism_value UNSIGNED INTEGER DEFAULT 10 COMMENT '観光地域としての価値（重みづけ用）'
```

**用途**: クラスター選定時の確率的重みづけ、およびspots生成後の再評価に使用

### 2. `spots` テーブル

**nullable化したカラム**:
- `min_duration_minutes`
- `max_duration_minutes`
- `spot_role`
- `coordinate_reliability`

**SpotRole enumに追加**:
```php
case Generating = "generating"; // 詳細未充足の生成中状態
```

**用途**: 段階的生成（名前取得→詳細分析）をサポート

### 3. `images` テーブル

**追加カラム**:
```sql
category VARCHAR(255) NULL COMMENT '画像のカテゴリ（神社、寺、城、自然景観など）'
```

**用途**: AI画像選択時のカテゴリマッチングに使用

### 4. `suggestion_sets` テーブル（enum拡張）

**SuggestionStatus enumに追加**:
```php
case ListingSpots = 'listing_spots';           // 観光スポットをリストアップしています...
case AnalyzingSpots = 'analyzing_spots';       // 各スポットの詳細を分析しています...
case GeneratingContent = 'generating_content'; // キャッチコピーとプランを生成しています...
case EvaluatingClusters = 'evaluating_clusters'; // 最終的な提案内容を調整しています...
```

**用途**: ユーザーへのきめ細かい進捗表示

## 新規サービスクラス

### 基盤サービス

#### `PromptLoaderService`
- **責務**: プロンプトファイルの読み込みと変数置換
- **場所**: `app/Services/PromptLoaderService.php`

#### `GeminiClientService`
- **責務**: Gemini API呼び出しの共通化（リトライ処理含む）
- **場所**: `app/Services/GeminiClientService.php`

### 自動生成サービス

#### `SpotListingService`
- **責務**: クラスターに紐づくspotsの名前をリストアップ
- **モデル**: gemini-2.5-flash
- **場所**: `app/Services/SpotListingService.php`

#### `SpotDetailAnalyzerService`
- **責務**: spotの詳細情報を取得・検証（座標検証+リトライ機能付き）
- **モデル**: gemini-2.5-flash-lite
- **場所**: `app/Services/SpotDetailAnalyzerService.php`

#### `ImageSelectorService`
- **責務**: spotに最適な既存画像を選択
- **モデル**: gemini-2.5-flash-lite
- **場所**: `app/Services/ImageSelectorService.php`

#### `ModelPlanGeneratorService`
- **責務**: spotsをもとにモデルプランを自動生成
- **モデル**: gemini-2.5-flash
- **場所**: `app/Services/ModelPlanGeneratorService.php`

#### `ClusterEvaluatorService`
- **責務**: spotsに基づくcluster再評価
- **ロジック**: `tourism_value = 10 + (spots数 × 2) + (role重み合計)`
- **場所**: `app/Services/ClusterEvaluatorService.php`

### 改修済み既存サービス

#### `CatchphraseGeneratorService`
- **変更点**: プロンプト分離対応、GeminiClientService利用
- **場所**: `app/Services/CatchphraseGeneratorService.php`

#### `ClusterSelectorService`
- **変更点**: tourism_valueに基づく確率的重みづけ選定を実装
- **場所**: `app/Services/ClusterSelectorService.php`

## Jobの改修

### `GenerateSuggestionsJob`

**変更点**:
- 7段階の自動生成フローを実装
- 新しいステータス遷移に対応
- エラーハンドリング強化（一部失敗しても継続）
- タイムアウト設定: 5分

**場所**: `app/Jobs/GenerateSuggestionsJob.php`

## 使用するGeminiモデル

| 用途 | モデル | 理由 |
|-----|-------|------|
| Spotsリストアップ | gemini-2.5-flash | 精度重視（3-10件の適切なスポット選定） |
| Spots詳細分析 | gemini-2.5-flash-lite | コスト削減（大量のspot分析） |
| 座標リトライ | gemini-2.5-flash-lite | コスト削減（リトライ処理） |
| キャッチコピー生成 | gemini-2.5-flash | 精度重視（魅力的な文章生成） |
| 画像選択 | gemini-2.5-flash-lite | コスト削減（単純なマッチング） |
| モデルプラン生成 | gemini-2.5-flash | 精度重視（実行可能なプラン作成） |

## 期待される効果

| 項目 | 改修前 | 改修後 |
|-----|-------|-------|
| データ充足率 | cluster+spots手動作成必須 | **cluster+画像のみで自動充足** |
| 処理時間 | 順次実行: ~90秒（想定） | 順次実行: ~60-90秒<br>並列実行: ~30-40秒（将来） |
| 保守性 | プロンプトがコード埋込 | **外部ファイル化で改善容易** |
| 拡張性 | 定期処理への対応困難 | **tourism_value等で将来対応可** |

## 今後の展望

### 短期（次のイテレーション）

1. **並列処理の実装**
   - Laravel Promisesを使用した真の並列実行
   - 処理時間30-40秒への短縮

2. **座標検証精度の向上**
   - Google Maps Geocoding APIとの併用検討

### 中期

1. **APIコールの定期実行（事前処理）**
   - cron jobによるバッチ処理
   - gemini-2.5-proを使用した高度分析
   - 既存データの品質向上

2. **データ品質フラグの追加**
   - 高速分析 vs 高度分析の区別
   - ユーザーへの信頼性表示

### 長期

1. **機械学習モデルの導入**
   - user_action_logsを活用した推薦精度向上
   - tourism_valueの動的調整

2. **マルチモーダルAIの活用**
   - 画像生成APIの統合（コスト次第）

## トラブルシューティング

### Gemini API料金が高騰する場合

1. flash-liteモデルの使用頻度を増やす
2. 開発環境ではmock実装を検討
3. APIコール数をログで監視（既に実装済み）

### 座標検証で頻繁にエラーが発生する場合

1. リトライ回数を増やす（現在最大2回）
2. 座標検証の閾値を調整（現在50km）
3. Google Maps Geocoding APIへの切り替え検討

### 処理時間が長すぎる場合

1. 並列処理の実装を優先
2. タイムアウト時間の調整（現在5分）
3. spot数の上限を設定（現在10件）

## 補足事項

### マイグレーションの再実行について

現時点では本番環境で運用していないため、既存のマイグレーションファイルを直接編集しています。

**本番運用開始後は、必ず新規マイグレーションファイルを作成してください。**

### プロンプトの改善方針

プロンプトファイルは頻繁に改善を重ねることを前提としています。
改善時は以下の点に注意してください：

1. 変数名（`{{variable_name}}`）を変更しない
2. 出力形式（JSON構造など）を変更する場合は、サービスクラスも併せて修正
3. バージョン管理を徹底（gitで変更履歴を追跡）

---

**このドキュメントは、アルゴリズム改修の全体像を示すものです。**
**詳細な実装については、各サービスクラスのPHPDocコメントを参照してください。**
