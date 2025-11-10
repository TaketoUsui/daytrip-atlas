# ドキュメント 6: ページプロパティ定義 (Inertia.js)

## 1\. 本書の目的と重要性

本書は、`Inertia.js` アーキテクチャにおける\*\*バックエンド (Laravel) とフロントエンド (React) の間の「契約」\*\*を定義します。

従来のAPI設計における `OpenAPI (JSON API)` 仕様書に代わるものであり、Laravelのコントローラが `Inertia::render()` でReactコンポーネントに渡す `Props` のスキーマを厳密に定義します。

この定義は、フロントエンドのモックデータ作成、型定義、およびバックエンドのレスポンス（Eloquent API Resources）実装の直接的なインプットとなります。データの型、および `nullable`（`null` を許容するかどうか）の定義を厳守してください。

## 2\. 共有 Props (Shared Props)

すべてのページコンポーネントに共通して渡されるデータです。

```typescript
// 型定義 (参考)
interface SharedProps {
  flash: {
    success: string | null;
    error: string | null;
  };
  errors: Record<string, string>; // フォームバリデーションエラーなど
  // MVPフェーズでは上記のみを想定。
  // 認証機能（Phase 1）実装時に user オブジェクトなどが追加される。
}
```

| Prop名 | データ型 | 説明 |
| --- | --- | --- |
| `flash` | Object | フラッシュメッセージ（成功通知、エラー通知）を格納するオブジェクト。 |
| `flash.success` | string | null | 成功時のメッセージ（例: "保存しました"）。無い場合は `null`。 |
| `flash.error` | string | null | エラー時のメッセージ（例: "処理に失敗しました"）。無い場合は `null`。 |
| `errors` | Object | フォームバリデーションエラーなどを格納するオブジェクト。キーがフォームのフィールド名、バリューがエラーメッセージ。 |

-----

## 3\. ページ別 Props (Page Props)

`Inertia::render()` の第一引数で指定されるコンポーネント名と、第二引数で渡される `Props` のスキーマを定義します。

### 3.1. トップページ

* **Component:** `Top/Index`
* **Controller:** `TopController@index` (仮)
* **説明:** サービスの入口となる出発地入力ページ。

| Prop名 | データ型 | 説明 |
| --- | --- | --- |
| (特になし) | - | MVPのトップページは静的な内容が中心であり、サーバーから渡す動的なデータは原則として不要。 |

-----

### 3.2. 提案待機・結果一覧ページ

* **Component:** `Suggestion/Show`
* **Controller:** `SuggestionController@show` (仮)
* **説明:** 提案ジョブの待機（ポーリング）と、完了後の結果一覧表示を担う、単一のページコンポーネント。
* **こだわり:** `suggestionSet` オブジェクトの `status` に応じて、フロントエンドが「待機画面」と「結果一覧画面」の表示を切り替えます。

| Prop名 | データ型 | 説明 |
| --- | --- | --- |
| `suggestionSet` | Object | 提案セット（`suggestion_sets` テーブル）の単一レコードに対応するオブジェクト。 |
| `suggestionSet.uuid` | string | 提案セットのUUID。ポーリングや結果共有URLのキーとなる。 |
| `suggestionSet.status` | string (Enum) | **(最重要)** 提案ジョブの進捗状況。フロントはこの値を見て表示を切り替える。<br>値: `'pending'`, `'processing_clusters'`, `'analyzing_items'`, `'complete'`, `'failed'`。 |
| `suggestionSet.items` | Array\<Object\> | null | **(`status` が `'complete'` の場合のみ)** 提案されたアイテム（`suggestion_set_items`）の配列。`'complete'` 以外の場合は `null`。 |
| `suggestionSet.items[].uuid` | string | 提案アイテムのUUID。詳細ページへのリンクなどに使用。 |
| `suggestionSet.items[].cluster_name` | string | 提案された観光地域（クラスター）名。 (例: "鎌倉エリア")。 |
| `suggestionSet.items[].cluster_uuid` | string | (新設) 詳細ページ遷移用に、`clusters.uuid` を含める。 |
| `suggestionSet.items[].key_visual_url` | string | キービジュアル画像のURL。 (例: `images.storage_path` へのフルパス)。 |
| `suggestionSet.items[].catchphrase_content` | string | AI生成キャッチコピー本文。 (例: "歴史とグルメを巡る、王道の日帰り旅")。 |
| `suggestionSet.items[].generated_travel_time_text` | string | 生成された移動時間のテキスト。 (例: "出発地から車で約90分")。 |

