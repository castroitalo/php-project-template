<?php 

declare(strict_types=1);

namespace src\core;

/**
 * Class BaseControllerCore
 * 
 * @package src\core
 * @abstract
 */
abstract class BaseControllerCore
{
    /**
     * Controller view manager
     *
     * @var ViewCore
     */
    protected ViewCore $controllerView;

    /**
     * BaseControllerCore constructor
     */
    public function __construct()
    {
        $this->controllerView = new ViewCore();
    }
}
