# ドキュメント 3: 機能仕様書 (ユーザーストーリー & BDDシナリオ)

## 1\. 本書の位置づけと目的

本書は、`0_DocumentationPolicy.md` に基づき、MVP（実用最小限の製品）の「コア体験フロー」を開発可能なタスク単位の「振る舞い」として具体化することを目的とします。

`1_proposal.md` (企画書) で定義された「Why（ビジョン）」と「What（コア体験）」を、`2_DB_DesignDocument.md` (DB設計書) のデータモデルを参照しながら、実装可能なBDD（ビヘイビア駆動開発）シナリオに落とし込みます。

## 2\. 対象機能 (MVPスコープ)

`1_proposal.md` (6.3. プロダクトロードマップ) で定義されたMVPスコープに基づき、本書の対象は以下の4つの主要機能（画面）とします。

1.  **トップページ**（出発地入力）
2.  **提案待機ページ**（進捗表示）
3.  **提案結果一覧ページ**（カード表示）
4.  **観光地域詳細ページ**（モデルプラン表示）

※MVPスコープ外（例: 会員登録、タグ絞り込み、フィードバック機能）に関するシナリオは、Phase 1 以降で定義します。

-----

## 3\. 機能仕様詳細

### 3.1. 機能 1: トップページ（出発地入力）

`1_proposal.md` (5.1. 主要画面設計) に基づく、サービスの入口となる機能です。

#### ユーザーストーリー

* **As a** 日帰り旅行先を漠然と探しているユーザー（[1\_proposal.md] 1.2. ターゲットユーザー）
* **I want to** 会員登録なしで、すぐに出発地（地名または現在地）を入力できる
* **So that** 面倒な手続きなしに、AIによる旅行提案プロセスを開始できる（[1\_proposal.md] 2.2. コア体験フロー）

#### BDDシナリオ (Gherkin記法)

```gherkin
Feature: 1. 出発地の入力と提案開始

  Background:
    Given ユーザーがトップページ (Component: Top/Index) を開いている
    And   出発地入力ボックスが表示されている

  Scenario: ユーザーがテキストで出発地を入力し提案を開始する
    When  ユーザーが入力ボックスに "東京駅" と入力する
    And   Google Places Autocomplete API によるサジェストから "東京駅" を選択する
    And   "提案を開始する" ボタンをクリックする
    Then  バックエンドで提案ジョブが開始され、`suggestion_sets` レコードが `status: 'pending'` で作成される
    And   ユーザーは提案待機ページ (Component: Suggestion/Show) にリダイレクトされる
    And   リダイレクト先のURLには、作成された `suggestion_sets.uuid` が含まれている (例: /suggestions/{uuid})

  Scenario: ユーザーがGPSで出発地を指定し提案を開始する
    When  ユーザーが "現在地を利用する" ボタンをクリックする
    And   ブラウザのGPS利用許可ダイアログを「許可」する
    And   GPSから緯度・経度が取得され、入力ボックスに逆ジオコーディングした地名（市区町村名）がセットされる
    And   "提案を開始する" ボタンがアクティブになる
    And   ユーザーが "提案を開始する" ボタンをクリックする
    Then  バックエンドで提案ジョブが開始され、`suggestion_sets.input_latitude`, `input_longitude` が記録される
    And   ユーザーは提案待機ページ (Component: Suggestion/Show) にリダイレクトされる

  Scenario: ユーザーが出発地を入力せずに提案を開始しようとする
    When  ユーザーが入力ボックスに何も入力せずに "提案を開始する" ボタンをクリックする
    Then  ボタンは無効化されている（クリックできない）。もしクライアントサイドのバリデーションを通過した場合、エラーメッセージ "出発地を入力してください" が表示される

  Scenario: Google Places API または GPS の取得に失敗する
    Given ユーザーがトップページを開いている
    When  APIキー失効 または GPS権限拒否により、位置情報の取得に失敗する
    Then  ユーザーにエラー（例: "位置情報を取得できませんでした。地名を手動で入力してください"）を通知する
```

-----

### 3.2. 機能 2: 提案待機ページ（進捗表示）

