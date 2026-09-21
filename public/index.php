<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Category;
use App\Models\Post;

var_dump(Post::all());
var_dump(Category::all());

