<?php

# Session Start
session_start();

# Config
define('PROJECT_NAME', 'Hello-News');
define('BASE_PATH', __DIR__);
define('CURRENT_DOMAIN', currentDomain(). '/' .PROJECT_NAME); 
define('DISPLAY_ERROR', true); // shows error when in development environment
define('ِDB_HOST', 'localhost');
define('DB_NAME', 'hellonews');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

// Helpers