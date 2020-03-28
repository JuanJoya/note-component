<?php

/**
 * @deprecated
 */

if (php_sapi_name() == "cli-server") {
    // running under built-in server so
    // route static assets and return false
    $extensions = array("jpg", "jpeg", "gif", 'png', "css", "js");
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    
    if (in_array($ext, $extensions)) {
        return false;  
    } else {
        require_once __DIR__ . '/public/index.php';
    }
}
