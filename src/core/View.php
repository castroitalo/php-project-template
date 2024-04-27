<?php

declare(strict_types=1);

namespace src\core;

use Exception;
use League\Plates\Engine;
use Throwable;

/**
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
     *
     * @var Engine
     */
    private Engine $platedEngine;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->platedEngine = new Engine(CONF_VIEW_PATH);
    }

    /**
     *
     * @param string $viewFile
     * @param array $viewData
     * @return void
     * @throws Throwable
     * @throws Exception
     */
    public function renderView(string $viewFile, array $viewData = []): void
    {
        echo $this->platedEngine->render($viewFile, $viewData);
    }
}
