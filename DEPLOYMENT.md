# RCMS — Deployment Runbook

Production deployment reference for **Rahmah Consultancy Management System**.
Live at **https://rahmahconsultancy.com**. First deployed 2026-07-25.

---

## 1. Overview

```
GitHub (main)  --push-->  GitHub Actions  --SSH-->  DigitalOcean Droplet
                                                     ├─ nginx (:80 → :443)
                                                     ├─ PHP 8.4-FPM
                                                     ├─ MySQL 8        (db: rcms)
                                                     ├─ Ghostscript + GD   (PDF merge)
                                                     └─ /var/www/rcms   (git clone of main)
```

- **Model:** single Droplet, self-managed. App code deployed by pulling `main`.
- **Storage:** uploaded documents + merged PDFs live on the Droplet's local disk
  (`storage/app/…`) — they persist across deploys. No S3/Spaces.
- **Deploy trigger:** every push to `main` auto-deploys (see §6).

## 2. Server

| | |
|---|---|
| Provider | DigitalOcean Droplet |
| IP | `167.172.94.34` |
| OS | Ubuntu 24.04 LTS |
| Size | 2 vCPU / 4 GB RAM / 75 GB (+ 2 GB swap) |
| Region | Singapore (sgp1) |
| Timezone | Asia/Kuala_Lumpur |
| Firewall | UFW — only OpenSSH, 80, 443 |

### SSH access
- **Admin (root):** `ssh root@167.172.94.34` — uses Harith's Mac key `~/.ssh/id_ed25519`.
- **App user (deploy):** `ssh deploy@167.172.94.34` — non-root, owns `/var/www/rcms`,
  runs the app and deploys. Has scoped passwordless sudo for **only**
  `systemctl reload/restart nginx` and `php8.4-fpm`.

## 3. Installed stack

- nginx 1.24 · PHP 8.4 (fpm+cli) · MySQL 8 · Ghostscript 10 · Composer 2 · Node 22
- PHP extensions: gd, pdo_mysql, mbstring, curl, zip, bcmath, intl, gmp, xml, openssl
- PHP limits (`/etc/php/8.4/fpm/conf.d/99-rcms.ini`): upload 64M, post 80M, memory 256M
- nginx site: `/etc/nginx/sites-available/rcms` (root `/var/www/rcms/public`, client_max_body_size 80M)

## 4. Application

| | |
|---|---|
| Path | `/var/www/rcms` (owner `deploy:www-data`) |
| Branch | `main` |
| Env file | `/var/www/rcms/.env` (`APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://rahmahconsultancy.com`) |
| Writable | `storage/` + `bootstrap/cache/` (group `www-data`, setgid) |

### Database
- DB `rcms`, user `rcms_user`@localhost. **Password is in the server `.env`** (not in git).
- Sessions / cache / queue all use the database driver (tables from Laravel migrations).

### Seeded data (production)
- Only **SettingsSeeder** + the **admin user** were seeded. `DemoLeadsSeeder` was
  intentionally **skipped** (no fake leads in production).
- Admin login: `rahmahconsultant@gmail.com` — change the password via the Akaun page.

## 5. Domain & TLS

- Domain `rahmahconsultancy.com` — DNS managed at **Exabytes**
  (nameservers `ns184/185/186.mschosting.com`).
- A records `@` and `www` → `167.172.94.34`. **No MX records** (no email on the domain).
- TLS: **Let's Encrypt** via certbot (`certbot --nginx`), covers root + www, with
  HTTP→HTTPS redirect. Auto-renews via certbot's systemd timer.
- To change the server IP later: edit the two A records in Exabytes cPanel → Zone Editor.

## 6. Auto-deploy (CI/CD)

**Push to `main` → live in ~1 minute.** No manual steps.

- Workflow: `.github/workflows/deploy.yml` (uses `appleboy/ssh-action`).
- On push it SSHes into the Droplet as `deploy` and runs `/var/www/rcms/deploy.sh`.
- `deploy.sh` steps: maintenance mode on → `git reset --hard origin/main` →
  `composer install --no-dev` → `npm ci && npm run build` → `migrate --force` →
  cache config/routes/views → `queue:restart` → maintenance mode off.

### GitHub setup (already configured)
- **Server → GitHub:** read-only **deploy key** on the server (repo → Settings → Deploy keys).
- **Actions → server:** repo secrets `SSH_HOST`, `SSH_USER`, `SSH_PRIVATE_KEY`
  (repo → Settings → Secrets and variables → Actions).
- To skip a deploy for a docs-only commit, put `[skip ci]` in the commit message.

### Manual deploy (fallback)
```bash
ssh deploy@167.172.94.34 'bash /var/www/rcms/deploy.sh'
```

## 7. Background services

| Service | What | Manage |
|---|---|---|
| Queue worker | systemd `rcms-queue` (runs `artisan queue:work`) | `sudo systemctl status/restart rcms-queue` |
| Scheduler | deploy-user cron → `artisan schedule:run` every minute | `sudo -u deploy crontab -l` |

## 8. Common operations

```bash
# Tail application logs
ssh deploy@167.172.94.34 'tail -f /var/www/rcms/storage/logs/laravel.log'

# Re-run the deploy manually
ssh deploy@167.172.94.34 'bash /var/www/rcms/deploy.sh'

# Artisan on the server (run as deploy)
ssh deploy@167.172.94.34 'cd /var/www/rcms && php8.4 artisan <command>'

# Restart services (root)
ssh root@167.172.94.34 'systemctl restart php8.4-fpm nginx rcms-queue'

# Renew TLS manually (normally automatic)
ssh root@167.172.94.34 'certbot renew --dry-run'

# MySQL shell (root, socket auth)
ssh root@167.172.94.34 'mysql rcms'
```

## 9. Troubleshooting

- **Site stuck in maintenance (503):** a deploy failed mid-run.
  `ssh deploy@167.172.94.34 'cd /var/www/rcms && php8.4 artisan up'`, then check the
  Actions log and `storage/logs/laravel.log`.
- **500 after deploy:** usually a stale cache or `.env` change.
  `php8.4 artisan config:clear && php8.4 artisan config:cache`.
- **Assets missing/old:** ensure `npm run build` succeeded in the Actions log.
- **Permission denied writing storage:** re-apply ownership
  `chown -R deploy:www-data /var/www/rcms/storage` and `chmod -R 2775` on it.
- **PDF merge fails:** confirm `gs --version` works and `php8.4 -m | grep gd`.

## 10. Security notes

- Change the seeded admin password on first login.
- The read-only GitHub deploy key means a compromised server cannot push to the repo.
- `APP_DEBUG=false` in production — never enable debug on the live site.
- Firewall exposes only SSH/80/443; MySQL binds to localhost only.
