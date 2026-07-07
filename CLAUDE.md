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

Tests use Pest (`pestphp/pest`) and run against an in-memory SQLite DB (see `phpunit.xml`), not the mysql `rcms` DB used in local dev. Feature tests seed their own data via factories (`LeadFactory`, `DokumenFactory`) and cover the four backend slices: `LeadSubmissionTest`, `AdminLeadManagementTest`, `SettingsManagementTest`, `DashboardReportTest`.

## Architecture

The domain model **is** now implemented (as of the "Backend: lead intake, admin management, settings, reporting" commit) — migrations, Eloquent models, form requests, and controllers all exist for the tables below. [ERD.md](ERD.md) and the longer [RCMS_Architecture.md](RCMS_Architecture.md) are the design docs; both open with "nothing implemented yet" preambles that are now **stale** — trust the code. RCMS_Architecture.md is still the reference for the *phased* delivery plan (its "Phase N" labels appear in code comments) and for domain decisions (the 4 canonical sectors, the WhatsApp hand-off, PDPA rules).

**Tables / models** (`app/Models/`):
- `leads` (`Lead`) — one row per submitted application. Uses `SoftDeletes` (PDPA: records are soft-deleted, never hard-erased). Driven through a `pipeline_status` enum: `new_lead` → `dokumen_belum_lengkap`/`dokumen_lengkap` → `dalam_semakan` → `layak`/`tidak_layak` → `submit_bank` → `approved`/`rejected` → `disbursed`/`closed`, plus `follow_up`.
- `lead_masalah` (`LeadMasalah`) — many issues/flags per lead (`komitmen_tinggi`, `ccris`, `ctos`, `akpk`, `saa`, `legal_action`, `lain_lain`).
- `dokumen` (`Dokumen`) — uploaded documents per lead (`slip_gaji` ×3 months, `laporan_ctos`, `penyata_epf`). Files live on the **private** `local` disk under `dokumen/{lead_id}/` and are only reachable by streaming through `DokumenController@download` — never a public URL.
- `pipeline_log` (`PipelineLog`) — audit row written on every status change.
- `settings` (`Setting`) — key/value store for editable site content. Read/write via the static `Setting::get()`/`Setting::set()` helpers, which cache each key with `rememberForever` and bust it on write — don't query the table directly.

**Canonical enums live as constants on the `Lead` model** (`Lead::PIPELINE_STATUSES`, `Lead::SEKTOR`) and **must stay in sync with the DB enum columns** in the migrations. Use them for validation/filtering rather than re-listing string literals.

**Controllers**:
- `LeadSubmissionController@store` (public, `POST /leads`) — validates via `StoreLeadRequest` and creates the lead + `lead_masalah` rows + uploaded `dokumen`, all in one `DB::transaction`. `penyata_epf` is required only when `sektor === 'swasta'`.
- `AdminDashboardController` — now backs only `dashboard` (real aggregate stats) and `showLogin`. The `permohonan`/`laporan`/`landing` actions were split out into the `App\Http\Controllers\Admin\` namespace: `LeadController` (list/filter, `updateStatus`, soft-delete `destroy`), `ReportController` (laporan aggregates), `SettingController` (Tetapan Laman edit/update), `DokumenController` (file download).
- Form requests in `app/Http/Requests/` (`StoreLeadRequest`, `UpdateLeadStatusRequest`, `UpdateSettingsRequest`) own all validation. `SettingController@update` only writes keys present in the payload (each of the 3 settings forms posts its own fields); text keys go to the DB, `FILE_KEYS` go to the **public** disk.

**Report filter quirk**: `ReportController` combines its three filters (tempoh / sektor / status) with **OR** logic — a lead is included if it matches *any* active filter; a filter left on "Semua …" is inactive. Every panel recomputes off that filtered set. This is intentional (see the docblock), not the usual AND-narrowing.

**Auth**: still **not wired up** — Phase 3 is deferred, so there is no guard on `/admin/*` and the whole admin area (including document downloads) is open. The login view (`resources/views/admin/login.blade.php`) renders but enforces nothing. Because there's no authenticated user yet, `pipeline_log.changed_by` is temporarily attributed to the first seeded user. Don't assume login enforcement exists; check `routes/web.php`.

**Seeding**: `DemoLeadsSeeder` (sample leads/docs) and `SettingsSeeder` (default site settings) run from `DatabaseSeeder` — use `php artisan migrate:fresh --seed` for a populated local DB.

**Frontend**: Tailwind CSS v4 (via `@tailwindcss/vite`) + Vite, no JS framework — `resources/js/app.js` is just a bootstrap import. Two independent Blade layouts:
- `layouts/main.blade.php` — public site, includes `partials/header.blade.php` and `partials/footer.blade.php`.
- `layouts/admin.blade.php` — admin panel, self-contained top nav (routes: `admin.dashboard`, `admin.permohonan`, `admin.laporan`, `admin.landing`).

**MCP**: `laravel-boost` MCP server is configured (`.mcp.json`, `boost.json`) — prefer its tools (schema/docs/query lookups) over guessing at Laravel APIs when available.
