<?php

declare(strict_types=1);

namespace App\Modules\Error\Controllers;

use App\Core\Bases\BaseController;
use App\Core\Http\Response;

/**
 * Controls every error requests
 *
 * @package App\Core\Modules\Error\Controllers
 * @final
 */
final class ErrorController extends BaseController
{
    /**
     * /page-not-found
     *
     * @return void
     */
    public function pageNotFound(): void
    {
        Response::setResponseStatusCode(404);
        echo 'Page Not Found <br>';
    }

    /**
     * /internal-server-error
     *
     * @return void
     */
    public function internalServerError(): void
    {
        Response::setResponseStatusCode(500);
        echo 'Internal Server Error <br>';
    }
}
