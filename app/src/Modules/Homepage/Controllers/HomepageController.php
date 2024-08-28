<?php

declare(strict_types=1);

namespace App\Modules\Homepage\Controllers;

use App\Core\Bases\BaseController;
use App\Core\Http\Response;
use App\Modules\Homepage\Models\HomepageUsersModel;
use App\Modules\Homepage\Services\HomepageUsersService;

/**
 * Controls every homepage requests
 *
 * @package App\Core\Modules\Homepage\Controllers
 * @final
 */
final class HomepageController extends BaseController
{
    /**
     * Controller's service
     *
     * @var null|HomepageUsersService
     */
    private ?HomepageUsersService $serivce = null;

    /**
     * Initialize controller components
     *
     * @return void
     */
    public function __construct()
    {
        $model         = new HomepageUsersModel();
        $this->serivce = new HomepageUsersService($model);
    }

    /**
     * /
     *
     * @return void
     */
    public function homepage(): void
    {
        echo '<h1>Homepage</h1>';
    }

    /**
     * /users
     *
     * @return void
     */
    public function users(): void
    {
        $response = $this->serivce->listAllRegisteredUsers();

        Response::sendJson($response['response_body'], (int)$response['response_http_code']);
    }
}
