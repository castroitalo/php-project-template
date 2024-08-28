<?php

declare(strict_types=1);

namespace App\Core\Bases;

use App\Core\View\View;

/**
 * Contains base controller components and operations
 *
 * @package App\Core\Bases
 */
class BaseController
{
    /**
     * Controller view
     *
     * @var null|View
     */
    protected ?View $view = null;

    /**
     * Initialize controller components
     *
     * @param null|string $templatesPath Templates path
     * @return void
     */
    public function __construct(?string $templatesPath = null)
    {
        $this->view = new View($templatesPath);
    }
}
