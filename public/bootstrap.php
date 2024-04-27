<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

// Load .env file to $_ENV super global array
$phpdotenv = Dotenv::createImmutable(CONF_GENERAL_ROOT_DIRECTORY);

$phpdotenv->load();
