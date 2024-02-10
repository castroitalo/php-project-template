<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\BaseController;

/**
 * Controller the website's homepage (/)
 * 
 * @package src\controller
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class HomeController
{
    // Use base controller trait
    use BaseController;

    /**
     * Render homepage
     *
     * @param array|null $parameters
     * @return void
     */
    public function homepage(?array $parameters = null): void
    {
        $this->view->renderView("base.view");
    }
}
