<?php

use src\models\SessionModel;

/**
 * Get user's session id
 * @return string
 */
function get_session_id(): string
{
    return get_cookie_value("session_id");
}

/**
 * Get current user's session
 * @return array|null
 */
function get_session(): ?array
{
    $session = (new SessionModel())->getSessionById(get_session_id());

    if (!$session) {
        return null;
    }

    parse_str(str_replace("/", "&", $session->session_data), $sessionData);

    return $sessionData;
}

/**
 * Get a sesssion value
 * @param string $key
 * @return string|null
 */
function get_session_value(string $key): ?string
{
    $sessionData = get_session();

    return $sessionData[$key] ?? null;
}

/**
 * Check if there is a session key
 * @param string $key
 * @return bool
 */
function has_session_key(string $key): bool
{
    return isset(get_session()[$key]);
}

/**
 * Creates a new session in database
 * @param string $sessionData
 * @param int $userId
 * @return SessionModel|null
 */
function create_session(string $sessionData, int $userId): ?SessionModel
{
    if (!session_id()) {
        session_start();
    }

    $session = (new SessionModel())
        ->initializeData(session_id(), $sessionData, $userId)
        ->createSession();

    if (!$session) {
        session_destroy();

        return null;
    }

    session_destroy();

    return $session;
}

/**
 * Delete session from database (logout)
 * @param string $sessionId
 * @return bool
 */
function delete_session(): bool
{
    return (new SessionModel())->deleteSession(get_session_id());
}