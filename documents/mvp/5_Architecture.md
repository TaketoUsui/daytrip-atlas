# ドキュメント 5: システムアーキテクチャ (C4 Model - MVP版)

## 1\. 本書の目的

本書は、`0_DocumentationPolicy.md` に基づき、`1_proposal.md` (企画書) の技術設計 (6.1) で構想された「MVPのモノリシック構成」と「将来の分離構想」の全体像について、C4 Model を用いて視覚化し、チームの共通認識を持つことを目的とします。

## 2\. Level 1: System Context (システム文脈図)

Level 1 は、`日帰り地図帳システム` がどのような外部アクターや外部システムと相互作用するかを示します。

- **アクター (Actor):**
    - **ユーザー (匿名):** メインの利用者。会員登録なしでサービスを利用します。
- **外部システム (External Systems):**
    - **GPS (ブラウザ):** ユーザーの現在地を取得するために使用します。
    - **Google Places API:** 出発地入力のサジェストと座標特定に使用します。
    - **AI (Gemini API):** スポット情報の収集や、パーソナライズされた提案（キャッチコピー、モデルプラン）の生成に使用します。
    - **アフィリエイト先 (例: アソビュー！):** 収益源として、アクティビティ予約サイトへ送客します。

<!-- end list -->

```mermaid
C4Context
    title システム文脈図 (C4 Level 1) - 日帰り地図帳 MVP

    Actor(user, "ユーザー (匿名)", "日帰り旅行先を探している人")

    System_Ext(gps, "GPS (ブラウザ)", "デバイスの現在地情報")
    System_Ext(google_places, "Google Places API", "地名検索サジェスト/座標特定")
    System_Ext(ai_api, "AI (Gemini API)", "スポット収集・提案生成")
    System_Ext(affiliate, "アフィリエイト先", "例: アソビュー！")

    System(daytrip_atlas, "日帰り地図帳システム (MVP)", "Laravel + Inertia.js + Reactによるモノリシック構成")

    ' ユーザーからのリクエスト
    Rel(user, daytrip_atlas, "1. 出発地を入力し提案をリクエストする")
    Rel(user, gps, "現在地を利用する")
    Rel(gps, daytrip_atlas, "現在地の緯度経度を渡す")
    Rel(daytrip_atlas, google_places, "地名入力のサジェストを要求")
    Rel(google_places, daytrip_atlas, "サジェスト結果を返す")

    ' システムの内部処理 (外部連携)
    Rel(daytrip_atlas, ai_api, "2. AIに提案生成を要求する (非同期)")
    Rel(ai_api, daytrip_atlas, "生成結果を返す")
    
    ' ユーザーへの結果表示と送客
    Rel(daytrip_atlas, user, "3. 提案結果（モデルプラン等）を表示する")
    Rel(user, daytrip_atlas, "4. 詳細ページのリンクをクリックする")
    Rel(daytrip_atlas, affiliate, "5. アフィリエイト先へ送客する")
```

## 3\. Level 2: Containers (コンテナ図)

Level 2 は、`日帰り地図帳システム` の内部構成要素（コンテナ）を示します。MVPフェーズでは、開発速度を優先したモノリシック構成を採用します。

- **コンテナ (Containers):**
    - **Web Application:** ユーザーのリクエストを受け付け、Inertia.js を介してReactコンポーネントを描画するメインアプリケーションです。提案リクエストの受付と、キューへのジョブ登録も担当します。
    - **Job Worker:** キューを監視し、重い処理（AI APIコール、DBへのデータ構築など）を非同期で実行するバックグラウンドプロセスです。
    - **Queue:** Web Application と Job Worker を疎結合にするためのキューシステムです。非同期処理の「こだわりポイント」として明示されます。
    - **Database:** 全てのマスターデータ、ユーザーセッション、提案結果を格納するデータベースです。PostGISによる地理空間クエリ機能が必須となります。

<!-- end list -->

```mermaid
C4Container
    title コンテナ図 (C4 Level 2) - 日帰り地図帳 MVP

    Actor(user, "ユーザー (匿名)", "Webブラウザ経由でアクセス")

    System_Ext(ai_api, "AI (Gemini API)", "提案生成")
    System_Ext(google_places, "Google Places API", "地名検索")

    System_Boundary(mvp_system, "日帰り地図帳システム (MVP)") {
        Container(web_app, "Web Application", "Laravel (PHP)", "ユーザーのリクエスト処理 (HTTP)、Inertia.jsでのReact描画、ジョブのキューイング")
        Container(job_worker, "Job Worker", "Laravel (PHP)", "キューを監視し、非同期で重い処理（AIコール、DB書き込み）を実行")
        Container(queue, "Queue", "Redis / DB", "Web AppとJob Workerを疎結合にするメッセージキュー")
        ContainerDb(database, "Database", "PostgreSQL + PostGIS", "スポット、クラスター、提案セット、モデルプラン等のデータを格納")
    }

    ' ユーザーからのリクエストフロー (同期)
    Rel(user, web_app, "1. 提案リクエスト (HTTPS)")
    Rel(web_app, google_places, "地名サジェストを要求 (API)")
    Rel(web_app, user, "2. 提案待機ページを即時返却 (Inertia/HTTPS)")
    Rel(user, web_app, "3. 進捗ポーリング (HTTPS)")
    Rel(web_app, database, "提案ステータスを読み取り (SQL)")
    Rel(database, web_app, "ステータスを返す (SQL)")
    Rel(web_app, user, "4. 進捗/結果を返却 (Inertia/HTTPS)")

    ' バックグラウンド処理フロー (非同期)
    Rel(web_app, queue, "1a. 提案生成ジョブを登録 (Enqueue)")
    Rel(queue, job_worker, "2a. ジョブを取得 (Dequeue)")
    Rel(job_worker, ai_api, "3a. スポット収集・プラン生成を要求 (API Call)")
    Rel(ai_api, job_worker, "4a. 生成結果を返す")
    Rel(job_worker, database, "5a. 提案結果 (suggestion_set_items, etc.) をDBに保存 (SQL)")
```
