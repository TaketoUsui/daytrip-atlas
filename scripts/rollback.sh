#!/bin/bash

# ロールバックスクリプト
# 最新のバックアップからアプリケーションを復元します

set -e

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

log_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

log_warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

BACKUP_BASE_DIR="/var/backups/daytrip-atlas"
DEPLOY_DIR="${DEPLOY_DIR:-/var/www/daytrip-atlas}"

log_info "====================================="
log_info "Daytrip Atlas - Rollback"
log_info "====================================="

# バックアップディレクトリの存在確認
if [ ! -d "$BACKUP_BASE_DIR" ]; then
    log_error "Backup directory not found: $BACKUP_BASE_DIR"
    exit 1
fi

# 利用可能なバックアップをリスト表示
log_info "Available backups:"
BACKUPS=($(ls -1dt $BACKUP_BASE_DIR/*))

if [ ${#BACKUPS[@]} -eq 0 ]; then
    log_error "No backups found!"
    exit 1
fi

# 最新5件のバックアップを表示
for i in "${!BACKUPS[@]}"; do
    if [ $i -lt 5 ]; then
        echo "  [$i] $(basename ${BACKUPS[$i]})"
    fi
done

# ロールバック先を選択
echo ""
read -p "Which backup do you want to restore? [0]: " BACKUP_INDEX
BACKUP_INDEX=${BACKUP_INDEX:-0}

if [ ! -d "${BACKUPS[$BACKUP_INDEX]}" ]; then
    log_error "Invalid backup selection!"
    exit 1
fi

RESTORE_DIR="${BACKUPS[$BACKUP_INDEX]}"
log_info "Restoring from: $RESTORE_DIR"

# 確認
read -p "Are you sure you want to rollback? This will stop the current application. [y/N]: " CONFIRM
if [ "$CONFIRM" != "y" ] && [ "$CONFIRM" != "Y" ]; then
    log_warn "Rollback cancelled."
    exit 0
fi

cd $DEPLOY_DIR

# コンテナを停止
log_info "Stopping containers..."
docker compose -f compose.production.yml down

# データベースを復元
if [ -f "$RESTORE_DIR/database.sql" ]; then
    log_info "Restoring database..."

    # DBコンテナのみ起動
    docker compose -f compose.production.yml up -d db
    sleep 5

    # データベースを復元
    docker compose -f compose.production.yml exec -T db psql -U daytrip_user daytrip_atlas_db < $RESTORE_DIR/database.sql

    log_info "Database restored successfully!"
else
    log_warn "Database backup not found. Skipping database restore."
fi

# .envファイルを復元
if [ -f "$RESTORE_DIR/.env" ]; then
    log_info "Restoring .env file..."
    cp $RESTORE_DIR/.env .env
else
    log_warn ".env backup not found. Keeping current .env"
fi

# コンテナを再起動
log_info "Starting containers..."
docker compose -f compose.production.yml up -d

# ヘルスチェック待機
log_info "Waiting for services to be healthy..."
sleep 10

log_info "====================================="
log_info "Rollback completed! ✅"
log_info "====================================="
log_info ""
log_info "Restored from: $(basename $RESTORE_DIR)"
log_info ""
log_info "Please verify the application is working correctly."
