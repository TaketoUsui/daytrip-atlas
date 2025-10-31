# MVP_API設計改

## 1. 設計思想

本設計は、Laravel + Inertia.js + Reactという技術スタックの特性を最大限に活かす**ハイブリッドアプローチ**を採用します。

- **Inertiaレンダリング (`routes/web.php`)**:
    - **役割**: ページの描画を伴うGETリクエストや、フォーム送信後にページ遷移（リダイレクト）が発生するアクションを担当します。
    - **意図**: これにより、「モダンなモノリス」としての開発効率とシンプルさを実現します。`MVP要件定義書(FUNC-009)`で求められる**運営者向けコンテンツ管理機能(Admin)**も、ユーザー向け機能と同じこのアプローチで構築します。これにより、管理画面のために別途APIやフロントエンドアプリケーションを開発するコストを完全に排除します。
- **APIエンドポイント (`routes/api.php`)**:
    - **役割**: ページ遷移を伴わない、純粋なデータ送受信（非同期通信）を担当します。
    - **意図**: これにより、ロジックの責務を明確に分離します。主に、待機中のステータス更新（ポーリング）や、ユーザーの行動（「気になる」ボタンのクリック、行動ログ）の記録など、UXを向上させるための非同期処理に限定して使用します。

---

## 2. エンドポイント一覧

### 2.1. ユーザー向け機能 (Inertiaルート)

主に `routes/web.php` に定義されます。ブラウザのページ遷移を担当します。

| **No.** | **役割** | **URI** | **HTTPメソッド** | **機能概要** | **想定Controller::Method** |
| --- | --- | --- | --- | --- | --- |
| 1 | Inertia | `/` | GET | トップページの表示 | `TopPageController::show` |
| 2 | Inertia | `/suggestions` | POST | 提案リクエストを受付、待機ページへリダイレクト | `SuggestionController::store` |
| 3 | Inertia | `/suggestions/{suggestion_set:uuid}/wait` | GET | 提案待機ページの表示 | `SuggestionPageController::wait` |
| 4 | Inertia | `/suggestions/{suggestion_set:uuid}` | GET | 提案結果一覧ページの表示 | `SuggestionPageController::show` |
| 5 | Inertia | `/suggested-cluster/{item:uuid}` | GET | 観光地域詳細ページの表示 | `SuggestionItemPageController::show` |

### 2.2. ユーザー向け機能 (APIルート)

主に `routes/api.php` に定義されます。ページ遷移を伴わない非同期通信を担当します。

| **No.** | **役割** | **URI** | **HTTPメソッド** | **機能概要** | **想定Controller::Method** |
| --- | --- | --- | --- | --- | --- |
| 6 | API | `/api/v1/suggestions/{suggestion_set:uuid}/status` | GET | 提案生成の進捗状況を取得（ポーリング用） | `SuggestionStatusController::show` |
| 7 | API | `/api/v1/spots/{spot:id}/interest` | POST | スポットへの「気になる/興味なし」を記録 | `UserSpotInterestController::store` |
| 8 | API | `/api/v1/logs/action` | POST | ユーザーの行動ログを記録 | `UserActionLogController::store` |

### 2.3. 運営者向け機能 (Inertiaルート)

`routes/web.php` に定義され、認証ミドルウェアで保護されます。

