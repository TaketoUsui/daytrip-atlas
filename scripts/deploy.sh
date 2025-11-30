#!/bin/bash

# VPS本番デプロイスクリプト
# このスクリプトはVPS上で実行されることを想定しています

set -e

# 色付きログ出力
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# デプロイディレクトリ (デフォルト)
DEPLOY_DIR="${DEPLOY_DIR:-/var/www/daytrip-atlas}"
BACKUP_ENABLED="${BACKUP_ENABLED:-true}"

log_info "====================================="
log_info "Daytrip Atlas - Production Deployment"
log_info "====================================="
log_info "Deploy Directory: $DEPLOY_DIR"

# カレントディレクトリをデプロイディレクトリに変更
cd $DEPLOY_DIR

# .envファイルの存在確認
if [ ! -f .env ]; then
    log_error ".env file not found!"
    log_error "Please create .env file from .env.production.example"
    exit 1
fi

# バックアップ作成 (オプション)
if [ "$BACKUP_ENABLED" = "true" ]; then
    BACKUP_DIR="/var/backups/daytrip-atlas/$(date +%Y%m%d_%H%M%S)"
    log_info "Creating backup at $BACKUP_DIR..."
    mkdir -p $BACKUP_DIR

    # データベースバックアップ
    if docker-compose -f compose.production.yml ps db | grep -q "Up"; then
        log_info "Backing up database..."
        docker-compose -f compose.production.yml exec -T db pg_dump -U daytrip_user daytrip_atlas_db > $BACKUP_DIR/database.sql || log_warn "Database backup failed"
    fi

    # 設定ファイルのバックアップ
    cp .env $BACKUP_DIR/.env || log_warn ".env backup failed"

    log_info "Backup completed: $BACKUP_DIR"
fi

# Gitから最新コードを取得 (Gitリポジトリの場合)
if [ -d .git ]; then
    log_info "Pulling latest changes from git..."
    git pull origin main
else
    log_warn "Not a git repository. Skipping git pull."
fi

# Node.js依存関係のインストール (必要に応じて)
if [ -f package.json ]; then
    log_info "Installing Node.js dependencies..."
    npm ci --production=false

    log_info "Building frontend assets..."
    npm run build
fi

# Composer依存関係のインストール (本番環境用イメージに含まれているためスキップ可能)
# log_info "Installing PHP dependencies..."
# docker-compose -f compose.production.yml exec php composer install --no-dev --optimize-autoloader

# Dockerイメージをビルド
log_info "Building Docker images..."
docker-compose -f compose.production.yml build --no-cache

# コンテナの再起動
log_info "Restarting containers..."
docker-compose -f compose.production.yml down
docker-compose -f compose.production.yml up -d

# ヘルスチェック待機
log_info "Waiting for services to be healthy..."
sleep 10

# マイグレーション実行
log_info "Running database migrations..."
docker-compose -f compose.production.yml exec -T php php artisan migrate --force

# ストレージリンク作成 (初回のみ必要)
log_info "Creating storage link..."
docker-compose -f compose.production.yml exec -T php php artisan storage:link || log_warn "Storage link already exists"

# キャッシュ最適化
log_info "Optimizing application caches..."
docker-compose -f compose.production.yml exec -T php php artisan config:cache
docker-compose -f compose.production.yml exec -T php php artisan route:cache
docker-compose -f compose.production.yml exec -T php php artisan view:cache

# Queue Workerの再起動 (キューに溜まったジョブを処理)
log_info "Restarting queue workers..."
docker-compose -f compose.production.yml restart queue

# 不要なDockerリソースを削除
log_info "Cleaning up unused Docker resources..."
docker system prune -f

# サービス状態確認
log_info "Checking service status..."
docker-compose -f compose.production.yml ps

log_info "====================================="
log_info "Deployment completed successfully! ✅"
log_info "====================================="
log_info ""
log_info "Next steps:"
log_info "1. Check application logs: docker-compose -f compose.production.yml logs -f"
log_info "2. Monitor queue workers: docker-compose -f compose.production.yml logs -f queue"
log_info "3. Verify health: curl -k https://your-domain.com/health"
