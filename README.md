# 日帰り地図帳 (Daytrip Atlas)

AIによる徹底したパーソナライズで、ユーザー一人ひとりの心に響く「旅の発見」体験を創出するWebサービス。

## 概要

本プロジェクトは、日帰り旅行先の調査・計画段階で多くの人が感じる「検索疲れ」や「意思決定の面倒さ」という精神的負担を解消することを目的としています。

出発地を入力するだけで、AIがユーザーの潜在的な好みまでを汲み取り、最適な日帰り旅行プランを複数提案。ユーザーを「探す」行為から解放し、純粋な「選ぶ」楽しみと「発見」の喜びを提供します。

## 主な機能 (MVP)

- **旅行提案機能**: 出発地といくつかのタグを選択するだけで、複数の日帰り旅行プランが提案されます。
- **非同期処理**: 提案の生成はバックグラウンドで非同期に実行され、ユーザーは待機ページで進捗を確認できます。
- **モデルプラン表示**: 提案された各地域について、タイムライン形式のモデルプランやスポット情報を地図と共に確認できます。
- **フィードバック機能**: 各スポットに対して「気になる」「興味なし」の意思表示ができ、このデータは将来のパーソナライゼーション精度向上に活用されます。
- **コンテンツ管理機能**: 運営者がWeb UIを通じて、スポットやモデルプランなどのマスターデータを管理（CRUD）できます。

## 技術スタック

- **バックエンド**: Laravel
- **フロントエンド**: React (Inertia.js 経由)
- **データベース**: PostgreSQL + PostGIS
- **テスト**: Pest

## アーキテクチャ

開発速度を優先するMVPフェーズでは、`Laravel` + `Inertia.js` + `React`による「モダンなモノリス」構成を採用しています。

- **ハイブリッドアプローチ**: ページの描画を伴うリクエストはInertiaが、ページ遷移を伴わない非同期のデータ通信は`/api/*`エンドポイントが担うことで、責務を分離しています。
- **非同期処理**: 提案生成などの重い処理は、Laravelのキューシステムを利用してバックグラウンドジョブとして実行し、ユーザー体験を損なわない設計となっています。

## ドキュメント

本プロジェクトに関する主要なドキュメントは`documents`ディレクトリに格納されています。

- **企画書**: [`documents/proposal.md`](/documents/proposal.md)
- **DB設計書**: [`documents/DB_DesignDocument.md`](documents/DB_DesignDocument.md)
- **MVP要件定義書**: [`documents/MVP_RequirementsSpecificationDocument.md`](documents/MVP_RequirementsSpecificationDocument.md)
- **MVP API設計書**: [`documents/MVP_API_DesignDocument.md`](documents/MVP_API_DesignDocument.md)

## セットアップ

```bash
# 1. リポジトリをクローン
git clone https://github.com/TaketoUsui/daytrip-atlas.git
cd daytrip-atlas

# 2. 初期化（dockerコンテナの立ち上げと、コンテナ内での各種操作）
scripts/init.sh

# 3. FEサーバー起動
docker-compose exec node npm run dev
```

## データベース設計

- **スポット中心アプローチ**: すべての情報の最小単位を「スポット」と定義し、これを中心にデータ構造を設計することで、柔軟なプランニングと高い再利用性を実現しています。
- **ER図**や各テーブルの詳細は、[DB設計書](documents/DB_DesignDocument.md)を参照してください。

## API仕様

- ユーザーの行動ログ記録や明示的フィードバックなど、非同期通信に使用するAPIのエンドポイント仕様は、[API設計書](documents/MVP_API_DesignDocument.md)に定義されています。
