## Run

```bash
cp .env.example .env
# Заполнить .env своими значениями
docker compose up -d --build
docker compose exec php composer install
docker compose exec php php database/seed.php
```

Application: http://localhost:8080

## Checks

PHPStan:

```bash
docker compose exec php vendor/bin/phpstan analyse
```

PHP-CS-Fixer check:

```bash
docker compose exec php vendor/bin/php-cs-fixer fix --dry-run --diff
```

PHP-CS-Fixer fix:

```bash
docker compose exec php vendor/bin/php-cs-fixer fix
```

Compile SCSS:

```bash
docker compose exec php php bin/compile-scss.php
```
