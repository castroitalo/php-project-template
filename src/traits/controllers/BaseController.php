<?php

declare(strict_types=1);

namespace src\traits\controllers;

use src\core\View;

/**
 *
 * @package src\traits
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 */
trait BaseController
{
    /**
     *
     * @var View
     */
    private View $view;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->view = new View();
    }
}
