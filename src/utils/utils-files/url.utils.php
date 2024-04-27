<?php

use src\core\Response;

/**
 * Get current URL with a specified optional path.
 *
 * $url_path = Optional URL path to concatanate on the current URL
 *
 * @param string $url_path
 * @return string
 */
function get_url(string $url_path = ''): string
{
    return 'https://' . $_SERVER['HTTP_HOST'] . $url_path;
}

/**
 *
 * @return bool
 */
function is_https(): bool
{
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
        return false;
    }

    return true;
}

/**
 *
 * @return void
 */
function internal_server_error(): void
{
    Response::redirectTo('/internal-server-error');
}

/**
 *
 * @return void
 */
function page_not_found(): void
{
    Response::redirectTo('/page-not-found');
}