`1_proposal.md` (5.1.) で定義された、非同期処理（[1\_proposal.md] 6.2.）の待機画面です。
`0_DocumentationPolicy.md` (3. ドキュメント 3) の「こだわりポイント」に基づき、`suggestion_sets.status` の変化を定義します。

#### ユーザーストーリー

* **As a** 提案をリクエストしたユーザー
* **I want to** 提案が生成されるまでの進捗状況をリアルタイムに確認できる
* **So that** 待機時間中のストレスが軽減され、結果への期待感を高めることができる（[1\_proposal.md] 2.2., 5.1.）

#### BDDシナリオ (Gherkin記法)

```gherkin
Feature: 2. 提案生成の待機と進捗表示

  Background:
    Given ユーザーが有効な `suggestion_sets.uuid` を持つ提案待機ページ (Component: Suggestion/Show) を開いている
    And   フロントエンドは3秒ごとにバックエンドへ `suggestion_sets` のステータスをポーリングしている

  Scenario: 提案生成が正常に完了するまでの進捗表示
    # 状態 1: pending
    When  バックエンドの `suggestion_sets.status` が `'pending'` である
    Then  画面には"提案の準備を開始しています..."といったメッセージが表示される
    
    # 状態 2: processing_clusters
    When  バックエンドの `suggestion_sets.status` が `'processing_clusters'` に更新される
    Then  画面のメッセージが"あなたに合いそうな観光地を抽出しています..."に更新される

    # 状態 3: analyzing_items
    When  バックエンドの `suggestion_sets.status` が `'analyzing_items'` に更新される
    Then  画面のメッセージが"プランとキャッチコピーを考えています..."に更新される

    # 状態 4: complete
    When  バックエンドの `suggestion_sets.status` が `'complete'` に更新される
    And   `suggestion_sets` に紐づく `suggestion_set_items` が生成されている
    Then  ポーリングが停止する
    And   ユーザーは自動的に提案結果一覧ページ（同URL、表示内容が切り替わる）に遷移（または画面が更新）される
    And   提案結果一覧 (機能3) が表示される

  Scenario: 提案生成に失敗する
    When  バックエンド処理でエラーが発生し、`suggestion_sets.status` が `'failed'` に更新される
    Then  ポーリングが停止する
    And   画面には"提案の生成に失敗しました。時間をおいて再度お試しください。"といったエラーメッセージが表示される

  Scenario: ユーザーが無効な提案URLにアクセスする
    When  ユーザーが存在しない `uuid` の提案待機ページ (例: /suggestions/invalid-uuid) にアクセスする
    Then  404 Not Found ページへのリダイレクトが行われる
```

-----

### 3.3. 機能 3: 提案結果一覧ページ（カード表示）

`1_proposal.md` (5.1.) に基づく、提案結果の表示機能です。

#### ユーザーストーリー

* **As a** 提案の完了を待ったユーザー
* **I want to** AIによって生成された複数の旅行先候補（クラスター）を、魅力的なキービジュアル、キャッチコピー、移動時間などで直感的に比較できる
* **So that** その中から最も「心に響く」旅の候補を見つけることができる（[1\_proposal.md] 2.1., 2.2.）

#### BDDシナリオ (Gherkin記法)

