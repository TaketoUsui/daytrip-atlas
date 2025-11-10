# ドキュメント 7: フロントエンド設計書 (React)

## 1\. 本書の目的

本書は、`0_DocumentationPolicy.md` に基づき、React（`Inertia.js`）を用いたフロントエンドの実装に関する設計方針を定義します。

`ドキュメント6 (ページプロパティ定義)` で定義された「契約」に基づき、Reactコンポーネントの責務分離、状態管理、スタイリングの統一ルールを定め、MVP開発の品質と一貫性を担保することを目的とします。

## 2\. デザインコンセプト (暫定)

MVP開発を推進するため、以下のデザインコンセプトを暫定的に定義します。

* **サービスの世界観:** 「日帰り地図帳」
* **キーワード:** 地図、旅、発見、AI、シンプル、信頼感、ワクワク感
* **ターゲット:** 情報過多（`1_proposal.md`）に疲れたユーザー
* **カラーパレット (Tailwind):**
    * **ベース (背景):** `bg-gray-50` (`#F9FAFB`) または `bg-white`。地図帳の「紙」をイメージし、クリーンで広々とした印象を与えます。
    * **テキスト (基本):** `text-gray-800` (`#1F2937`)。可読性を最優先します。
    * **アクセント (プライマリ):** `blue-600` (`#2563EB`)。信頼感と知性を感じさせる青色。ボタンやリンク、ローディングインジケータに使用します。
    * **アクセント (サブ):** `emerald-500` (`#10B981`)。「発見」や「完了」を示すポジティブな色として限定的に使用します。
* **レイアウト・形状:**
    * **余白:** 全体的に十分な余白 (`padding`, `margin`) を確保し、ユーザーの「検索疲れ」(`1_proposal.md`) を誘発しない、シンプルでリラックスしたUIを提供します。
    * **角丸:** カードやボタンは `rounded-lg` を基本とし、柔らかく親しみやすい印象を与えます。
    * **シャドウ:** カードには控えめなドロップシャドウ (`shadow-md`) を使用し、情報階層を視覚的に分離します。
* **アニメーション・インタラクション:**
    * **基本:** MVPでは最小限とします。ホバー時のスケールアップ（`hover:scale-105`）や背景色の変化（`hover:bg-gray-100`）など、Tailwind CSS の `transition` で実現できる範囲に留めます。
    * **待機ページ:** 提案待機ページ（`Suggestion/Show`）のみ、`suggestionSet.status` の変化に応じて、ローディングスピナーやプログレスバー（`blue-600` を使用）を表示し、ユーザーの期待感を醸成します。

## 3\. コンポーネント設計

`1_proposal.md` (5.1. 主要画面設計) に対応するReactコンポーネントのディレクトリ構造と責務を定義します。

### 3.1. ディレクトリ構造と責務

Laravel + Inertia.js の推奨構成（`resources/js/` 配下）に基づき、以下の構造を採用します。

```
resources/js/
├── Components/
│   ├── Domain/
│   │   ├── Cluster/
│   │   │   └── ModelPlanTimeline.jsx  # 詳細ページのタイムライン
│   │   ├── Suggestion/
│   │   │   ├── SuggestionCard.jsx     # 結果一覧のカード
│   │   │   └── SuggestionLoading.jsx  # 待機中のアニメーション
│   │   └── Top/
│   │       └── LocationForm.jsx       # トップページの出発地入力フォーム
│   └── Shared/
│       ├── AppLayout.jsx              # 全ページ共通のレイアウト (ヘッダー, フッター等)
│       ├── Button.jsx                 # 共通ボタン
│       ├── Card.jsx                   # 共通カードラッパー
│       └── LoadingSpinner.jsx         # 共通ローディングスピナー
├── Pages/
│   ├── Cluster/
│   │   └── Detail.jsx                 # [ドキュメント6] 観光地域詳細ページ
│   ├── Suggestion/
│   │   └── Show.jsx                   # [ドキュメント6] 提案待機・結果一覧ページ
│   └── Top/
│       └── Index.jsx                  # [ドキュメント6] トップページ
└── app.jsx                            # Inertia.js のエントリーポイント
```

* `Pages/`:
    * **責務:** `Inertia.js` から `Props` を直接受け取るコンポーネント（`ドキュメント6` で定義）。
    * **役割:** ページのレイアウト（`AppLayout.jsx` の適用）と、`Domain` / `Shared` コンポーネントへのデータ（`Props`）の受け渡し（"Props Drilling") を担当します。ロジックは最小限に留めます。
* `Components/Domain/`:
    * **責務:** 「日帰り地図帳」固有のドメイン知識（例: "提案", "モデルプラン"）を持つ、再利用可能なコンポーネント。
    * **役割:** サービスのコア機能（例: `SuggestionCard`）を実装します。`Pages` から渡された `Props` に基づき描画されます。
* `Components/Shared/`:
    * **責務:** ドメイン知識を持たない、汎用的なUI部品（例: `Button`, `Card`）。
    * **役割:** アプリケーション全体のデザインと操作感の一貫性を担保します。

### 3.2. 主要ドメインコンポーネントのProps定義 (例)

`ドキュメント6` のページPropsを、子コンポーネントが受け取る形に分解します。

#### `Components/Domain/Suggestion/SuggestionCard.jsx`

結果一覧ページ（`Pages/Suggestion/Show.jsx`）で `map` 処理されて使用されるカードコンポーネント。

