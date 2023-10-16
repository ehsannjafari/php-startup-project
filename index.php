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
function uri($reservedUrl, $class, $method, $requestMethod = 'GET'){
    // Current Url Processing
    $currentUrl = explode('?', currentUrl())[0];
    $currentUrl = str_replace(CURRENT_DOMAIN, '', $currentUrl);
    $currentUrl = trim($currentUrl,'/ ');
    $currentUrlArray = explode('/',$currentUrl);
    $currentUrlArray = array_filter($currentUrlArray);

    // Reserved Url Processing
    $reservedUrl = trim($reservedUrl, '/');
    $reservedUrlArray = explode('/', $reservedUrl);
    $reservedUrlArray = array_filter($reservedUrlArray);

    // Url matching process 
    // size checking : if both url had the same size it's ok
    if(sizeof($currentUrlArray) != sizeof($reservedUrlArray) || methodField() != $requestMethod){
        return false;
    }

    // what if the url contains parameters
    // Reserved URL: admin/categories/edit/{id}
    // Current URL: admin/categories/edit/2
    $parameters = [];
    for($key = 0; $key < sizeof($currentUrlArray); $key++){
        if($reservedUrlArray[$key][0] == "{" && $reservedUrlArray[$key][strlen($reservedUrlArray[$key]) - 1] == "}"){
            array_push($parameters, $currentUrlArray[$key]); // push the parameters to parameter array
        }
        // admin == admin
        // categories == categories
        elseif($currentUrlArray[$key] !== $reservedUrlArray[$key]){
            return false;
        }
    }

    if(methodField() == 'POST'){
        $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
        $parameters = array_merge([$request], $parameters);
    }

    $object = new $class;
    call_user_func_array(array($object, $method), $parameters);
    exit();
}
uri('/admin/categories','Category','Index');


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
// echo flash("login_error"); 
// echo flash("cart_success","Product added successfully!"); 
// echo flash("cart_success");

function dd($var){
    echo "<pre>";
    var_dump($var);
    exit();
}