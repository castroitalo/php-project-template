<?php

declare(strict_types=1);

namespace App\Core\Migrations;

use App\Core\Bases\BaseMigration;
use App\Core\Database\Handler;
use PDO;
use PDOException;

/**
 * Migration for users table creation
 *
 * @package App\Core\Migrations
 */
final class _2024082700001_CreateUsersTable extends BaseMigration
{
    /**
     * Create users database table
     *
     * @return true|string
     */
    private function createsUsersTable(): true|string
    {
        try {
            $sql  = <<<USERS_TABLE_CREATION_CODE
                CREATE TABLE IF NOT EXISTS app.users (
                    user_id INT AUTO_INCREMENT PRIMARY KEY,
                    user_name VARCHAR(255),
                    user_surname VARCHAR(255),
                    user_phone_number VARCHAR(255)
                );
            USERS_TABLE_CREATION_CODE;
            $stmt = $this->databaseConnection->prepare($sql);

            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Insert a mock user data
     *
     * @return true|string
     */
    private function insertMockUsersData(): true|string
    {
        try {
            $handler = new Handler(
                $_ENV['DATABASE_DEV_NAME'],
                $_ENV['DATABASE_DEV_HOST'],
                $_ENV['DATABASE_DEV_PORT'],
                $_ENV['DATABASE_DEV_USERNAME'],
                $_ENV['DATABASE_DEV_PASSWORD'],
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_CASE               => PDO::CASE_NATURAL
                ]
            );
            $handler->insert('users', ['user_name', 'user_surname', 'user_phone_number'], ['Jhon', 'Doe', '9999999999999']);
            $handler->insert('users', ['user_name', 'user_surname', 'user_phone_number'], ['Jane', 'Doe', '9999999999999']);
            $handler->insert('users', ['user_name', 'user_surname', 'user_phone_number'], ['Jonathan', 'Doe', '9999999999999']);
            $handler->insert('users', ['user_name', 'user_surname', 'user_phone_number'], ['Joana', 'Doe', '9999999999999']);

            return true;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Execute every migration methods
     *
     * @return void
     */
    public function execute(): void
    {
        // Execute migration methods
        $this->createsUsersTable();
        $this->insertMockUsersData();
    }
}
