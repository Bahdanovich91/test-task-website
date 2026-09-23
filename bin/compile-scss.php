<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

$root = dirname(__DIR__);

$scssFile = $root . '/scss/style.scss';
$cssFile = $root . '/public/css/style.css';

if (!file_exists($scssFile)) {
    fwrite(STDERR, "SCSS source not found: {$scssFile}\n");
    exit(1);
}

$cssDirectory = dirname($cssFile);

if (!is_dir($cssDirectory)) {
    mkdir($cssDirectory, 0755, true);
}

try {
    $compiler = new Compiler();

    $compiler->setImportPaths([$root . '/scss']);
    $compiler->setOutputStyle(OutputStyle::COMPRESSED);

    $scss = file_get_contents($scssFile);

    if ($scss === false) {
        throw new RuntimeException('Cannot read SCSS source.');
    }

    $result = $compiler->compileString($scss);

    if (file_put_contents($cssFile, $result->getCss()) === false) {
        throw new RuntimeException('Cannot write CSS file.');
    }

    echo "CSS compiled successfully.\n";
} catch (\Throwable $e) {
    fwrite(
        STDERR,
        "SCSS compilation failed: {$e->getMessage()}\n"
    );

    exit(1);
}
