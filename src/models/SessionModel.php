<?php

namespace src\models;

use src\core\BaseModel;

/**
 * Class SessionModel
 * @package src\models
 */
class SessionModel extends BaseModel
{

    /**
     * SessionModel database table
     * @var string $table
     */
    private static string $table = CONF_DB_NAME . "." . CONF_TABLE_SESSIONS;

    /**
     * SessionModel required to create a new session in database
     * @var array $requiredFields
     */
    private static array $requiredFields = ["session_id", "session_data", "user_id"];

    /**
     * Starts required fields to create a new session in database
     * @param string $sessionId
     * @param string $sessionData
     * @param string $userId
     * @return SessionModel|null
     */
    public function initializeData(string $sessionId, string $sessionData, string $userId): ?SessionModel
    {
        $this->session_id = $sessionId;
        $this->session_data = $sessionData;
        $this->user_id = $userId;

        if (!$this->checkRequiredFields(self::$requiredFields, $this->data)) {
            return null;
        }

        return $this;
    }

    /**
     * Get session based on it's id
     * @param string $sessionId
     * @return object|null
     */
    public function getSessionById(string $sessionId): ?object
    {
        $terms = " WHERE session_id=:session_id";
        $params = "session_id={$sessionId}";
        $session = $this->readData(self::$table, $terms, $params);

        if ($this->getFail() || !$session->rowCount()) {
            return null;
        }

        return $session->fetchObject(__CLASS__);
    }

    /**
     * Creates a new session in database
     * @return SessionModel|null
     */
    public function createSession(): ?SessionModel
    {
        $session = $this->getSessionById($this->session_id);

        if ($session) {
            return $session;
        }

        $this->createData($this->data, [], self::$table);

        if ($this->getFail()) {
            return null;
        }

        return $this->getSessionById($this->session_id);
    }

    /**
     * Update a session key
     * @param string $sessionId
     * @param string $sessionKey
     * @param string $sessionValue
     * @return bool
     */
    public function updateSession(string $sessionId, string $sessionKey, string $sessionValue): bool
    {
        $session = $this->getSessionById($sessionId);
        $session->$sessionKey = $sessionValue;
        $updatedSession = $this->updateData(
            $session,
            [], self::$table,
            "session_id='{$session->session_id}'"
        );

        if ($this->getFail() || !$updatedSession) {
            return false;
        }

        return true;
    }

    /**
     * Delete a session in database
     * @param string $sessionId
     * @return bool
     */
    public function deleteSession(string $sessionId): bool
    {
        $deleted = $this->deleteData(self::$table, "session_id='{$sessionId}'");

        if ($this->getFail() || !$deleted) {
            return false;
        }

        return true;
    }
}