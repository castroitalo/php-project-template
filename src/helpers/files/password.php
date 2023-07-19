<?php

/**
 * Hash the user input password
 * @param string $password
 * @return string
 */
function hash_password(string $password): string
{
    return password_hash($password, CONF_PASSWORD_ALGO);
}

/**
 * Verify is user input password meets the requirements
 * @param string $password
 * @return bool
 */
function is_password(string $password): bool
{
    $hasMinLen = mb_strlen($password) > CONF_PASSWORD_MIN_LEN;
    $hasMaxLen = mb_strlen($password) <= CONF_PASSWORD_MAX_LEN;

    if (!$hasMinLen && !$hasMaxLen) {
        return false;
    }

    return true;
}

/**
 * Verify if a user input password is equal to a database password hash
 * @param string $password
 * @param string $hash
 * @return bool
 */
function check_password_validity(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}

/**
 * Filter malicious scripts in password input
 * @param string $password
 * @return string
 */
function filter_password(string $password): string
{
    return filter_var($password, FILTER_SANITIZE_SPECIAL_CHARS);
}