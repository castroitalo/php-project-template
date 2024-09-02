<?php

declare(strict_types=1);

namespace App\Modules\Homepage\Services;

use App\Core\Bases\BaseService;
use App\Modules\Homepage\Models\HomepageUsersModel;
use Exception;

/**
 * Contains every module controller operation
 *
 * @package App\Modules\Homepage\Services
 */
final class HomepageUsersService extends BaseService
{
    /**
     * Service model for database operations
     *
     * @var null|HomepageUsersModel
     */
    private ?HomepageUsersModel $model = null;

    /**
     * Initialize service components
     *
     * @param HomepageUsersModel $model
     * @return void
     */
    public function __construct(HomepageUsersModel $model)
    {
        $this->model = $model;
    }

    /**
     * Get a list of all registeres users
     *
     * @return array
     */
    public function listAllRegisteredUsers(): array
    {
        try {
            $users = $this->model->getUsers();

            return $this->mountResponseArray($_ENV['CONF_RESPONSE_HTTP_OK'], 'success', $users);
        } catch (Exception) {
            return $this->mountResponseArray($_ENV['CONF_RESPONSE_HTTP_INTERNAL_SERVER_ERROR'], 'failed_listing_users');
        }
    }

    /**
     * Get user
     *
     * @param array $requestData
     * @return array
     */
    public function getRegisteredUserById(array $requestData): array
    {
        try {
            // Validate mandatory request data
            if (
                !$this->validateMandatoryRequestData(
                    $requestData,
                    [
                        'user-id' => 'string'
                    ]
                )
            ) {
                return $this->mountResponseArray($_ENV['CONF_RESPONSE_HTTP_BAD_REQUEST'], 'bad_parameters');
            }

            // Get user data
            $userData = $this->model->getUserById((int)$requestData['user-id']);

            return $this->mountResponseArray($_ENV['CONF_RESPONSE_HTTP_OK'], 'success', (array)$userData);
        } catch (Exception) {
            return $this->mountResponseArray($_ENV['CONF_RESPONSE_HTTP_INTERNAL_SERVER_ERROR'], 'failed_getting_users');
        }
    }
}
