<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database\Database;
use Faker\Factory;

$faker = Factory::create();

$pdo = Database::getConnection();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE posts');
$pdo->exec('TRUNCATE TABLE categories');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$categoryIds = [];

$categoryStatement = $pdo->prepare(
    'INSERT INTO categories (name, description)
     VALUES (?, ?)'
);

for ($i = 0; $i < 5; $i++) {
    $categoryStatement->execute([
        $faker->unique()->word(),
        $faker->paragraph(),
    ]);

    $categoryIds[] = (int) $pdo->lastInsertId();
}

$postStatement = $pdo->prepare(
    'INSERT INTO posts (
        title,
        description,
        text,
        views_count,
        created_at
    ) VALUES (?, ?, ?, ?, ?)'
);

$categoryPostStatement = $pdo->prepare(
    'INSERT INTO post_category (post_id, category_id)
     VALUES (?, ?)'
);

for ($i = 0; $i < 30; $i++) {
    $postStatement->execute([
        $faker->sentence(6),
        $faker->sentence(12),
        $faker->paragraphs(5, true),
        $faker->numberBetween(0, 1000),
        $faker->dateTimeBetween('-6 months', 'now')->format('Y-m-d H:i:s'),
    ]);

    $postId = (int) $pdo->lastInsertId();

    $postCategories = $faker->randomElements(
        $categoryIds,
        $faker->numberBetween(1, 2)
    );

    foreach ($postCategories as $categoryId) {
        $categoryPostStatement->execute([
            $postId,
            $categoryId,
        ]);
    }
}

echo "Database seeded successfully.\n";
