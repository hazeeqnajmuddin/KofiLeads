# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

RCMS (Rahmah Consulting Management System) is a Laravel 12 app for a loan/financing consultancy. It has two halves:

- **Public landing page** (`/`) — marketing site with a lead-capture form, served by `resources/views/landing.blade.php` under `layouts/main.blade.php`.
- **Admin panel** (`/admin/*`) — dashboard for managing leads through a sales pipeline, served under `layouts/admin.blade.php`.

Admin-facing copy and UI labels are in Bahasa Malaysia; treat this as intentional, not a bug.

## Commands

```bash
composer dev          # runs php artisan serve + queue:listen + vite dev concurrently (primary way to run locally)
npm run dev            # vite dev server only
npm run build           # production asset build

php artisan migrate     # run migrations (DB: mysql, database `rcms`, see .env)
php artisan test         # run test suite (alias: composer test)
php artisan test --filter=TestName   # run a single test
vendor/bin/pint          # format PHP code (Laravel Pint)
```

Tests use Pest (`pestphp/pest`) and run against an in-memory SQLite DB (see `phpunit.xml`), not the mysql `rcms` DB used in local dev.

## Architecture

**Domain model is not yet implemented in code.** [ERD.md](ERD.md) is the source of truth for the intended schema and is ahead of the actual migrations/models — only the `users` table exists so far. When adding features related to leads/pipeline, consult ERD.md for the planned tables and enum values before inventing new ones:

- `leads` — one row per submitted application, driven through a `pipeline_status` enum (`new_lead` → `dokumen_belum_lengkap`/`dokumen_lengkap` → `dalam_semakan` → `layak`/`tidak_layak` → `submit_bank` → `approved`/`rejected` → `disbursed`/`closed`, plus `follow_up`).
- `lead_masalah` — many-to-one "masalah" (issues/flags) per lead, e.g. `ccris`, `ctos`, `akpk`.
- `dokumen` — uploaded documents per lead (slip gaji, laporan CTOS, penyata EPF); files are intended to live under `storage/app/private/dokumen/{lead_id}/`, not publicly accessible.
- `pipeline_log` — audit trail row per pipeline status change.
- `settings` — key/value store for editable site content (WhatsApp number, hero copy, contact info).

**Controllers**: `AdminDashboardController` (`app/Http/Controllers/AdminDashboardController.php`) currently backs all admin routes (`dashboard`, `permohonan`, `laporan`, `landing`, `showLogin`) with hardcoded/dummy data — none of it reads from a database yet. This is scaffolding to be replaced once the `Lead` model and related tables exist.

**Auth**: The admin login view (`resources/views/admin/login.blade.php`) exists but is intentionally *not wired up* — a prior commit ("Add admin login UI and auth wiring") was reverted ("Revert auth wiring, keep login UI only"). There is currently no auth guard on `/admin/*` routes. Don't assume login enforcement exists; check `routes/web.php` before relying on it.

**Frontend**: Tailwind CSS v4 (via `@tailwindcss/vite`) + Vite, no JS framework — `resources/js/app.js` is just a bootstrap import. Two independent Blade layouts:
- `layouts/main.blade.php` — public site, includes `partials/header.blade.php` and `partials/footer.blade.php`.
- `layouts/admin.blade.php` — admin panel, self-contained top nav (routes: `admin.dashboard`, `admin.permohonan`, `admin.laporan`, `admin.landing`).

**MCP**: `laravel-boost` MCP server is configured (`.mcp.json`, `boost.json`) — prefer its tools (schema/docs/query lookups) over guessing at Laravel APIs when available.
