<?php

declare(strict_types=1);

namespace App\Core\Middlewares;

/**
 * Homepage routes middleware
 *
 * @package App\Core\Middlewares
 * @final
 */
final class HomepageMiddleware
{
    /**
     * Check homepage middleware
     *
     * @return void
     */
    public function homepageMiddleware(): void
    {
        echo 'Homepage middleware executed. <br>';
    }
}
