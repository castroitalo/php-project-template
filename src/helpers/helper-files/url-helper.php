<?php

declare(strict_types=1);

/**
 * Get url
 *
 * @param string $path
 * @return string
 */
function get_url(string $path = ""): string
{
    return CONF_URL_BASE_DEV . $path;
}
