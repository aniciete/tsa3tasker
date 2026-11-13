#!/usr/bin/env bash
set -euo pipefail

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$DIR"

FTP_HOST="${FTP_HOST:-ftpupload.net}"
FTP_PORT="${FTP_PORT:-21}"
FTP_USER="${FTP_USER:-if0_43431425}"
FTP_PASS="${FTP_PASS:-}"
REMOTE_HTDOCS="htdocs"
ZIP_NAME="tsa3tasker-infinityfree.zip"
ZIP_PATH="$DIR/$ZIP_NAME"
EXTRACT_PHP="$DIR/extract.php"
APP_URL="${APP_URL:-http://tsa3.freedev.app}"

if [ -z "$FTP_PASS" ]; then
    echo "Error: FTP_PASS environment variable is required (e.g. FTP_PASS=... ./deploy-infinityfree.sh)." >&2
    exit 1
fi

if [ ! -f "$ZIP_PATH" ]; then
    echo "==> Building $ZIP_NAME..."
    chmod +x "$DIR/build-infinityfree-zip.sh"
    "$DIR/build-infinityfree-zip.sh"
fi

if [ ! -f "$EXTRACT_PHP" ]; then
    echo "Error: $EXTRACT_PHP is required before uploading." >&2
    exit 1
fi

echo "==> Testing FTP connection to $FTP_HOST:$FTP_PORT..."
curl --connect-timeout 20 --max-time 30 -s --user "$FTP_USER:$FTP_PASS" "ftp://$FTP_HOST/$REMOTE_HTDOCS/" > /dev/null

echo "==> Cleaning default InfinityFree placeholder index2.html if present..."
curl -s --user "$FTP_USER:$FTP_PASS" -Q "DELE /$REMOTE_HTDOCS/index2.html" "ftp://$FTP_HOST/$REMOTE_HTDOCS/" > /dev/null 2>&1 || true

echo "==> Uploading $ZIP_NAME..."
curl --connect-timeout 30 --max-time 600 -T "$ZIP_PATH" --user "$FTP_USER:$FTP_PASS" "ftp://$FTP_HOST/$REMOTE_HTDOCS/$ZIP_NAME"

echo "==> Uploading extract.php..."
curl --connect-timeout 20 --max-time 60 -T "$EXTRACT_PHP" --user "$FTP_USER:$FTP_PASS" "ftp://$FTP_HOST/$REMOTE_HTDOCS/extract.php"

echo "==> Upload complete. Triggering $APP_URL/extract.php..."
curl -sL "$APP_URL/extract.php"
echo ""
