<?php 

declare(strict_types=1);

namespace src\core;

use League\Plates\Engine;

/**
 * Class ViewCore
 * 
 * @package src\core
 */
final class ViewCore
{
    /**
     * League/plates engine
     *
     * @var Engine
     */
    private Engine $platesEngine;

    /**
     * ViewCore constructor
     */
    public function __construct()
    {
        $this->platesEngine = new Engine(CONF_VIEW_PATH);
    }

    /**
     * Render a controller view
     *
     * @param string $viewFilePath
     * @param array $viewData
     * @return void
     */
    public function render(string $viewFilePath, array $viewData = []): void 
    {
        echo $this->platesEngine->render($viewFilePath, $viewData);
    }
}
