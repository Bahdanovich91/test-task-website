<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/Core/Database/Database.php';
require_once __DIR__ . '/../app/Core/Models/Model.php';
require_once __DIR__ . '/../app/Models/Category.php';
require_once __DIR__ . '/../app/Models/Post.php';

use App\Models\Category;
use App\Models\Post;

$categories = Category::all();
$posts = Post::all();

var_dump($categories);
var_dump($posts);