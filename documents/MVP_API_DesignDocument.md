# MVP_API設計

## 1. 設計思想

本設計は、Laravel + Inertia.js + Reactという技術スタックの特性を最大限に活かす**ハイブリッドアプローチ**を採用します。

- **Inertiaレンダリング (`routes/web.php`)**: ページの描画を伴うGETリクエストや、フォーム送信後にページ遷移（リダイレクト）が発生するアクションを担当します。これにより、「モダンなモノリス」としての開発効率とシンプルさを実現します。
- **APIエンドポイント (`routes/api.php`)**: ページ遷移を伴わない、純粋なデータ送受信（非同期通信）を担当します。これにより、ロジックの責務を明確に分離し、将来の外部連携やマイクロサービス化も見据えた拡張性を確保します。

---

## 2. エンドポイント一覧

| No. | 役割 | URI | HTTPメソッド | 機能概要 |
| --- | --- | --- | --- | --- |
| **ユーザー向け** |  |  |  |  |
| 1 | Inertia | `/` | GET | トップページの表示 |
| 2 | Inertia | `/suggestions` | POST | 提案リクエストを受付、待機ページへリダイレクト |
| 3 | Inertia | `/suggestions/{uuid}/wait` | GET | 提案待機ページの表示 |
| 4 | API | `/api/v1/suggestions/{uuid}/status` | GET | 提案生成の進捗状況を取得（ポーリング用） |
| 5 | Inertia | `/suggestions/{uuid}` | GET | 提案結果一覧ページの表示 |
| 6 | Inertia | `/clusters/{cluster_id}` | GET | 観光地域詳細ページの表示 |
| 7 | API | `/api/v1/spots/{spot_id}/interest` | POST | スポットへの「気になる/興味なし」を記録 |
| 8 | API | `/api/v1/logs/action` | POST | ユーザーの行動ログを記録 |
| **運営者向け** |  |  |  |  |
| 9 | API | `/api/v1/admin/*` | CRUD | コンテンツ管理（CRUD）API群 |

---

## 3. 詳細仕様

### 3.1. トップページ表示

- **No**: 1
- **機能名**: トップページ表示
- **URI**: `/`
- **HTTPメソッド**: GET
- **役割**: Inertia
- **概要**: ユーザーが最初に着地する、出発地とタグを入力するページを表示します。

### レスポンス仕様

- **成功時 (200 OK)**:
    - `Inertia::render` により、Reactの`TopPage`コンポーネントを描画します。

```json
{
  "tags": [
    { "id": 1, "name": "絶景" },
    { "id": 5, "name": "デート向き" }
    // ...
  ]
}
```

### 3.2. 提案リクエスト受付

- **No**: 2
- **機能名**: 提案リクエスト受付
- **URI**: `/suggestions`
- **HTTPメソッド**: POST
- **役割**: Inertia
- **概要**: ユーザーが入力した出発地とタグを元に、非同期で提案生成ジョブを起動し、待機ページへリダイレクトさせます。

### リクエスト仕様

- **Content-Type**: `application/json` or `multipart/form-data`
- ボディ:

| キー | 型 | バリデーション | 説明 |
| --- | --- | --- | --- |
| latitude | float | required, numeric | 出発地の緯度 |
| longitude | float | required, numeric | 出発地の経度 |
| tags | array | nullable, array | 選択されたタグIDの配列 |
| tags.* | integer | integer, exists:tags,id | タグID |

### レスポンス仕様

- **成功時 (302 Found)**:
    - `suggestion_sets`テーブルにレコードを作成後、`/suggestions/{uuid}/wait`へリダイレクトします。
- **失敗時 (422 Unprocessable Entity)**:
    - バリデーションエラーの内容を返却します。Inertiaが自動でエラーハンドリングを行います。

### 3.3. 提案待機ページ表示

- **No**: 3
- **機能名**: 提案待機ページ表示
- **URI**: `/suggestions/{uuid}/wait`
- **HTTPメソッド**: GET
- **役割**: Inertia
- **概要**: 提案生成中の待機画面を表示します。このページでステータス取得APIのポーリングが開始されます。

### リクエスト仕様

- URLパラメータ:

| パラメータ | 型 | 説明 |
| --- | --- | --- |
| uuid | string (UUID) | 提案セットを識別するID |

### レスポンス仕様

- **成功時 (200 OK)**:
    - `Inertia::render` により、Reactの`SuggestionWaitPage`コンポーネントを描画します。

```json
{
  "uuid": "f47ac10b-58cc-4372-a567-0e02b2c3d479"
}
```

- **失敗時 (404 Not Found)**:
    - 指定された`uuid`の提案セットが存在しない場合に返却します。

### 3.4. 提案ステータス取得

- **No**: 4
- **機能名**: 提案ステータス取得
- **URI**: `/api/v1/suggestions/{uuid}/status`
- **HTTPメソッド**: GET
- **役割**: API
- **概要**: 待機ページから定期的に呼び出され、提案ジョブの進捗状況と中間生成物を返します。

### リクエスト仕様

- URLパラメータ:


| パラメータ | 型 | 説明 |
| --- | --- | --- |
| uuid | string (UUID) | 提案セットを識別するID |

### レスポンス仕様

