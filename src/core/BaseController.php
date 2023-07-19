<?php

namespace src\core;

use src\core\View;

/**
 * Class BaseController
 * @abstract
 * @package src\core
 */
abstract class BaseController
{

    /**
     * Current controller view
     * @var View
     */
    protected View $view;

    /**
     * BaseController constructor
     * @param string $viewsPath
     * @param string $viewsExt
     */
    public function __construct(string $viewsPath = CONF_VIEW_PATH, string $viewsExt = CONF_VIEW_EXT)
    {
        $this->view = new View($viewsPath, $viewsExt);
    }
}