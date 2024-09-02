<?php

declare(strict_types=1);

namespace App\Modules\Homepage\Controllers;

use App\Core\Bases\BaseController;
use App\Core\Http\Request;
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

        parent::__construct();
    }

    /**
     * /
     *
     * @return void
     */
    public function homepage(): void
    {
        $this->view->renderView('pages/homepage.view');
    }

    /**
     * /users/list
     *
     * @return void
     */
    public function usersList(): void
    {
        $response = $this->serivce->listAllRegisteredUsers();

        Response::sendJson($response['response_body'], (int)$response['response_http_code']);
    }

    /**
     * /users/get
     *
     * @return void
     */
    public function usersGet(): void
    {
        $requestData = Request::getQueryParameters();
        $response    = $this->serivce->getRegisteredUserById($requestData);

        Response::sendJson($response['response_body'], (int)$response['response_http_code']);
    }
}
