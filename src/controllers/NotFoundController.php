<?php 

declare(strict_types=1);

namespace src\controllers;

/**
 * Class NotFoundController
 * 
 * @package src\controllers
 */
final class NotFoundController
{
    /**
     * Renders not found page
     *
     * @return void
     */
    public function notFoundPage(): void 
    {
        echo "<p>404 - Page Not Found</p>";
    }
}