```gherkin
Feature: 3. 提案結果の閲覧と比較

  Background:
    Given 提案生成が完了 (`suggestion_sets.status` = `'complete'`) している
    And   ユーザーが提案結果一覧ページ (Component: Suggestion/Show の完了後ステート) を表示している
    And   バックエンドから `suggestionSet` オブジェクト (内部に `items` 配列を持つ) がPropsとして渡されている (`0_DocumentationPolicy.md` 6. ページプロパティ定義 参照)

  Scenario: 複数の提案結果がカード形式で表示される
    When  `suggestionSet.items` 配列に3件の提案アイテム (`suggestion_set_items`) が含まれている
    Then  画面には3つの「観光地域カード」が表示される
    And   各カードには、`suggestion_set_items` レコードに基づき、以下の情報が表示されている:
      | 項目 | データソース (例) |
      | --- | --- |
      | キービジュアル | `images.storage_path` (items経由) |
      | キャッチコピー | `catchphrases.content` (items経由) |
      | 観光地域名 | `clusters.name` (items経由) |
      | 移動時間 | `suggestion_set_items.generated_travel_time_text` |
      | タグ | `cluster.tags` |
    And   各カードは、提案アイテム詳細ページ (機能4) へのリンクを持っている

  Scenario: ユーザーが特定の提案カードをクリックする
    When  ユーザーが "鎌倉" の観光地域カードをクリックする
    Then  ユーザーは "鎌倉" の提案アイテム詳細ページ (Component: Suggestion/Detail) に遷移する
    And   遷移先のURLには`suggestion_set_items.uuid`が含まれる (例: /suggestions/detail/{uuid})

  Scenario: 提案結果が0件だった場合
    When  バックエンド処理の結果、`suggestionSet.items` 配列が空 (0件) である
    Then  画面には"条件に合う提案が見つかりませんでした。出発地を変更して再度お試しください。"といったメッセージが表示される
```

-----

### 3.4. 機能 4: 提案アイテム詳細ページ（パーソナライズされたモデルプラン表示）

`1_proposal.md` (5.1.) に基づく、ユーザー専用にパーソナライズされた観光地域提案の詳細機能です。

#### ユーザーストーリー

* **As a** 提案結果一覧から特定の観光地域に興味を持ったユーザー
* **I want to** パーソナライズされたキャッチコピー、キービジュアル、タイムライン形式のモデルプラン、移動時間などの情報を確認できる
* **So that** 自分にぴったりの旅行プランを具体的にイメージし、「行きたい」という気持ちを固めることができる（[1\_proposal.md] 2.2.）

#### BDDシナリオ (Gherkin記法)

```gherkin
Feature: 4. パーソナライズされた提案アイテムの詳細確認

  Background:
    Given ユーザーが提案結果一覧ページ (機能3) から特定の観光地域カードをクリックした
    And   ユーザーは提案アイテム詳細ページ (Component: Suggestion/Detail) を表示している
    And   バックエンドから `suggestionSetItem`, `cluster`, `modelPlan` といった情報がPropsとして渡されている (`0_DocumentationPolicy.md` 6. ページプロパティ定義 参照)

  Scenario: パーソナライズされた提案情報とモデルプランが表示される
    When  ページが表示される
    Then  画面上部には `suggestionSetItem.key_visual_url` (パーソナライズされたキービジュアル) が表示される
    And   `suggestionSetItem.cluster_name` (例: "鎌倉エリア") が表示される
    And   `suggestionSetItem.catchphrase` (AI生成されたキャッチコピー) が表示される
    And   `suggestionSetItem.generated_travel_time_text` (出発地からの移動時間) が表示される
    And   `modelPlan.name` (例: "鎌倉王道 満喫プラン") と `modelPlan.description` が表示される
    And   `modelPlan` に紐づく `model_plan_items` がタイムライン形式で表示される

  Scenario: モデルプランのタイムラインが順序通りに表示される
    Given `modelPlan` が以下の3つの `model_plan_items` (ソート済み) を持っている:
      | display_order | spot_name | duration_minutes | travel_time_to_next_minutes | travel_mode |
      | --- | --- | --- | --- | --- |
      | 1 | 鶴岡八幡宮 | 60 | 15 | "walk" |
      | 2 | 小町通り | 90 | 20 | "walk" |
      | 3 | 鎌倉大仏 | 45 | 0 | (なし) |
    When  ユーザーがタイムラインセクションを見る
    Then  "1. 鶴岡八幡宮" (滞在: 60分) が表示される
    And   "鶴岡八幡宮" から "小町通り" への移動情報 (移動: 15分, 手段: walk) が表示される
    And   "2. 小町通り" (滞在: 90分) が表示される
    And   "小町通り" から "鎌倉大仏" への移動情報 (移動: 20分, 手段: walk) が表示される
    And   "3. 鎌倉大仏" (滞在: 45分) が表示される
```
