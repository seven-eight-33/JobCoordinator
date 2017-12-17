<?php
/**
 * Enviroment Variable Loader for SAKURA
 */
$path = "{$_SERVER['DOCUMENT_ROOT']}/../my_env/JobCoordinator";
if ('support@sakura.ad.jp' == $_SERVER['SERVER_ADMIN'] && file_exists($path))
    $_SERVER = array_merge($_SERVER, parse_ini_file($path));
