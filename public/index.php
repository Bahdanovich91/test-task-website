<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/Core/Database/Database.php';

use App\Core\Database\Database;

$connection = Database::getConnection();
var_dump($connection);
