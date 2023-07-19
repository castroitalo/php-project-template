<?php

/**
 * Create a new cookie
 * @param string $name
 * @param string $value
 * @return void
 */
function create_cookie(string $name, string $value): void
{
    setcookie($name, $value, CONF_COOKIE_TIME, "/", "", true, true);
}

/**
 * Get a cookie value
 * @param string $key
 * @return mixed
 */
function get_cookie_value(string $key): mixed
{
    return $_COOKIE[$key] ?? "";
}

/**
 * "Delete" a cookie
 * @param string $name
 * @return void
 */
function delete_cookie(string $value): void
{
    setcookie($value, "", time() - 3600, "/");
}