| Prop名 | データ型 | `ドキュメント6` の対応箇所 | 説明 |
| --- | --- | --- | --- |
| `item` | Object | `suggestionSet.items[]` | 提案アイテムの単一オブジェクト |
| `item.cluster_name` | string | `items[].cluster_name` | 観光地域名 |
| `item.key_visual_url` | string | `items[].key_visual_url` | キービジュアルURL |
| `item.catchphrase_content` | string | `items[].catchphrase_content` | キャッチコピー |
| `item.generated_travel_time_text` | string | `items[].generated_travel_time_text` | 移動時間テキスト |
| `href` | string | (派生) `items[].uuid` から生成 | カード全体のリンク先URL (`/suggestions/detail/{uuid}`) |

#### `Components/Domain/Cluster/ModelPlanTimeline.jsx`

提案詳細ページ（`Pages/Suggestion/Detail.jsx`）で使用されるタイムラインコンポーネント。

| Prop名 | データ型 | `ドキュメント6` の対応箇所 | 説明 |
| --- | --- | --- | --- |
| `items` | Array\<Object\> | `modelPlan.items` | モデルプランのステップ配列 |
| `items[].spot_name` | string | `items[].spot_name` | スポット名 |
| `items[].duration_minutes` | integer | `items[].duration_minutes` | 滞在時間 |
| `items[].travel_time_to_next_minutes` | integer | null | `items[].travel_time_to_next_minutes` | 次への移動時間 |
| `items[].travel_mode` | string | null | `items[].travel_mode` | 次への移動手段 |

-----

## 4\. 状態管理 (State Management)

`0_DocumentationPolicy.md` の方針に基づき、MVPフェーズではシンプルさを最優先します。

* **グローバル状態管理:**
    * **方針:** **原則としてフロント側でのグローバル状態を持たない。**
    * **SSOT:** `Inertia.js` から `Props` として渡され、`@inertiajs/react` の `usePage()` フックで取得できるデータを絶対的なSSOT（信頼できる唯一の情報源）とします。
    * **禁止事項:** MVPフェーズでは、`Zustand`, `Redux`, `Context API`（グローバル目的での使用）の導入を禁止します。
* **サーバー状態の更新（ポーリング）:**
    * **対象:** `Pages/Suggestion/Show.jsx` での提案ステータス監視。
    * **方針:** `Inertia.js` の `router.reload()` 機能（`only` オプションで `suggestionSet` のみを対象とする）を `useEffect` と `setTimeout` を組み合わせて使用し、サーバーから最新の `Props` を再取得（ポーリング）します。
* **ローカル状態管理:**
    * **対象:** フォーム入力（例: `Top/Index` の出発地）、UIの状態（例: モーダルの開閉、アコーディオンの開閉など）。
    * **方針:** React 標準の `useState` フックのみを使用します。

-----

## 5\. スタイリング方針

### 5.1. 使用技術

* **Tailwind CSS** を採用します。

### 5.2. 運用ルール

1.  **`@apply` の使用禁止:** CSSファイル内での `@apply` の使用は、Tailwind CSS の設計思想（Utility-First）に反するため、原則禁止します。コンポーネントの `className` に直接ユーティリティクラスを記述します。
2.  **クラス名の記述順序:** 可読性のため、フォーマッタとして`prettier-plugin-tailwindcss`を導入し、自動整形することを推奨します。
3.  **カスタム値の禁止:** `className="mt-[3px]"` のような任意の値（JITコンパイラの機能）の使用は、デザインの一貫性を損なうため禁止します。`tailwind.config.js` で定義されたデザイントークン（例: `mt-1`）のみを使用します。
4.  **コンポーネント分割:** ユーティリティクラスが長くなりすぎる場合（例: 1行に収まらない）は、スタイルが複雑すぎる兆候です。`Components/Shared` などにコンポーネントとして切り出すことを検討してください。

### 5.3. `tailwind.config.js` の設定 (例)

「2. デザインコンセプト」で定義したカラーパレットを反映させます。

```javascript
// tailwind.config.js

const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        extend: {
            colors: {
                // 2. デザインコンセプトで定義したカラーパレット
                gray: colors.gray,
                blue: colors.blue, // プライマリアクセント
                emerald: colors.emerald, // サブアクセント
            },
            fontFamily: {
                /**
                 * Webフォントの選定 (Noto Sans JP)
                 * 理由:
                 * 1. 圧倒的な一般性と、Google Fonts 経由での導入の容易さ。
                 * 2. クセのないデザインが「信頼感」「クリーン」なUIコンセプトに合致する。
                 * 3. 可読性が高く、地図帳のような情報参照系サービスに適している。
                 */
                sans: ['"Noto Sans JP"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    /**
     * プラグインの選定
     * 0_DocumentationPolicy.md (MVPスコープへのフォーカス) に基づき、
     * MVPのUI実装（フォーム、画像）に直接役立つものに限定する。
     */
    plugins: [
        /**
         * @tailwindcss/forms
         * 理由:
         * トップページ (Top/Index) の「出発地入力フォーム」の実装に必要。
         * ブラウザデフォルトのスタイルをリセットし、Tailwindのユーティリティクラスによる
         * デザイン統一（2. デザインコンセプト準拠）を容易にするため採用する。
         */
        require('@tailwindcss/forms'),

        /**
         * @tailwindcss/aspect-ratio
         * 理由:
         * 提案結果一覧 (Suggestion/Show) の SuggestionCard に表示する
         * キービジュアル (key_visual_url) のアスペクト比を固定するために採用する。
         * (例: aspect-w-16 aspect-h-9)
         * これにより、画像の元サイズに関わらずカードの高さを揃え、
         * 「クリーン」で整然としたレイアウトを実現する。
         */
        require('@tailwindcss/aspect-ratio'),
    ],
};
```
