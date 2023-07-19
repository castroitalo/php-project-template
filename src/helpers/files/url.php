<?php

/**
 * Get requested HTTP method
 * @return string
 */
function get_http_method(): string 
{
    return $_SERVER["REQUEST_METHOD"];
}

/**
 * Get current project URL
 * @return string
 */
function get_url(): string
{
    if (str_contains($_SERVER["SERVER_NAME"], "localhost")) {
        return CONF_URL_BASE_DEV;
    }

    return CONF_URL_BASE_PROD;
}

/**
 * Get project URI
 */
function get_uri()
{
    $uri = $_SERVER["REQUEST_URI"];

    if (str_contains($uri, "?")) {
        return mb_strstr($uri, "?", true);
    }

    return ($uri === "/" ? $uri : rtrim($uri, "/"));
}