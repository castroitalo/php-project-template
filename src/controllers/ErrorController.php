<?php

declare(strict_types=1);

namespace src\controllers;

use Exception;
use src\core\Response;
use src\traits\controllers\BaseController;
use Throwable;

/**
 *
 * @package src\controllers
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class ErrorController
{
    use BaseController;

    /**
     *
     * @return void
     * @throws Throwable
     * @throws Exception
     */
    public function pageNotFound(): void
    {
        Response::setResponseStatusCode(404);
        $this->view->renderView('errors/404.view');
    }

    /**
     *
     * @return void
     * @throws Throwable
     * @throws Exception
     */
    public function internalServerError(): void
    {
        Response::setResponseStatusCode(500);
        $this->view->renderView('errors/500.view');
    }
}
