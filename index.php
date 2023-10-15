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

function methodField(){
    return $_SERVER['REQUEST_METHOD'];
}

function displayError($displayError){
    if($displayError){
        ini_set('display_errors', 1);
        ini_set('display_statup_errors', 1);
        error_reporting(E_ALL);
    }else{
        ini_set('display_error', 0);
        ini_set('display_statup_errors', 0);
        error_reporting(0);
    }
}
// displayError(DISPLAY_ERROR);

global $flashMessage;
if(isset($_SESSION['flash_message'])){
    $flashMessage = $_SESSION['flash_message'];
    unset($_SESSION['flash_message']);
}

function flash($name, $value=null){
    if($value == null){
        global $flashMessage;
        $message = isset($flashMessage[$name]) ? $flashMessage[$name] : '';
        return $message;
    }else{
        $_SESSION['flash_message'][$name] = $value;
    }
}

// echo flash("login_error","Login failed!"); 
echo flash("login_error"); 
// echo flash("cart_success","Product added successfully!"); 
echo flash("cart_success");