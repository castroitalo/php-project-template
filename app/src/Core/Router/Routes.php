<?php

declare(strict_types=1);

namespace App\Core\Router;

use App\Core\Middlewares\HomepageMiddleware;
use App\Modules\Error\Controllers\ErrorController;
use App\Modules\Homepage\Controllers\HomepageController;

/**
 * Define every application's routes
 *
 * @package App\Core\Router
 */
final class Routes
{
    /**
     * App's router
     *
     * @var null|Router
     */
    private ?Router $router = null;

    /**
     * Initialize routes components
     *
     * @param Router $router Router object
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Define error routes
     *
     * @return void
     */
    private function defineErrorRoutes(): void
    {
        $this->router->get($_ENV['ROUTE_ERROR_PAGE_NOT_FOUND'], [ErrorController::class, 'pageNotFound']);
        $this->router->get($_ENV['ROUTE_ERROR_INTERNAL_SERVER_ERROR'], [ErrorController::class, 'internalServerError']);
    }

    /**
     * Define homepage routes
     *
     * @return void
     */
    private function defineHomepageRoutes(): void
    {
        $this->router->get($_ENV['ROUTE_HOMEPAGE'], [HomepageController::class, 'homepage'], [HomepageMiddleware::class, 'homepageMiddleware']);
        $this->router->get($_ENV['ROUTE_HOMEPAGE_LIST_USERS'], [HomepageController::class, 'usersList']);
        $this->router->get($_ENV['ROUTE_HOMEPAGE_GET_USERS'], [HomepageController::class, 'usersGet']);
    }

    /**
     * Define every application's routes
     *
     * @return void
     */
    public function defineApplicationRoutes(): void
    {
        $this->defineErrorRoutes();                                             // Define error routes
        $this->defineHomepageRoutes();                                          // Define homepage routes
    }
}
