#!/bin/sh

# もしコマンドが失敗したら、スクリプトを直ちに終了する
set -e

echo "Dockerコンテナを起動します..."
docker-compose up -d --build

# .env ファイルが存在しない場合のみ、コピーとキー生成を実行
if [ ! -f .env ]; then
    echo ".envファイルを作成します..."
    docker-compose exec php cp .env.example .env

    echo "Laravelアプリケーションキーを生成します..."
    docker-compose exec php php artisan key:generate

    docker-compose exec php php artisan migrate
else
    echo ".envファイルは既に存在します。コピーとkey:generateをスキップします。"
fi

echo "初期セットアップが完了しました！"
echo "次に、別のターミナルで 'docker-compose logs -f node' を実行して開発サーバーの状態を確認してください。"
