# CarBook

CarBook is an internal vehicle booking application. Administrators request company vehicles and route each request through two approvers.

## Features

- Browse vehicles and submit bookings with a date range and reason.
- Assign two approvers to each booking.
- Approve or reject requests at either approval stage.
- Review booking history and vehicle service dates.
- Record booking activity in the application log.

## Stack

- Laravel 11 and PHP 8.2
- PostgreSQL 16
- Blade templates and React/Inertia pages, built with Vite
- Docker Compose

## Local setup

You need Docker Engine and the Docker Compose plugin. The development Compose file adds a local PostgreSQL database; the base Compose file runs only the web application and is suitable for connecting to an existing database.

1. Create your local environment file:

   ```bash
   cp .env.example .env
   ```

   In PowerShell, use `Copy-Item .env.example .env`.

2. Build and start the app with its local database:

   ```bash
   docker compose -f compose.yaml -f compose.dev.yaml build app
   docker compose -f compose.yaml -f compose.dev.yaml run --rm --no-deps app php artisan key:generate
   docker compose -f compose.yaml -f compose.dev.yaml up -d
   ```

3. Create and seed the database:

   ```bash
   docker compose -f compose.yaml -f compose.dev.yaml exec app php artisan migrate --seed
   ```

4. Open [http://localhost:8080](http://localhost:8080).

Open [http://localhost:8080/guide](http://localhost:8080/guide) for the in-app walkthrough. The guide is also linked from the sign-in page and navigation.

The app and local database have memory and CPU limits defined in `.env`. The database data is stored in a named Docker volume. Stop the services with:

```bash
docker compose -f compose.yaml -f compose.dev.yaml down
```

### Local demo accounts

The database seeder creates the following development accounts. All three use the password `password`.

| Role | Email |
| --- | --- |
| Admin | `admin@example.com` |
| Approver | `approver@example.com` |
| Approver | `approver2@example.com` |

These accounts are for local evaluation only. Change or remove them before using seeded data in any shared environment.

## VPS deployment notes

The base `compose.yaml` starts only CarBook and binds its port to `127.0.0.1`. On a VPS, point it at an existing PostgreSQL service and place a host-level Nginx, Caddy, or other reverse proxy in front of the configured `APP_PORT`. This lets several small sites share one reverse proxy and database server without running a separate database container for every project.

Set `APP_ENV=production`, `APP_DEBUG=false`, the public HTTPS `APP_URL`, `SESSION_SECURE_COOKIE=true`, a unique `APP_PORT`, and credentials for an existing PostgreSQL database in `.env`. Use a different `APP_PORT` for each project. Keep the database port private; the app container connects to the configured host over its Docker network. The app trusts forwarded headers from the host proxy; its port is bound to loopback so it is not exposed directly. Build the image, generate an application key into the mounted `.env`, then start the app:

```bash
docker compose build app
docker compose run --rm --no-deps app php artisan key:generate
docker compose up -d
docker compose exec app php artisan migrate --force
docker compose exec app php artisan app:create-user admin
docker compose exec app php artisan app:create-user approver
docker compose exec app php artisan config:cache
docker compose exec app php artisan view:cache
```

The account command asks for a name, email, and password; it requires at least 12 characters and does not print the password. Run it once for the administrator and once per approver. Do not run `migrate --seed` in production: the seeders contain predictable local demo accounts and are restricted to local and testing environments.

Run `config:cache` again after changing environment settings. The app container has a 384 MB memory limit and a 0.50 CPU limit by default; tune `APP_MEMORY_LIMIT` and `APP_CPU_LIMIT` to match the VPS and expected traffic. Apache is capped at six PHP workers and PHP uses a 128 MB memory limit. Raise these limits only if the workload needs them.

The container health check requests Laravel's `/up` endpoint. Application logs go to the container output and Docker rotates them at 10 MB, retaining three files. Use `docker compose logs -f app` to inspect recent logs. The application image contains PHP extensions, Composer dependencies, and prebuilt frontend assets; Node.js, npm, Composer, and build libraries stay in intermediate image stages. Rebuild the image after changing application code or dependencies because OPcache assumes immutable code inside the image.

Do not commit `.env` or production credentials. The Compose setup is a small single-host deployment pattern; it does not configure TLS, backups, monitoring, or a production database.

## Common commands

For local development, include both Compose files in each command:

```bash
# Follow app logs
docker compose -f compose.yaml -f compose.dev.yaml logs -f app

# Run migrations
docker compose -f compose.yaml -f compose.dev.yaml exec app php artisan migrate

# Rebuild after changing app code or dependencies
docker compose -f compose.yaml -f compose.dev.yaml up --build -d
```

To delete the local database and start over, run `docker compose -f compose.yaml -f compose.dev.yaml down --volumes`. This permanently removes the local database volume.

## Repository layout

```text
app/                 Controllers, models, and application services
database/            Migrations, factories, and seeders
resources/views/     Blade templates
resources/js/        React/Inertia pages and entry point
routes/              Web and console routes
docker/              PHP and Apache runtime tuning
Dockerfile           Multi-stage application image build
compose.yaml         App service for local use or VPS deployment
compose.dev.yaml     Optional local PostgreSQL service
```

## License

No license has been specified for this repository. Contact the maintainers before redistributing or reusing the code.
