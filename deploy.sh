#!/usr/bin/env bash
#
# RCMS production deploy script.
# Run on the server as the `deploy` user. Invoked by GitHub Actions on push to main,
# or manually:  ssh deploy@server 'bash /var/www/rcms/deploy.sh'
#
set -euo pipefail

APP_DIR="/var/www/rcms"
PHP="/usr/bin/php8.4"
BRANCH="main"

cd "$APP_DIR"

echo "==> Maintenance mode ON"
$PHP artisan down --render="errors::503" --retry=15 || true

# Always leave maintenance mode on exit, even on failure.
trap '$PHP artisan up || true' EXIT

echo "==> Fetching latest $BRANCH"
git fetch --prune origin "$BRANCH"
git reset --hard "origin/$BRANCH"

echo "==> Composer install (production)"
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Building frontend assets"
npm ci
npm run build

echo "==> Database migrations"
$PHP artisan migrate --force

echo "==> Rebuilding caches"
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache
$PHP artisan storage:link || true

echo "==> Restarting queue workers"
$PHP artisan queue:restart

echo "==> Deploy complete"