| **No.** | **役割** | **URI** | **HTTPメソッド** | **機能概要** | **想定Controller::Method** |
| --- | --- | --- | --- | --- | --- |
| 9 | Inertia | `/admin/spots` | GET | 【管理】スポット一覧表示 | `Admin\SpotController::index` |
| 10 | Inertia | `/admin/spots/create` | GET | 【管理】スポット作成画面表示 | `Admin\SpotController::create` |
| 11 | Inertia | `/admin/spots` | POST | 【管理】スポット登録処理 | `Admin\SpotController::store` |
| 12 | Inertia | `/admin/spots/{spot:id}/edit` | GET | 【管理】スポット編集画面表示 | `Admin\SpotController::edit` |
| 13 | Inertia | `/admin/spots/{spot:id}` | PUT/PATCH | 【管理】スポット更新処理 | `Admin\SpotController::update` |
| ... | Inertia | `/admin/clusters` ... | CRUD | 【管理】クラスター（観光地域）のCRUD | `Admin\ClusterController` |
| ... | Inertia | `/admin/model-plans` ... | CRUD | 【管理】モデルプランのCRUD | `Admin\ModelPlanController` |

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
    - **Props (データ構造例)**:JSON

    ```json
    {
      "tags": [
        { "id": 1, "name": "絶景" },
        { "id": 5, "name": "デート向き" }
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

- ボディ:


| **キー** | **型** | **バリデーション** | **説明** |
| --- | --- | --- | --- |
| latitude | float | required, numeric | 出発地の緯度 |
| longitude | float | required, numeric | 出発地の経度 |
| tags | array | nullable, array | 選択されたタグIDの配列 |
| tags.* | integer | integer, exists:tags,id | タグID |

### レスポンス仕様

- **成功時 (302 Found)**:
    - `suggestion_sets`テーブルにレコードを作成後、`/suggestions/{suggestion_set:uuid}/wait`へリダイレクトします。
- **失敗時 (422 Unprocessable Entity)**:
    - バリデーションエラーの内容を返却します。Inertiaが自動でエラーハンドリングを行います。

### 3.3. 提案待機ページ表示

- **No**: 3
- **機能名**: 提案待機ページ表示
- **URI**: `/suggestions/{suggestion_set:uuid}/wait`
- **HTTPメソッド**: GET
- **役割**: Inertia
- **概要**: 提案生成中の待機画面を表示します。このページでステータス取得API(No.6)のポーリングが開始されます。

### リクエスト仕様

- URLパラメータ:


    | パラメータ | 型 | 説明 |
    | --- | --- | --- |
    | suggestion_set:uuid | string (UUID) | 提案セット（suggestion_sets）を識別するID |

### レスポンス仕様

- **成功時 (200 OK)**:
    - `Inertia::render` により、Reactの`SuggestionWaitPage`コンポーネントを描画します。
    - **Props (データ構造例)**:JSON

        ```json
        {
          "uuid": "f47ac10b-58cc-4372-a567-0e02b2c3d479"
        }
        ```

- **失敗時 (404 Not Found)**:
    - 指定された`uuid`の提案セットが存在しない場合に返却します。

### 3.4. 提案結果一覧表示

- **No**: 4
- **機能名**: 提案結果一覧表示
- **URI**: `/suggestions/{suggestion_set:uuid}`
- **HTTPメソッド**: GET
- **役割**: Inertia
- **概要**: 生成が完了した複数の旅行先（クラスター）候補を一覧で表示します。

### リクエスト仕様

- URLパラメータ:


    | **パラメータ** | **型** | **説明** |
    | --- | --- | --- |
    | suggestion_set:uuid | string (UUID) | 提案セット（suggestion_sets）を識別するID |

### レスポンス仕様

- **成功時 (200 OK)**:
    - `Inertia::render` により、Reactの`SuggestionResultPage`コンポーネントを描画します。
    - **Props (データ構造例)**:JSON

        ```json
        {
          "suggestion_set": {
            "uuid": "f47ac10b-58cc-4372-a567-0e02b2c3d479",
            "items": [
              {
                "uuid": "a8a1b2c3-....", // 詳細ページへの遷移に使用
                "display_order": 1,
                "travel_time_text": "車で約1時間30分",
                "cluster": { "id": 1, "name": "鎌倉" },
                "key_visual_image": { ... },
                "catchphrase": { "content": "古都の風を感じる、癒やしの休日" }
              }
              // ...
            ]
          }
        }
        ```

- **失敗時 (404 Not Found)**:
    - 指定された`uuid`の提案セットが存在しない、または`status`が`complete`でない場合に返却します。

### 3.5. 観光地域詳細表示

- **No**: 5
- **機能名**: 観光地域詳細表示
- **URI**: `/suggested-cluster/{item:uuid}`
- **HTTPメソッド**: GET
- **役割**: Inertia
- **概要**: 選択されたオススメ観光地域（クラスター）のモデルプランやスポット情報を詳細に表示します。
- **設計意図**:
    - このURIは、DBの`suggestion_set_items`テーブルの`uuid`（`{item:uuid}`）を直接参照します。
    - これにより、「どの提案セット(`suggestion_set`)の、どの項目(`item`)か」を**一意に特定**できます。
    - `DB設計`上、同じ観光地域（例：鎌倉）でも、提案相手によって異なるキャッチコピーやモデルプランが割り当てられる可能性があります。このURI設計により、ユーザーに提示したものと寸分違わない詳細（特定のキャッチコピー、特定のモデルプラン）を正確に表示することが可能になります。
    - `suggested-cluster`というパス名は、このページが「（システムが）提案した観光地域」の詳細であることを意味的に示しています。

### リクエスト仕様

- URLパラメータ:


| パラメータ | 型 | 説明 |
| --- | --- | --- |
| item:uuid | string (UUID) | 提案セット項目（suggestion_set_items）を識別するID |

### レスポンス仕様

- **成功時 (200 OK)**:
    - `Inertia::render` により、Reactの`ClusterDetailPage`コンポーネントを描画します。
    - `item:uuid` から紐づく `cluster`, `model_plan`, `catchphrase` 等の情報を取得してPropsとして渡します。
    - **Props (データ構造例)**:JSON

        ```json
        {
          "item": {
            "uuid": "a8a1b2c3-....",
            "catchphrase": { "content": "古都の風を感じる、癒やしの休日" },
            "cluster": {
              "id": 1,
              "name": "鎌倉"
            },
            "model_plan": {
              "id": 1,
              "name": "鎌倉満喫 日帰り定番プラン",
              "items": [
                {
                  "display_order": 1,
                  "spot": { "id": 1, "name": "鶴岡八幡宮", ... },
                  "duration_minutes": 60,
                  ...
                }
                // ...
              ]
            }
          }
        }
        ```

- **失敗時 (404 Not Found)**:
    - 指定された`item:uuid`の提案アイテムが存在しない場合に返却します。

### 3.6. 提案ステータス取得

- **No**: 6
- **機能名**: 提案ステータス取得
- **URI**: `/api/v1/suggestions/{suggestion_set:uuid}/status`
- **HTTPメソッド**: GET
- **役割**: API
- **概要**: 待機ページ(No.3)から定期的に呼び出され（ポーリング）、提案ジョブの進捗状況と中間生成物を返します。

### リクエスト仕様

- URLパラメータ:


| **パラメータ** | **型** | **説明** |
| --- | --- | --- |
| suggestion_set:uuid | string (UUID) | 提案セット（suggestion_sets）を識別するID |

### レスポンス仕様

- **成功時 (200 OK)**:
    - **ボディ (application/json)**:JSON

        ```json
        {
          "status": "analyzing_items", 
          "message": "あなたへのおすすめを分析中...",
          "found_clusters": [ 
            { "id": 1, "name": "鎌倉" },
            { "id": 5, "name": "箱根" }
          ]
        }
        ```

    - `status`が`complete`になったら、フロントエンドは提案結果一覧ページ(No.4)へ遷移します。
- **失敗時 (404 Not Found)**:
    - 指定された`uuid`の提案セットが存在しない場合に返却します。

### 3.7. 明示的フィードバック送信

- **No**: 7
- **機能名**: 明示的フィードバック送信
- **URI**: `/api/v1/spots/{spot:id}/interest`
- **HTTPメソッド**: POST
- **役割**: API
- **概要**: 各スポットに対するユーザーの「気になる」「興味なし」の意思表示をサーバーに記録します (`user_spot_interests`テーブル)。

### リクエスト仕様

- URLパラメータ:


| パラメータ | 型 | 説明 |
| --- | --- | --- |
| spot:id | integer | スポット(spots)を識別するID |
- ボディ (application/json):


| キー | 型 | バリデーション | 説明 |
| --- | --- | --- | --- |
| status | string | required, in:interested,dismissed | ユーザーの意思表示 |

### レスポンス仕様

- **成功時 (204 No Content)**:
    - リクエストが成功し、レスポンスボディがないことを示します。
- **失敗時 (404 Not Found)**:
    - 指定された`spot:id`のスポットが存在しない場合に返却します。
- **失敗時 (422 Unprocessable Entity)**:
    - `status`の値が不正な場合に返却します。

### 3.8. ユーザー行動ログ記録

- **No**: 8
- **機能名**: ユーザー行動ログ記録
- **URI**: `/api/v1/logs/action`
- **HTTPメソッド**: POST
- **役割**: API
- **概要**: 提案の表示や詳細クリックなど、ユーザーの暗黙的な行動ログを`user_action_logs`テーブルに記録します。

### リクエスト仕様

- ボディ (application/json):


| キー | 型 | バリデーション | 説明 |
| --- | --- | --- | --- |
| action_type | string | required, in:impression,view_cluster_detail,... | user_action_logs.action_typeのENUM値 |
| target_type | string | required, string | アクション対象のモデル名（例: SuggestionSetItem, Spot） |
| target_id | integer | required, integer | アクション対象のID |

### レスポンス仕様

- **成功時 (204 No Content)**:
    - リクエストが成功し、レスポンスボディがないことを示します。
- **失敗時 (422 Unprocessable Entity)**:
    - リクエストボディのパラメータが不正な場合に返却します。

### 3.9. コンテンツ管理機能 (運営者向け)

- **No**: 9〜
- **機能名**: コンテンツ管理（CRUD）ページ郡
- **URI**: `/admin/spots`, `/admin/clusters`, `/admin/model-plans` など
- **HTTPメソッド**: GET, POST, PUT, DELETE (CRUD)
- **役割**: Inertia
- **概要**: `MVP要件定義書(FUNC-009)` に基づき、運営者がスポット、クラスター、モデルプラン等のマスターデータを管理するためのWeb UI機能群。
- **設計意図**:
    - これらはAPIではなく**Inertiaルート**として定義されます。
    - Laravel + Inertia.js の「モダンなモノリス」構成を活かし、ユーザー向け機能と同一の技術スタック（Controller + Reactコンポーネント）で管理画面を構築します。
    - これにより、管理画面のためだけに別途フロントエンドアプリケーションを開発・ホスティングする必要がなくなり、開発と運用のコストが大幅に削減されます。
    - `routes/web.php` 内で `/admin` プレフィックスと認証ミドルウェアによって保護されます。

### リクエスト・レスポンス仕様 (例: `/admin/spots`)

- **`GET /admin/spots` (一覧)**:
    - `Admin\SpotController::index` が `Inertia::render` で `Admin/Spots/Index.jsx` コンポーネントを返し、スポットのページネーション付き一覧を表示します。
- **`GET /admin/spots/create` (作成画面)**:
    - `Admin\SpotController::create` が `Inertia::render` で `Admin/Spots/Create.jsx` コンポーネントを返し、新規作成フォームを表示します。
- **`POST /admin/spots` (登録処理)**:
    - `Admin\SpotController::store` がバリデーションと登録処理を行い、成功したら `GET /admin/spots` へリダイレクトします。
- **(以下、編集・更新・削除も同様にInertiaのフローに準拠)**
