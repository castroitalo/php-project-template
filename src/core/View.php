<?php

declare(strict_types=1);

namespace src\core;

use League\Plates\Engine;

/**
 * Abstraction for the League\Plates library
 * 
 * @package src\core
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class View
{
    /**
     * @var Engine 
     */
    private Engine $platedEngine;

    /**
     * View constructor
     */
    public function __construct()
    {
        $this->platedEngine = new Engine(CONF_VIEW_PATH);
    }

    /**
     * Render page view
     * 
     * @param string $viewFile
     * @param array $viewData
     * @return void
     */
    public function renderView(string $viewFile, array $viewData = []): void
    {
        echo $this->platedEngine->render($viewFile, $viewData);
    }
}
