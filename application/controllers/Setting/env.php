<?php
/**
 * Enviroment Variable Loader for SAKURA
 */
$path = "{$_SERVER['DOCUMENT_ROOT']}/../my_env/JobCoordinator";
$whitelist = array(
    'support@sakura.ad.jp',
    'root@localhost',
);
if (in_array($_SERVER['SERVER_ADMIN'], $whitelist) && file_exists($path))
    $_SERVER = array_merge($_SERVER, parse_ini_file($path));
