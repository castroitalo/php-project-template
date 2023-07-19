<?php

namespace src\core;

use League\Plates\Engine;

/**
 * Class View
 * @package src\core
 */
class View
{

    /**
     * Current engine
     * @var Engine
     */
    private Engine $engine;

    /**
     * View constructor
     * @param string $viewsPath
     * @param string $viewsExt
     */
    public function __construct(string $viewsPath, string $viewsExt)
    {
        $this->engine = new Engine($viewsPath, $viewsExt);
    }

    /**
     * Add a new folder to the engine
     * @param string $alias
     * @param string $path
     * @return void
     */
    public function addFolder(string $alias, string $path): void
    {
        $this->engine->addFolder($alias, $path);
    }

    /**
     * Render specified page
     * @param string $file
     * @param array $data
     * @return string
     */
    public function renderPage(string $file, array $data = []): string
    {
        return $this->engine->render($file, $data);
    }

    /**
     * Get current engine
     * @return Engine
     */
    public function getEngine(): Engine
    {
        return $this->engine;
    }
}