<?php

declare(strict_types=1);

namespace src\controllers;

use src\traits\controllers\BaseController;

/**
 *
 * @package src\controllers
 * @author castroitalo <dev.castro.italo@gmail.com>
 * @version 1.0.0
 * @access public
 * @final
 */
final class HomepageController
{
    use BaseController;

    /**
     *
     * @return void
     */
    public function homepage(): void
    {
        $this->view->renderView(
            'pages/homepage.view',
            [
                'page_data' => [
                    'title' => 'Homepage',
                ],
            ],
        );
    }
}
