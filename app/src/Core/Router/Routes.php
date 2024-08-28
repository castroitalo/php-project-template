<?php

declare(strict_types=1);

namespace App\Core\Router;

use App\Core\Middlewares\HomepageMiddleware;
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
     * Define every homepage routes
     *
     * @return void
     */
    private function defineHomepageRoutes(): void
    {
        $this->router->get($_ENV['ROUTE_HOMEPAGE'], [HomepageController::class, 'homepage'], [HomepageMiddleware::class, 'homepageMiddleware']);
        $this->router->get($_ENV['ROUTE_HOMEPAGE_USERS'], [HomepageController::class, 'users']);
    }

    /**
     * Define every application's routes
     *
     * @return void
     */
    public function defineApplicationRoutes(): void
    {
        $this->defineHomepageRoutes();                                          // Define homepage routes
    }
}
