# Development Commands

This document centralizes the day-to-day commands for this project.

## Quick Start (Main Commands)

```bash
# Start containers
docker compose up -d

# Start with rebuild
docker compose up -d --build

# Stop containers
docker compose stop

# Stop and remove containers/network (keep DB volume)
docker compose down

# Check status
docker compose ps

# Follow logs
docker compose logs -f

# Run CodeIgniter command
docker compose exec app php spark

# Start frontend dev server
yarn dev
```

## 1. Prerequisites

- Docker Desktop
- Docker Compose (v2, `docker compose`)
- Node.js + Yarn

## 2. First Run

Install frontend dependencies:

```bash
yarn install
```

Start all containers (web, app, and database):

```bash
docker compose up -d --build
```

Application URLs:

- `http://localhost:8080/`
- `http://vitorrefrigeracao.local:8080/` (if configured in `/etc/hosts`)

## 3. Daily Docker Commands

Start environment:

```bash
docker compose up -d
```

Stop environment (keeps database data):

```bash
docker compose stop
```

Stop and remove containers/network (keeps volume data):

```bash
docker compose down
```

Rebuild after Dockerfile/server config changes:

```bash
docker compose up -d --build
```

Check container status:

```bash
docker compose ps
```

View logs:

```bash
docker compose logs -f
docker compose logs -f web
docker compose logs -f app
docker compose logs -f db
```

## 4. Database (MySQL in Container)

Service: `db`  
External port: `3307`  
Internal port: `3306`

Open MySQL shell:

```bash
docker compose exec db mysql -uroot -p
```

Run direct SQL command:

```bash
docker compose exec db mysql -uroot -pmyJBM1985 -e "SHOW DATABASES;"
```

### Data Persistence

Database uses named volume:

- `vitorrefrigeracaocombr_db_data`

Do not run `docker compose down -v` if you want to keep database data.

## 5. CodeIgniter Commands (Spark)

Run `spark` commands inside the PHP container:

```bash
docker compose exec app php spark
```

Examples:

```bash
docker compose exec app php spark migrate
docker compose exec app php spark db:seed SeederName
docker compose exec app php spark cache:clear
```

Open shell in PHP container:

```bash
docker compose exec app bash
```

## 6. Frontend (Vite)

Start dev server:

```bash
yarn dev
```

Build for production:

```bash
yarn build
```

Preview production build:

```bash
yarn preview
```

Lint:

```bash
yarn lint
yarn lint:fix
```

Format:

```bash
yarn format
yarn format:check
```

## 7. Tests

Run PHP tests:

```bash
docker compose exec app vendor/bin/phpunit
```

Or via Composer:

```bash
docker compose exec app composer test
```

## 8. Composer (PHP)

Install PHP dependencies:

```bash
docker compose exec app composer install
```

Update PHP dependencies:

```bash
docker compose exec app composer update
```

## 9. Quick Troubleshooting

Container name conflict:

```bash
docker rm -f ci4-web ci4-app ci4-db
docker compose up -d --build
```

Missing PHP extension error:

```bash
docker compose up -d --build app
```

Recreate Apache only:

```bash
docker compose up -d --build --force-recreate web
```

Light Docker cleanup (without explicitly removing named volumes):

```bash
docker image prune -f
docker builder prune -f
docker container prune -f
```
