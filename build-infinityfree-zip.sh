#!/usr/bin/env bash
set -euo pipefail

DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TMP_DIR="/tmp/tsa3-deploy-$$"
OUTPUT_ZIP="$DIR/tsa3tasker-infinityfree.zip"
ENV_SOURCE="${ENV_SOURCE:-$DIR/env.production}"

if [ ! -f "$ENV_SOURCE" ]; then
    echo "Error: Production environment file not found at $ENV_SOURCE" >&2
    echo "Copy env.production.example to env.production and set APP_KEY and DB_PASSWORD first." >&2
    exit 1
fi

echo "==> Packaging lean production build for InfinityFree (tsa3.freedev.app)..."
rm -rf "$TMP_DIR" "$OUTPUT_ZIP"
mkdir -p "$TMP_DIR"

rsync -av \
  --exclude=".*" \
  --exclude="vendor" \
  --exclude="node_modules" \
  --exclude="tests" \
  --exclude="*.zip" \
  --exclude="env.production" \
  --exclude="env.production.example" \
  --exclude="build-infinityfree-zip.sh" \
  --exclude="deploy-infinityfree.sh" \
  --exclude="extract.php" \
  "$DIR/" "$TMP_DIR/" > /dev/null

# Copy shared-hosting Apache/front-controller files
cp "$DIR/.htaccess" "$TMP_DIR/.htaccess"
cp "$DIR/index.php" "$TMP_DIR/index.php"
cp "$DIR/public/.htaccess" "$TMP_DIR/public/.htaccess"

# Mirror static assets to root for shared hosts without public/ rewrite support
if [ -d "$DIR/public/assets" ]; then
    mkdir -p "$TMP_DIR/assets"
    cp -r "$DIR/public/assets/"* "$TMP_DIR/assets/"
fi
[ -f "$DIR/public/favicon.svg" ] && cp "$DIR/public/favicon.svg" "$TMP_DIR/favicon.svg"
[ -f "$DIR/public/favicon.ico" ] && cp "$DIR/public/favicon.ico" "$TMP_DIR/favicon.ico"

# Bundle production .env
cp "$ENV_SOURCE" "$TMP_DIR/.env"

# Ensure schema export and storage directories exist
mkdir -p "$TMP_DIR/database"
[ -f "$DIR/database/schema_export.sql" ] && cp "$DIR/database/schema_export.sql" "$TMP_DIR/database/schema_export.sql"

mkdir -p "$TMP_DIR/storage/app/public" \
         "$TMP_DIR/storage/framework/cache/data" \
         "$TMP_DIR/storage/framework/sessions" \
         "$TMP_DIR/storage/framework/views" \
         "$TMP_DIR/storage/logs" \
         "$TMP_DIR/bootstrap/cache"

# Install lean production Composer dependencies
cd "$TMP_DIR"
composer install --no-dev --optimize-autoloader --no-interaction --quiet

# Build archive and clean staging directory
zip -r "$OUTPUT_ZIP" . -x "*.DS_Store" > /dev/null
rm -rf "$TMP_DIR"

echo "==> Verifying package contents..."
for req in "public/index.php" "index.php" ".htaccess" "public/.htaccess" "artisan" "vendor/autoload.php" "public/assets/css/style.css" "assets/css/style.css" ".env" "database/schema_export.sql"; do
    if ! unzip -l "$OUTPUT_ZIP" | grep -q "$req"; then
        echo "Error: Required file $req is missing from $OUTPUT_ZIP" >&2
        exit 1
    fi
done

echo "==> Build successful: $OUTPUT_ZIP"
ls -lh "$OUTPUT_ZIP"
