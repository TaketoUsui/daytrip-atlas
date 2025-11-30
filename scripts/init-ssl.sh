#!/bin/bash

# SSL証明書取得スクリプト
# Let's Encryptを使用してSSL証明書を初期取得します
# 使用方法: ./scripts/init-ssl.sh your-domain.com your-email@example.com

set -e

# 引数チェック
if [ $# -lt 2 ]; then
    echo "使用方法: $0 <domain> <email>"
    echo "例: $0 example.com admin@example.com"
    exit 1
fi

DOMAIN=$1
EMAIL=$2

echo "=== SSL証明書の初期取得を開始します ==="
echo "ドメイン: $DOMAIN"
echo "メール: $EMAIL"
echo ""

# 必要なディレクトリを作成
echo "必要なディレクトリを作成中..."
mkdir -p docker-volumes/certbot-www

# 一時的なnginx設定でHTTPサーバーのみ起動
echo "一時的なnginx設定を作成中..."
cat > .docker/nginx/temp-ssl-init.conf << 'EOF'
server {
    listen 80;
    server_name _;

    location ^~ /.well-known/acme-challenge/ {
        root /var/www/certbot;
        allow all;
    }

    location / {
        return 200 "SSL initialization in progress...\n";
        add_header Content-Type text/plain;
    }
}
EOF

# docker-compose.ymlを一時的に上書き
echo "Nginxコンテナを起動中..."
docker-compose -f compose.production.yml up -d nginx

# 少し待つ
echo "Nginxの起動を待機中..."
sleep 5

# SSL証明書を取得
echo "SSL証明書を取得中..."
docker-compose -f compose.production.yml run --rm certbot certonly \
    --webroot \
    --webroot-path=/var/www/certbot \
    --email $EMAIL \
    --agree-tos \
    --no-eff-email \
    -d $DOMAIN

# 証明書が正常に取得できたか確認
if [ $? -eq 0 ]; then
    echo ""
    echo "=== SSL証明書の取得に成功しました ==="
    echo ""
    echo "次のステップ:"
    echo "1. .docker/nginx/production.conf の 'YOUR_DOMAIN' を '$DOMAIN' に置き換えてください"
    echo "2. docker-compose -f compose.production.yml down でコンテナを停止"
    echo "3. docker-compose -f compose.production.yml up -d でSSL対応のnginxを起動"
    echo ""

    # 自動的にドメイン名を置換
    if [ -f .docker/nginx/production.conf ]; then
        echo "production.conf のドメイン名を自動置換中..."
        sed -i "s/YOUR_DOMAIN/$DOMAIN/g" .docker/nginx/production.conf
        echo "✓ production.conf を更新しました"
    fi
else
    echo ""
    echo "=== エラー: SSL証明書の取得に失敗しました ==="
    echo "以下を確認してください:"
    echo "1. ドメイン名が正しく、VPSのIPアドレスに向いているか"
    echo "2. ポート80がファイアウォールで開放されているか"
    echo "3. 他のWebサーバーがポート80を使用していないか"
    exit 1
fi
