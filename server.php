<?php

/**
 * Este archivo contiene la lógica del cli-server router.
 */

declare(strict_types=1);

if (php_sapi_name() == "cli-server") {
    $extensions = ["jpg", "jpeg", "gif", 'png', "css", "js"];
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (in_array($ext, $extensions) && file_exists($_SERVER["DOCUMENT_ROOT"] . $path)) {
        return false;
    } else {
        require_once __DIR__ . '/public/index.php';
    }
}
