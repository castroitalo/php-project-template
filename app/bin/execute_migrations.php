<?php

declare(strict_types=1);

use App\Core\Migrations\_2024082700001_CreateUsersTable;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$phpdotenv = Dotenv::createImmutable(dirname(__DIR__, 1));

$phpdotenv->load();

// Define migrations
$_2024082700001_CreateUserTableMigration = new _2024082700001_CreateUsersTable();

// Execute migrations
$_2024082700001_CreateUserTableMigration->execute();
