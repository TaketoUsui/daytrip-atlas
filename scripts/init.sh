#!/bin/sh

# もしコマンドが失敗したら、スクリプトを直ちに終了する
set -e

# --- メイン処理 ---
echo "Dockerコンテナを起動します..."
docker-compose up -d --build

echo ".envファイルを作成します..."
docker-compose exec php cp .env.example .env

echo "PHPの依存関係をインストールします..."
docker-compose exec php composer install

echo "Node.jsの依存関係をインストールします..."
docker-compose exec node npm install

echo "Laravelアプリケーションキーを生成します..."
docker-compose exec php php artisan key:generate

echo "データベースをマイグレーションします..."
docker-compose exec php php artisan migrate

echo "初期セットアップが完了しました！"
echo "次に、別のターミナルで 'docker-compose exec node npm run dev' を実行して開発を開始してください。"
