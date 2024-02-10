<?php

declare(strict_types=1);

namespace src\traits;

use src\core\View;

/**
 * Setup basic controller functionalities
 * 
 * @package src\traits
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 */
trait BaseController
{
    /**
     * @var View 
     */
    private View $view;

    /**
     * BaseController constructor
     */
    public function __construct()
    {
        $this->view = new View();
    }
}