-----

### 3.3. 提案アイテム詳細ページ

* **Component:** `Suggestion/Detail`
* **Controller:** `SuggestionSetItemController@show`
* **Route:** `/suggestions/detail/{suggestionSetItem:uuid}`
* **説明:** 提案結果一覧から選択された、パーソナライズされた観光地提案の詳細ページ。キービジュアル、キャッチコピー、モデルプランやスポット情報を表示する。

| Prop名 | データ型 | 説明 |
| --- | --- | --- |
| `suggestionSetItem` | Object | 提案アイテム（`suggestion_set_items`）の情報。 |
| `suggestionSetItem.uuid` | string | 提案アイテムのUUID。 |
| `suggestionSetItem.suggestion_set_uuid` | string | 親提案セットのUUID（「提案一覧に戻る」リンク用）。 |
| `suggestionSetItem.cluster_name` | string | クラスター名（例: "鎌倉エリア"）。 |
| `suggestionSetItem.key_visual_url` | string | null | パーソナライズされたキービジュアル画像URL。 |
| `suggestionSetItem.catchphrase` | string | null | AI生成されたキャッチコピー。 |
| `suggestionSetItem.generated_travel_time_text` | string | null | 移動時間テキスト（例: "車で約1時間30分"）。 |
| `cluster` | Object | クラスター基本情報（内部的な参照用）。 |
| `cluster.uuid` | string | クラスターのUUID。 |
| `cluster.name` | string | クラスター名。 |
| `modelPlan` | Object | このクラスターの代表モデルプラン（`model_plans`）の情報。 |
| `modelPlan.name` | string | プラン名（例: "鎌倉王道 満喫プラン"）。 |
| `modelPlan.description` | string | null | プランの概要説明文。 |
| `modelPlan.total_duration_minutes` | integer | プランの総所要時間（分）。 |
| `modelPlan.items` | Array\<Object\> | **(最重要)** モデルプランを構成するステップ（`model_plan_items`）の配列。**`display_order` 順でソート済みであること**。 |
| `modelPlan.items[].spot_name` | string | (新設) `spots.name` への参照。（例: "鶴岡八幡宮"）。 |
| `modelPlan.items[].spot_description` | string | null | (新設) `spots.description` や補足情報。 |
| `modelPlan.items[].duration_minutes` | integer | そのスポットでの滞在時間（分）。 |
| `modelPlan.items[].travel_time_to_next_minutes` | integer | null | **次のスポットへの**移動時間（分）。最後のアイテムの場合は `null`。 |
| `modelPlan.items[].travel_mode` | string | null | **次のスポットへの**移動手段（例: "walk", "car"）。最後のアイテムの場合は `null`。 |
| `spots` | Array\<Object\> | `modelPlan.items` に含まれるスポット（`spots`）のユニークなリスト。マップ表示などに使用する。 |
| `spots[].uuid` | string | (新設) `spots.slug` または `uuid`。 |
| `spots[].name` | string | スポット名。 |
| `spots[].latitude` | float | スポットの緯度（`spots.location` から抽出）。 |
| `spots[].longitude` | float | スポットの経度（`spots.location` から抽出）。 |
| `spots[].address_detail` | string | null | 詳細住所。 |
