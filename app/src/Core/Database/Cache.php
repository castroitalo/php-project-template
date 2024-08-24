<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\Enums\ExceptionCodes\CacheExceptionCodes\CacheExceptionCodes;
use App\Core\Exceptions\Database\CacheException;
use RuntimeException;
use Redis;

/**
 * Establish a singleton database connection with a Redis cache database
 *
 * @package App\Core\Database
 */
final class Cache
{
    /**
     * The singleton instance
     *
     * @var null|Cache
     */
    private static ?Cache $instance = null;

    /**
     * Redis cache database connection
     *
     * @var Redis
     */
    private Redis $redis;

    /**
     * Private constructor to prevent direct instantiation
     *
     * @param string $cacheHostname Redis cache database hostname
     * @param int $cachePort Redis cache database port
     */
    private function __construct(
        private string $cacheHostname,
        private int    $cachePort,
        private int    $failedRedisConnectionExceptionCode = CacheExceptionCodes::FailedRedisConnection->value,
        private int    $failedDeleteKeyExceptionCode       = CacheExceptionCodes::FailedDeleteKey->value
    ) {
        $this->redis = new Redis();

        if (!$this->redis->connect($this->cacheHostname, $this->cachePort)) {
            throw new CacheException(
                'Failed to connect to Redis server at ' . $this->cacheHostname . ':' . $this->cachePort,
                $this->failedRedisConnectionExceptionCode
            );
        }
    }

    /**
     * Get the singleton instance of the Cache
     *
     * @return Cache
     */
    public static function getInstance(): Cache
    {
        if (self::$instance === null) {
            $hostname       = $_ENV['DATABASE_CACHE_HOST'] ?? '127.0.0.1'; // Default to localhost if not set
            $port           = $_ENV['DATABASE_CACHE_PORT'] ?? 6379; // Default Redis port
            self::$instance = new self($hostname, (int) $port);
        }

        return self::$instance;
    }

    /**
     * Set a new key/pair value to the Redis cache database.
     *
     * @param string $key New cache key
     * @param mixed $value New cache value
     * @return void
     */
    public function setValue(string $key, mixed $value): void
    {
        $this->redis->set($key, $value);
    }

    /**
     * Retrieves a key/pair value from the Redis cache database
     *
     * @param string $key The cache value key to be retrieved
     * @return mixed
     */
    public function getValue(string $key): mixed
    {
        return $this->redis->get($key);
    }

    /**
     * Update a key/pair value from the Redis cache database
     *
     * @param string $key New cache key
     * @param mixed $value New cache value
     * @return void
     */
    public function updateValue(string $key, mixed $value): void
    {
        $this->setValue($key, $value);
    }

    /**
     * Delete a key/pair value from the Redis cache database
     *
     * @param string $key The cache value key to be deleted
     * @return void
     * @throws RuntimeException
     */
    public function deleteValue(string $key): void
    {
        if (!$this->redis->del($key)) {
            throw new CacheException(
                'Failed deleting ' . $key . ' from Redis cache.',
                $this->failedDeleteKeyExceptionCode
            );
        }
    }

    /**
     * Prevent instance from being cloned
     */
    private function __clone() {}
}
