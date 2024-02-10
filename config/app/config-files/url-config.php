<?php

// When created a Route object, it can only be created using one of these HTTP methods
define(
    "CONF_URL_AVALIABLE_HTTP_METHODS",
    ["GET", "HEAD", "POST", "PUT", "DELETE", "CONNECT", "OPTIONS", "TRACE", "PATCH"]
);

// Base development URL
define("CONF_URL_BASE_DEV", "http://localhost:8080");

// Base production URL
define("CONF_URL_BASE_PROD", "");
