<?php
/**
 * Enviroment Variable Loader for SAKURA
 */
$appName = substr($_SERVER["REQUEST_URI"], 1, strpos($_SERVER["REQUEST_URI"],'/') - 1);
$path = "{$_SERVER['DOCUMENT_ROOT']}/../my_env/{$appName}";
if ('support@sakura.ad.jp' == $_SERVER['SERVER_ADMIN'] && file_exists($path))
    $_SERVER = array_merge($_SERVER, parse_ini_file($path));
