<?php

declare(strict_types=1);

namespace App\Modules\Homepage\Models;

use App\Core\Bases\BaseModel;
use App\Core\Exceptions\Database\HandlerException;
use CastroItalo\EchoQuery\Builder;
use CastroItalo\EchoQuery\Exceptions\BuilderException;

/**
 * Contains every Homepage users database operations
 *
 * @package App\Modules\Homepage\Models
 */
class HomepageUsersModel extends BaseModel
{
    /**
     * Get all users from database
     *
     * @return array
     * @throws BuilderException
     * @throws HandlerException
     */
    public function getUsers(): array
    {
        $query  = (new Builder())->select(
            ['*']
        )
            ->from($_ENV['DATABASE_DEV_NAME'] . '.' . $_ENV['DATABASE_TABLE_USERS'])
            ->getQuery();
        $result = $this->databaseHandler->get($query);

        return $result;
    }

    /**
     * Get user by its ID
     *
     * @param int $userId User id to get user
     * @return void
     * @throws BuilderException
     * @throws HandlerException
     */
    public function getUserById(int $userId): object
    {
        $query  = (new Builder())->select(
            ['*']
        )
            ->from($_ENV['DATABASE_DEV_NAME'] . '.' . $_ENV['DATABASE_TABLE_USERS'])
            ->where('user_id')
            ->equalsTo(':user_id')
            ->getQuery();
        $result = $this->databaseHandler->get($query, [$userId]);

        return $result[0];
    }
}
