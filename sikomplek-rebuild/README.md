# SI-KOMPLEK (rebuild)

This project is a source-faithful rebuild of the supplied SI-KOMPLEK Laravel application. The original Blade pages, CSS, JavaScript, routes, controllers, models, migrations, and existing tests are retained as the implementation baseline. SQLite is the only configured application database.

## Requirements

- PHP 8.2 or newer
- Composer 2
- Node.js and npm
- PHP extensions required by Laravel, including `pdo_sqlite`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, and `fileinfo`

## Safe setup on Windows (PowerShell)

Run these commands from the project folder:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database/database.sqlite -Force
npm install
npm run build
```

Open `.env` and keep these settings:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Before the first migration, confirm that `database/database.sqlite` is the new, empty database created for this project. Then run:

```powershell
php artisan migrate
```

Do not use `migrate:fresh` on a database that contains data. No default admin, resident, tenant, or dummy account is seeded. Create accounts through the application's registration flow or a separately approved administrative process.

## Run locally

In one terminal:

```powershell
php artisan serve
```

In another terminal, only when working on frontend assets:

```powershell
npm run dev
```

Open `http://127.0.0.1:8000`.

## Tests

The PHPUnit configuration uses SQLite in-memory (`DB_DATABASE=:memory:`), array cache/session, and synchronous queues. Tests do not use the development database:

```powershell
php artisan test
```

## Important notes

- The bendahara dashboard behavior is intentionally unchanged from the source: `/home` maps `super_admin` to `home.super-admin`, `tenant_admin` to `home.admin`, and all other roles (including `bendahara`) to `home.warga`. No new bendahara dashboard is invented.
- `database/seeders/DatabaseSeeder.php` does not create a hard-coded account.
- Never copy secrets from the original `.env` into this project.
