1) cp .env.example .env
2) docker compose up -d --build
3) docker compose exec php php database/seed.php