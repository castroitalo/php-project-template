<?php

declare(strict_types=1);

namespace App\Core\Bases;

use App\Core\Database\Handler;
use App\Core\Http\Request;
use PDO;

/**
 * Contains every model comon operation
 *
 * @package App\Core\Bases
 */
class BaseModel
{
    /**
     * Database handler for database operations
     *
     * @var null|Handler
     */
    protected ?Handler $databaseHandler = null;

    /**
     * Database connection attributes
     *
     * @var array
     */
    protected array $databaseConnectionAttributes = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE               => PDO::CASE_NATURAL
    ];

    /**
     * Initialize model components
     *
     * @return void
     */
    public function __construct()
    {
        $isLocalhost = (new Request())->isLocalhost();

        if ($isLocalhost) {
            $this->databaseHandler = new Handler(
                $_ENV['DATABASE_DEV_NAME'],
                $_ENV['DATABASE_DEV_HOST'],
                $_ENV['DATABASE_DEV_PORT'],
                $_ENV['DATABASE_DEV_USERNAME'],
                $_ENV['DATABASE_DEV_PASSWORD'],
                $this->databaseConnectionAttributes
            );
        } else {
            $this->databaseHandler = new Handler(
                $_ENV['DATABASE_PRODUCTION_NAME'],
                $_ENV['DATABASE_PRODUCTION_HOST'],
                $_ENV['DATABASE_PRODUCTION_PORT'],
                $_ENV['DATABASE_PRODUCTION_USERNAME'],
                $_ENV['DATABASE_PRODUCTION_PASSWORD'],
                $this->databaseConnectionAttributes
            );
        }
    }
}