- **成功時 (200 OK)**:
    - **ボディ (application/json)**:JSON

    ```json
    {
      "status": "analyzing_items", // suggestion_sets.status ENUM値
      "message": "あなたへのおすすめを分析中...",
      "found_clusters": [ // 中間生成物
        { "id": 1, "name": "鎌倉" },
        { "id": 5, "name": "箱根" }
      ]
    }
    ```

    - `status`が`complete`になったら、フロントエンドは提案結果一覧ページへ遷移します。
- **失敗時 (404 Not Found)**:
    - 指定された`uuid`の提案セットが存在しない場合に返却します。

### 3.5. 提案結果一覧表示

- **No**: 5
- **機能名**: 提案結果一覧表示
- **URI**: `/suggestions/{uuid}`
- **HTTPメソッド**: GET
- **役割**: Inertia
- **概要**: 生成が完了した複数の旅行先（クラスター）候補を一覧で表示します。

### リクエスト仕様

- URLパラメータ:


| パラメータ | 型 | 説明 |
| --- | --- | --- |
| uuid | string (UUID) | suggestion_setsを識別するID |

### レスポンス仕様

- **成功時 (200 OK)**:
    - `Inertia::render` により、Reactの`SuggestionResultPage`コンポーネントを描画します。
    - **Props (データ構造例)**:JSON

    ```json
    {
      "suggestion_set": {
        "uuid": "f47ac10b-58cc-4372-a567-0e02b2c3d479",
        "created_at": "2025-10-13T01:40:00Z",
        "items": [
          {
            "display_order": 1,
            "travel_time_text": "車で約1時間30分",
            "cluster": { "id": 1, "name": "鎌倉" },
            "key_visual_image": { "id": 101, "storage_path": "/images/kamakura.jpg", "alt_text": "..." },
            "catchphrase": { "id": 201, "content": "古都の風を感じる、癒やしの休日" }
          }
          // ...
        ]
      }
    }
    ```

- **失敗時 (404 Not Found)**:
    - 指定された`uuid`の提案セットが存在しない、または`status`が`complete`でない場合に返却します。

### 3.6. 観光地域詳細表示

- **No**: 6
- **機能名**: 観光地域詳細表示
- **URI**: `/clusters/{suggestion_set_item_uuid}`
- **HTTPメソッド**: GET
- **役割**: Inertia
- **概要**: 選択されたオススメ観光地域（クラスター）のモデルプランやスポット情報を詳細に表示します。

### リクエスト仕様

- URLパラメータ:


| パラメータ | 型 | 説明 |
| --- | --- | --- |
| `suggestion_set_item_uuid` | string (UUID) | suggestion_set_itemsを識別するID |

### レスポンス仕様

- **成功時 (200 OK)**:
    - `Inertia::render` により、Reactの`ClusterDetailPage`コンポーネントを描画します。
    - **Props (データ構造例)**:JSON

    ```json
    {
      "cluster": {
        "id": 1,
        "name": "鎌倉",
        "default_model_plan": {
          "id": 1,
          "name": "鎌倉満喫 日帰り定番プラン",
          "description": "...",
          "items": [
            {
              "display_order": 1,
              "spot": { "id": 1, "name": "鶴岡八幡宮", "location": { ... } },
              "duration_minutes": 60,
              "travel_time_to_next_minutes": 15,
              "travel_mode": "walk"
            }
            // ...
          ]
        }
      }
    }
    ```

- **失敗時 (404 Not Found)**:
    - 指定された`cluster_id`のクラスターが存在しない場合に返却します。

### 3.7. 明示的フィードバック送信

- **No**: 7
- **機能名**: 明示的フィードバック送信
- **URI**: `/api/v1/spots/{spot_id}/interest`
- **HTTPメソッド**: POST
- **役割**: API
- **概要**: 各スポットに対するユーザーの「気になる」「興味なし」の意思表示をサーバーに記録します。

### リクエスト仕様

- URLパラメータ:


| パラメータ | 型 | 説明 |
| --- | --- | --- |
| spot_id | integer | スポットを識別するID |
- ボディ (application/json):


| キー | 型 | バリデーション | 説明 |
| --- | --- | --- | --- |
| status | string | required, in:interested,dismissed | ユーザーの意思表示 |

### レスポンス仕様

- **成功時 (204 No Content)**:
    - リクエストが成功し、レスポンスボディがないことを示します。
- **失敗時 (404 Not Found)**:
    - 指定された`spot_id`のスポットが存在しない場合に返却します。
- **失敗時 (422 Unprocessable Entity)**:
    - `status`の値が不正な場合に返却します。

### 3.8. ユーザー行動ログ記録

- **No**: 8
- **機能名**: ユーザー行動ログ記録
- **URI**: `/api/v1/logs/action`
- **HTTPメソッド**: POST
- **役割**: API
- **概要**: 提案の表示や詳細クリックなど、ユーザーの暗黙的な行動ログを記録します。フロントエンドから非同期で送信されることを想定します。

### リクエスト仕様

- ボディ (application/json):


| キー | 型 | バリデーション | 説明 |
| --- | --- | --- | --- |
| action_type | string | required, in:impression,view_cluster_detail,... | user_action_logs.action_typeのENUM値 |
| target_type | string | required, string | アクション対象のモデル名 (例: Cluster, Spot) |
| target_id | integer | required, integer | アクション対象のID |

### レスポンス仕様

- **成功時 (204 No Content)**:
    - リクエストが成功し、レスポンスボディがないことを示します。
- **失敗時 (422 Unprocessable Entity)**:
    - リクエストボディのパラメータが不正な場合に返却します。
