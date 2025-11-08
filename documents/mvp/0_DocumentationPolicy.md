# 日帰り地図帳 ドキュメント作成方針 (MVPフェーズ版)

## 1\. 本方針の目的

本ドキュメントは、Webサービス「日帰り地図帳」の**MVP（実用最小限の製品）開発**を迅速かつ高品質に実現するため、現時点（企画書・DB設計が完了した段階）で必要となるドキュメントの体系と指針を定義する。

## 2\. 基本原則 (Core Principles)

1.  **Docs as Code (コードとしてのドキュメント):**
    * 本方針で定義するドキュメント（主にMarkdown）は、ソースコードと同じGitリポジトリでバージョン管理する。
    * ドキュメントの変更は、コードと同様にPull Request (PR) ベースで行う。
2.  **既存SSOTの尊重 (Refer, Don't Repeat):**
    * 「Why（企画・戦略）」に関する情報は `[1_proposal.md](../1_proposal.md)` を、「データモデル」に関する情報は `[2_DB_DesignDocument.md](../2_DB_DesignDocument.md)` を絶対的なSSOTとする。
    * 他のドキュメントは、これらの情報を参照（リンク）し、決して複製・再定義しない。
3.  **MVPスコープへのフォーカス:**
    * すべてのドキュメントは、MVPの「コア体験フロー」（出発地入力、待機、結果一覧、詳細閲覧）を実現するために作成される。MVPスコープ外の機能（例: 会員登録、フィードバック機能）に関するドキュメント作成は、Phase 1以降で行う。

## 3\. ドキュメント体系 (MVPフェーズ)

既存ドキュメントを「**Phase 0 (完了済み)**」として定義し、「**Phase 1 (MVP設計)**」と「**Phase 2 (MVP実装)**」で作成するドキュメントを明確化する。

-----

### Phase 0: 完了済み (SSOT)

**目的:** プロジェクトの「Why」と「データ構造のHow」を定義する、すべての開発の基盤。

#### ドキュメント 1: 企画書 (The "Why" & "What")

* **SSOT:** [1_proposal.md](../1_proposal.md)
* **役割:** 元方針における `PR-FAQ`, `BRD`, `ユーザーペルソナ`, `ジャーニーマップ` の役割を兼ねる。
* **MVP開発での参照箇所:**
    * **ビジョン (Why):** 1.1. ビジョン
    * **ペルソナ (Who):** 1.2. 解決する課題とターゲットユーザー
    * **コア体験 (What):** 2.2. プロダクト概要とコア体験フロー, 5.1. 主要画面設計
    * **スコープ (Scope):** 6.3. プロダクトロードマップ (MVPの定義)
    * **技術選定 (How):** 6.1. 技術設計

#### ドキュメント 2: DB設計書 (The "How" - Data)

* **SSOT:** [2_DB_DesignDocument.md](../2_DB_DesignDocument.md)
* **役割:** 元方針における `データモデル定義 (ER図 / スキーマ)` の役割を担う。
* **MVP開発での参照箇所:**
    * **ER図:** 2. ER図
    * **テーブル定義:** 3. テーブル定義 (特に `spots`, `clusters`, `suggestion_sets` などMVPコア機能関連)
    * **用語定義:** `user_action_logs` の `action_type` など、`ユビキタス言語` の一部として機能する。

-----

### Phase 1: MVP設計 (The "What" & "How")

**目的:** Phase 0 で定義された「What」を、`Inertia.js` + `React` 構成の「How」（実装）に落とし込むための「設計図」を作成する。

#### ドキュメント 3: 機能仕様書 (ユーザーストーリー & BDDシナリオ)

* **目的 (Why):** MVPのコア体験フロー（[1_proposal.md](../1_proposal.md) 2.2., 5.1.）を、開発可能なタスク単位の「振る舞い」として具体化する。
* **主な内容 (What):**
    * **対象機能 (MVPスコープ):**
        1.  トップページ（出発地入力）
        2.  提案待機ページ（進捗表示）
        3.  提案結果一覧ページ（カード表示）
        4.  観光地域詳細ページ（モデルプラン表示）
    * **ユーザーストーリー:** 「[ペルソナ]として、[目的]のために、[機能]がしたい」形式。
    * **BDDシナリオ (Gherkin記法):**
        * Feature: (例) 提案結果の閲覧
        * Scenario: (例) 提案が正常に完了し、結果一覧が表示される
        * Given: ユーザーが提案待機ページで待機している
        * When: 提案生成ジョブ (status: 'complete') が完了する
        * Then: 提案結果一覧ページにリダイレクトされ、複数の観光地域カードが表示される
* **オーナー:** PdM / 開発者
* **こだわりポイント:**
    * MVPスコープ外（例: 会員登録、フィードバック）のシナリオは含めない。
    * 「提案待機ページ」での進捗表示（`suggestion_sets.status` の変化）など、非同期処理の振る舞いを明確に定義する。

#### ドキュメント 4: ユビキタス言語集 (MVP版)

* **目的 (Why):** [1_proposal.md](../1_proposal.md) と [2_DB_DesignDocument.md](../2_DB_DesignDocument.md) に登場する用語の「揺れ」を防ぎ、コード（変数名、関数名）に一貫性を持たせる。
* **主な内容 (What):**
    * 既存ドキュメントから抽出した最重要用語の定義を一覧化する。
    * **例:**
        * **スポット (Spot):** 観光地点の最小単位。（`spots` テーブル）
        * **クラスター (Cluster):** `spots` をグループ化した観光地域。（`clusters` テーブル）
        * **提案セット (Suggestion Set):** 1回の検索リクエスト。（`suggestion_sets` テーブル）
        * **提案アイテム (Suggestion Set Item):** 提案セットに含まれる個別の旅行先（クラスター）。（`suggestion_set_items` テーブル）
* **オーナー:** チーム全員
* **注意点:** MVPで使わない用語（例: `user_spot_interests`）の定義はPhase 1まで遅延させる。

-----

### Phase 2: MVP実装 (The "How" - Implementation)

**目的:** `Inertia.js` 構成特有の「バックエンドとフロントエンドの契約」および「フロントエンド内部の設計」を定義し、実装の品質と一貫性を担保する。

#### ドキュメント 5: システムアーキテクチャ (C4 Model - MVP版)

* **目的 (Why):** [1_proposal.md](../1_proposal.md) (6.1) の「モノリシック構成」と「将来の分離」の構想を、C4 Model を用いて視覚化し、全体像の共通認識を持つ。
* **主な内容 (What):**
    * **Level 1: System Context (文脈):**
        * `日帰り地図帳システム` と、それに関わる `ユーザー（匿名）`、`GPS (ブラウザ)`、`Google Places API`、`AI (Gemini API)`、`アフィリエイト先` との関係図。
    * **Level 2: Containers (コンテナ):**
        * MVPのモノリシック構成を示す図。
        * **コンテナ:** `Web Application (Laravel + React/Inertia)`、`Database (PostgreSQL + PostGIS)`、`Queue (Redis/DB)`、`Job Worker (Laravel)` の4つで構成される。
        * **オーナー:** Tech Lead (TL) / 開発者
* **こだわりポイント:**
    * `[1_proposal.md](../1_proposal.md)` (6.2) で言及されている「非同期処理（キューシステム）」が Level 2 に明確に描かれていること。

#### ドキュメント 6: ページプロパティ定義 (Inertia.js)

* **目的 (Why):** `Inertia.js` アーキテクチャにおける\*\*バックエンド (Laravel) とフロントエンド (React) の間の「契約」\*\*を定義する。これは、従来の `OpenAPI (JSON API)` 仕様書に代わるものである。
* **主な内容 (What):**
    * Laravel のコントローラから `Inertia::render()` で渡される**ページコンポーネント名**と、それに渡される**Props（データ）のスキーマ**を定義する。
    * **共有 Props (Shared Props):** すべてのページで共通して渡されるデータ。（例: `flashMessages`, `errors`）
    * **ページ別 Props:**
        * **Component:** `Top/Index`
            * Props: (特になし)
        * **Component:** `Suggestion/Show` (提案待機・結果一覧ページ)
            * Props:
                * `suggestionSet`: (Object)
                    * `uuid`: (string)
                    * `status`: (enum: 'pending', 'processing\_clusters', ...)
                    * `items`: (Array\<Object\> | null) ※statusが 'complete' の場合のみ
                        * `uuid`: (string)
                        * `cluster_name`: (string)
                        * `key_visual_url`: (string)
                        * `catchphrase_content`: (string)
                        * `travel_time_text`: (string)
        * **Component:** `Cluster/Detail` (観光地域詳細ページ)
            * Props:
                * `cluster`: (Object)
                * `modelPlan`: (Object)
                * `spots`: (Array\<Object\>)
* **オーナー:** バックエンド開発者 / フロントエンド開発者
* **こだわりポイント:**
    * データの型、必須/任意（Null許容性）を厳密に定義する。
    * この定義は、フロントエンドのモックデータ作成や、バックエンドのレスポンス（リソースクラス）実装の直接的なインプットとなる。

#### ドキュメント 7: フロントエンド設計書 (React)

* **目的 (Why):** バックエンド寄りの設計（`[1_proposal.md](../1_proposal.md)`, `[2_DB_DesignDocument.md](../2_DB_DesignDocument.md)`）は存在するが、フロントエンドの実装（React）に関する設計が不足しているため、これを補う。
* **主な内容 (What):**
    * **1. コンポーネント設計:**
        * `[1_proposal.md](../1_proposal.md)` (5.1. 主要画面設計) に対応するReactコンポーネントの**ディレクトリ構造**と**責務の分離**方針。
        * （例: `Pages/` (Inertiaページコンポーネント), `Components/Shared/` (共通UI), `Components/Domain/` (ドメイン固有: `SpotCard`, `ModelPlanTimeline` など)）
        * 主要なドメインコンポーネント（例: `SpotCard`）が受け取る `props` の定義。
    * **2. 状態管理 (State Management):**
        * MVPにおける状態管理の方針を定義する。
        * **グローバル状態:** 基本的に `Inertia.js` から渡されるProps（`usePage()` フック）をSSOTとし、原則としてフロント側でグローバル状態を持たない（`Zustand` や `Redux` は導入しない）。
        * **ローカル状態:** フォーム入力（例: トップページの出発地）やUIの状態（例: モーダルの開閉）は、Reactの `useState` フックで管理する。
    * **3. スタイリング方針:**
        * 使用する技術（例: **Tailwind CSS**）と、その運用ルール（例: `className` の記述順序、`@apply` の使用禁止など）を定義する。
* **オーナー:** フロントエンド開発者
* **注意点:** MVPではシンプルさを最優先し、過度な抽象化や複雑な状態管理ライブラリの導入を避ける方針を明記する。

#### ドキュメント 8: アーキテクチャ決定記録 (ADRs)

* **目的 (Why):** MVP開発における重要な技術的「意思決定」の論拠を記録し、将来の技術的負債を防ぐ。
* **主な内容 (What):**
    * **ADR-001: MVPのモノリシック構成（Inertia.js）採用**
        * Context: MVPを2週間で開発する必要がある。
        * Decision: APIを分離せず、Inertia.jsによるモノリシック構成を採用する。
        * Rationale: 開発速度の最大化。フロントとバックの型定義の不整合リスク低減。
        * Consequences: 将来的なマイクロサービス化（`[1_proposal.md](../1_proposal.md)` 6.1.）の際には改修が必要。
    * **ADR-002: PostGISの採用**
        * Context: 出発地からの距離やクラスタリング（`[1_proposal.md](../1_proposal.md)` 6.1. Step 3）が必要。
        * Decision: PostgreSQL と PostGIS拡張を採用する。
* **オーナー:** TL / 開発者

#### ドキュメント 9: (簡易) 運用・監視設計書

* **目的 (Why):** MVPは「コア体験の検証」が目的だが、サービスが停止していては検証できないため、最低限の「死活監視」と「異常検知」を定義する。
* **主な内容 (What):**
    * **監視 (Monitoring):**
        * （必須）**ジョブキュー監視:** 提案生成ジョブ（`suggestion_sets`）が詰まっていないか、失敗（`failed_jobs`）していないかを監視する。
        * （必須）**エラーロギング:** Laravel のログ（特に `ERROR` レベル以上）を収集・通知する仕組み（例: Sentry, Slack通知）。
    * **アラート (Alerting):**
        * （必須）`failed_jobs` にレコードが追加されたら、即時開発者に通知する。
    * **SLI / SLO:** MVPフェーズでは定義しない。
* **オーナー:** TL / 開発者

## 4\. ドキュメントの運用・保守 (MVPフェーズ)

1.  **レビュープロセス (Docs as Code):**
    * Phase 1, 2 のドキュメント（`ドキュメント 3〜9`）は、**実装コードのPRを作成する前に**、ドキュメントのPRを作成し、合意を得ることを原則とする（設計先行）。
    * MVPフェーズ（2週間）の速度を鑑み、PRのレビューはセルフレビュー＋口頭での確認でも可とするが、必ず `main` ブランチにマージする。
2.  **更新のトリガー:**
    * `ドキュメント 6 (ページプロパティ定義)` は、\*\*最重要の「契約書」\*\*である。バックエンドが渡すPropsを変更する場合、またはフロントエンドが必要とするPropsが変更になる場合は、**必ずこのドキュメントを先に更新**し、PRで合意を得てから実装に着手する。
