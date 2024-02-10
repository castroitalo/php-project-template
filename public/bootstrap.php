<?php

declare(strict_types=1);

// Imports composer autoload
require_once __DIR__ . "/../vendor/autoload.php";

// Load .env file
$phpdotenv = Dotenv\Dotenv::createImmutable(CONF_GENERAL_ROOT_DIR);

$phpdotenv->load();
