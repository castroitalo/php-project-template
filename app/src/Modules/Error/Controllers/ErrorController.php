<?php

declare(strict_types=1);

namespace App\Modules\Error\Controllers;

use App\Core\Bases\BaseController;

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
        $this->httpResponse->setResponseStatusCode(404);
        echo 'Page Not Found <br>';
    }

    /**
     * /internal-server-error
     *
     * @return void
     */
    public function internalServerError(): void
    {
        $this->httpResponse->setResponseStatusCode(500);
        echo 'Internal Server Error <br>';
    }
}
