<?php 

declare(strict_types=1);

namespace src\controllers;

use src\core\BaseControllerCore;

/**
 * Class HomeController
 * 
 * @package src\controller
 */
final class HomeController extends BaseControllerCore
{
    /**
     * Homepage controller
     *
     * @return void
     */
    public function homepage(): void 
    {
        $this->controllerView->render("index.view");
    }
}
