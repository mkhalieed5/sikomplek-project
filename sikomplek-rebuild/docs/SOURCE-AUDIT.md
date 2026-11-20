# SI-KOMPLEK source audit and rebuild decisions

## Scope checked

The supplied source archive was inspected across `routes/`, `app/Http/Controllers/`, `app/Models/`, `app/Traits/`, `database/migrations/`, `database/seeders/`, `tests/`, `resources/views/`, `resources/css/`, `resources/js/`, `composer.json`, `package.json`, and Laravel configuration.

## Existing web pages and routes

- Landing page: `/` -> `welcome`.
- Authentication: `/login`, `/register`, `/register-rt`, and the authenticated `/register-rt/success` flow.
- Dashboard: `/home`; `/dashboard` is retained as a legacy view route.
- Family cards: `/kartu-keluarga` and create/edit/update/delete endpoints.
- Residents: `/warga` and create/edit/update/delete endpoints.
- Fee categories: `/iuran` and `/kategori-iuran` endpoints.
- Fee payments: `/pembayaran-iuran` and create/edit/update/delete endpoints.
- API: Sanctum-protected `/api/me`, logout, and API resources for family cards, residents, fee categories, and payments; public API login/register/register-rt endpoints.

## Existing role-to-dashboard behavior (preserved)

The active `/home` route selects `home.super-admin` for `super_admin`, `home.admin` for `tenant_admin`, and `home.warga` for every other role. Therefore `bendahara` currently renders `home.warga`. `DashboardController` contains a separate, more detailed dashboard data calculation but is not connected to the active `/home` route. Per the requested option C, this rebuild does not invent a new bendahara dashboard or silently switch the active route to `DashboardController`.

## Views and visual assets retained

All source Blade views and the source CSS/JS files are carried forward unchanged, including the landing page, authentication pages, three active role dashboards, generic CRUD index/form, and legacy module views. This keeps the existing design implementation as the reference instead of substituting a dashboard template. Responsive behavior is retained as authored in the original Blade/CSS/JS; pixel-perfect comparison still requires browser screenshots from the source and rebuilt app.

## Data model and migrations

The source migrations define tenants, users, family cards, residents, fee categories, fee payments, submitted contributions (`iurans`), letters (`surats`), announcements (`pengumumans`), Sanctum personal access tokens, cache, and jobs. Users may have a nullable tenant; family cards have tenant ownership and an optional `owner_user_id`; residents belong to a family card and tenant; fee payments reference a family card and fee category.

SQLite compatibility observations:

- Laravel 12's SQLite grammar maps `year` to an integer column.
- Laravel `enum` definitions are represented by SQLite-compatible string columns by the framework grammar.
- SQLite schema alterations such as `change()` are handled by Laravel's SQLite table-rebuild grammar; these still require execution against a real `pdo_sqlite` runtime to verify.
- The `after()` column placement modifier does not control physical column order in SQLite; it does not remove the foreign key or column itself.
- The tenant `code` migration is guarded because the initial tenants migration already defines `code`.

## Issues corrected in the rebuild copy

1. The original `DatabaseSeeder` inserted a hard-coded Super Admin with a known password and referenced `Hash` without importing it. The rebuild seeder is intentionally empty; no default or dummy credentials are created.
2. Three legacy model filenames declared a different class name (`KartuKeluargaModel.php`, `KategoriIuranModel.php`, and `PembayaranIuranModel` declared the non-suffixed classes). They are now compatibility subclasses with PSR-4-correct class names; the canonical models remain unchanged.
3. The SQLite environment template now explicitly uses SQLite, file sessions, file cache, and synchronous queues.
4. Database configuration exposes only SQLite as an application connection, preventing accidental configuration to MySQL or another server database.
5. Composer setup no longer automatically runs migrations with `--force`; migration is an explicit operator step after checking the target SQLite file.
6. A regression test records the selected option C dashboard behavior for bendahara.
7. Tenant model relationships were added for the foreign-key relationships already present in the schema; no new tables or schema changes were introduced.

## Incomplete source functionality (not invented)

- There are models and migrations for `iurans`, `surats`, and `pengumumans`, but no corresponding first-class CRUD routes/pages in the active web route file.
- The standalone `DashboardController` is not wired to the active dashboard route.
- No explicit tenant administration CRUD module is exposed in the active web routes.
- No dedicated bendahara dashboard exists in the source route/view combination.

These areas remain as source-level gaps rather than being represented as already-working features.

## Verification status

- PHP syntax lint: all 71 PHP files under app/routes/database/tests/bootstrap/config passed `php -l` in the rebuild copy.
- Automated PHPUnit tests: not executed in this build environment. The available PHP runtime does not have `pdo_sqlite` (nor `mbstring` and `dom`), so Laravel cannot run its SQLite migrations or database tests here. The project includes PHPUnit configuration for SQLite in-memory, and the new bendahara routing regression test, but passing test status must wait for execution on the target PHP installation.
- Migration execution, browser rendering, CRUD flows, and screenshot-level visual comparison remain unverified until the project is installed on a machine with the required PHP extensions and Node dependencies.
