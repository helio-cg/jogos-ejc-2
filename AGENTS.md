# AGENTS.md

## Stack

- PHP 8.3+, Laravel 13.8, Filament 5.0 (Admin + User panels)
- MySQL via Docker (host.docker.internal), sessions/cache/queue all use database
- DomPDF for PDF receipt generation (barryvdh/laravel-dompdf 3.1)
- Pest PHP 4.7 for testing, Vite 8 + Tailwind 4 for frontend
- Docker Compose with Laravel Sail (runtime image: `vendor/laravel/sail/runtimes/8.5`)

## Commands

```bash
# Full setup (install deps, key, migrate, build assets)
composer setup

# Dev server (runs artisan serve + queue + pail + vite concurrently)
composer dev

# Inside Docker container
docker compose exec laravel.test bash
php artisan test
php artisan migrate
npx vite build

# Linting (Laravel Pint)
./vendor/bin/pint

# Tests
./vendor/bin/pest
```

## Architecture

### Dual Filament Panels with Dual Auth Guards

- **Admin panel** (`/admin`): guard `admin`, model `App\Models\Admin`
- **User panel** (`/user`): guard `web`, model `App\Models\User` (default panel)

Both panels have independent login. Admin can impersonate users via `/admin/switch/user/{id}` and return via `/admin/switch/back`.

### User Roles (parent/sub_user)

- `parent`: main user who registers, manages sub-users and payment
- `sub_user`: child user auto-assigned `team_name` (e.g. "Time 1") and `parent_id`
- `status`: `completo` blocks further edits
- `WizardMiddleware` redirects inactive users (`active == 0`) to account activation page

### Key Models

| Model | Notes |
|---|---|
| `User` | Dual role system (parent/sub_user), belongs to Paroquia, has many Atletas |
| `Admin` | Separate table, separate guard, no paroquia association |
| `Atleta` | Belongs to User, `modalidade` is JSON array (Futsal/Volei/Queimada), auto-logs all CRUD via ActivityLog |
| `Paroquia` | Parish, has no timestamps, links Users and Atletas |
| `ActivityLog` | Audit trail for all model changes, uses `ActivityLog::log()` static method |
| `UserModalidade` | Modalidade assignments per user |

### Data Scope

All data is scoped by `paroquia_id`. Users should only see data from their own parish.

## Critical Gotchas

### TMPDIR Override (bootstrap/app.php:8)

```php
putenv('TMPDIR=' . __DIR__ . '/../storage/tmp');
```

The `storage/tmp` directory **must exist** or DomPDF and any `tempnam()` call will fail with HTTP 500. If you see "tempnam(): file created in the system's temporary directory", create it:

```bash
mkdir -p storage/tmp && chmod 775 storage/tmp
```

### Docker Permissions

`.env` must have `WWWUSER=1000` and `WWWGROUP=1000` (matching host UID/GID). Without these, `storage/logs` and other directories get "Permission denied" inside the container.

### compose.yaml References Runtime 8.3

The `compose.yaml` build context points to `vendor/laravel/sail/runtimes/8.3` but `composer.json` requires PHP `^8.3`. The Sail image build pulls PHP 8.5 from ondrej PPA. If you update Sail, update `compose.yaml` build context to match.

### PDF Generation

Route `GET /pdf/comprovante/{user}` generates payment receipts. Requires `storage/tmp` (DomPDF temp), `storage/fonts` (font cache), and logged-in admin auth.

### No CI/CD

No GitHub Actions or CI workflows exist. No linting/formatting CI. Tests use in-memory SQLite (`DB_DATABASE=testing` in phpunit.xml).

## File Conventions

- Models use PHP 8 attributes (`#[Fillable]`, `#[Hidden]`) instead of `$fillable`/`$hidden` arrays (except `Atleta` which uses traditional `$fillable`)
- Activity logging is done via `ActivityLog::log()` in model boot methods, not middleware
- Filament resources are in `app/Filament/Resources` (admin) and `app/Filament/User/Resources` (user panel)
- Filament widgets are in `app/Filament/Widgets` (admin) and `app/Filament/User/Widgets` (user panel)
- Blade views for PDF in `resources/views/pdf/`, Filament partials in `resources/views/filament/`
