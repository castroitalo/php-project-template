<?php

declare(strict_types=1);

namespace App\Core\Bases;

use App\Core\Http\Request;
use App\Core\Http\Response;

/**
 * Contains base controller components and operations
 *
 * @package App\Core\Bases
 */
class BaseController
{
    /**
     * Initialize controller components
     *
     * @param Request $httpRequest Controller HTTP request handler
     * @param Response $httpResponse  Controller HTTP response handler
     * @return void
     */
    public function __construct(
        protected Request  $httpRequst   = new Request(),
        protected Response $httpResponse = new Response()
    ) {
    }
}
