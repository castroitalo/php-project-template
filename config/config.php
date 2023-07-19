<?php 

// app cconfiguratio constants

/**
 * DATABASE
 */
define("CONF_DB_HOST", "");
define("CONF_DB_NAME", "");
define("CONF_DB_USER", "");
define("CONF_DB_PASSWORD", "");
define("CONF_DB_PORT", "");

/**
 * DATABASE TABLES
 */
define("CONF_TABLE_TABLENAME", "tablename");
define("CONF_TABLE_SESSIONS", "sessions");

/**
 * PASSWORDS
 */
define("CONF_PASSWORD_ALGO", PASSWORD_DEFAULT);
define("CONF_PASSWORD_MIN_LEN", 8);
define("CONF_PASSWORD_MAX_LEN", 50);

/**
 * URL'S
 */
define("CONF_URL_BASE_DEV", "http://www.localhost");
define("CONF_URL_BASE_PROD", "https://www.domain.com");

/**
 * COOKIES
 */
define("CONF_COOKIE_TIME", time() + 60 * 60 * 24 * 90);

/**
 * MESSAGES
 */
define("CONF_MESSAGE_DEFAULT", "light");
define("CONF_MESSAGE_INFO", "info");
define("CONF_MESSAGE_SUCCESS", "success");
define("CONF_MESSAGE_WARNING", "warning");
define("CONF_MESSAGE_ERROR", "danger");

/**
 * VIEWS
 */
define("CONF_VIEW_PATH", __DIR__ . "/../public/views");
define("CONF_VIEW_EXT", "php");

/**
 * NAMESPACES
 */
define("CONF_NAMESPACE_CONTROLLERS", "src\controllers\\");
define("CONF_NAMESPACE_MIDDLEWARES", "src\middlewares\\");

/**
 * UPLOADS
 */
define("CONF_UPLOADS", __DIR__ . "/../../storage/uploads");
