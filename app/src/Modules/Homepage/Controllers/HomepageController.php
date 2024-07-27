<?php

declare(strict_types=1);

namespace App\Modules\Homepage\Controllers;

/**
 * Controls every homepage requests
 *
 * @package App\Core\Modules\Homepage\Controllers
 * @final
 */
final class HomepageController
{
    /**
     * /
     *
     * @return void
     */
    public function homepage(): void
    {
        echo 'Hello World! <br>';
    }
}
