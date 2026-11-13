# Tasker — Tasks for Today Management System (Laravel 13)

**Tasker** is the Laravel 13 Eloquent ORM implementation of the **Tasks for Today Management System** for **IT0049 (Technical Summative Assessment 3 — TSA3)** by **Charles Lawrence Aniciete**. It reproduces the schema, sample dataset, and page routes of [tsa1tasker](https://github.com/aniciete/tsa1tasker) using Laravel migrations, seeders, backed enums, and Eloquent local query scopes.

- **Live Deployment**: [https://tsa3.freedev.app](https://tsa3.freedev.app)

---

## Features & Routes

| Route | Controller Action | Purpose |
| :--- | :--- | :--- |
| `/` | `WelcomeController@index` | Queries `Task::forToday()` (`Asia/Manila`) to display today's scheduled tasks and status counts. |
| `/tasks` | `TaskController@index` | Queries `Task::orderedByDate()` to list all seeded tasks chronologically by `task_date`. |
| `/profile` | `ProfileController@index` | Queries `User::query()->orderBy('id')->first()` to display the registered user record. |
| `/about` | `AboutController@index` | Static page identifying **Charles Lawrence Aniciete** and the Eloquent architecture. |

---

## Architecture & Database Schema

### Migrations
- **`users`** (`database/migrations/0001_01_01_000000_create_users_table.php`):
  - `id` (primary key), `username` (`VARCHAR(50)`, unique), `full_name` (`VARCHAR(100)`), `email` (`VARCHAR(100)`), and `timestamps()`.
- **`tasks`** (`database/migrations/2026_11_13_000001_create_tasks_table.php`):
  - `id` (primary key), `title` (`VARCHAR(150)`), `status` (`VARCHAR(20)`, default `'pending'`), `task_date` (`DATE`), and `timestamps()`.
- A MySQL SQL export (`database/schema_export.sql`) with `SET time_zone = '+08:00'` is included for phpMyAdmin or shared-hosting provisioning.

### Eloquent Models & Query Scopes
- `App\Models\Task`: casts `status` to `App\Enums\TaskStatus` (`pending`, `completed`) and `task_date` to `date`, and defines Laravel 13 `#[Scope]` local scopes:
  - `forToday(Builder $query): void`
  - `orderedByDate(Builder $query): void`
- `App\Models\User`: exposes `#[Fillable(['username', 'full_name', 'email'])]`.

### Seeders
- `Database\Seeders\UserSeeder`: seeds 1 canonical user (`charles`, `Charles Lawrence Aniciete`, `charles@example.com`).
- `Database\Seeders\TaskSeeder`: seeds 10 sample tasks spanning 4 distinct dates (yesterday, today, tomorrow, and +2 days).

---

## Local Setup & Running

### Prerequisites
- PHP `^8.3` with PDO SQLite/MySQL extensions
- Composer `^2.x`

### Steps

```bash
git clone https://github.com/aniciete/tsa3tasker.git
cd tsa3tasker
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Then open [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## Verification & Quality Checks

```bash
# Run PHPUnit feature & model tests
php artisan test

# Verify Laravel Pint formatting rules
./vendor/bin/pint --test
```

---

## Shared Hosting Deployment (InfinityFree)

- **Target Domain**: [https://tsa3.freedev.app](https://tsa3.freedev.app)
- **Database Host**: `sql105.infinityfree.com` (`if0_43431425_tsa3`)

1. Copy `env.production.example` to `env.production`, set `APP_KEY` (`php artisan key:generate --show`), and set your InfinityFree MySQL password (`DB_PASSWORD`).
2. Run `./build-infinityfree-zip.sh` to assemble `tsa3tasker-infinityfree.zip` with `vendor/` (`--no-dev`), `.htaccess`, root `index.php`, mirrored `assets/`, pre-migrated SQLite fallback, and `database/schema_export.sql`.
3. Deploy via FTP (`extract.php` automatically unpacks the archive, reads credentials from `.env` to import `database/schema_export.sql`, and removes itself):
   ```bash
   FTP_PASS="<your-vpanel-password>" ./deploy-infinityfree.sh
   ```
