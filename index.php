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
function protocole(){
    return stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? "https://" : "http://";
}

function currentDomain(){
    return protocole() . $_SERVER['HTTP_HOST']; // https://ehsannjafari.com
}

function asset($src){
    $domain = trim(CURRENT_DOMAIN,'/ ');
    $src = $domain . '/' . trim($src,'/ ');
    return $src;
}

function url($url){
    $domain = trim(CURRENT_DOMAIN,'/ ');
    $url = $domain . '/' . trim($url,'/ ');
    return $url;
}

# current opened url : use for routing system
function currentUrl(){
    return currentDomain() . $_SERVER['REQUEST_URI'];
}