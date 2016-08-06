<?php
define('PATH_ROOT', dirname(__DIR__));
define('PATH_APP', PATH_ROOT . '/app');
define('PATH_WEB', PATH_ROOT . '/web');
define('PATH_VENDOR', PATH_ROOT . '/vendor');
define('PATH_SRC', PATH_ROOT . '/src');
define('PATH_PAGES', PATH_SRC . '/pages');
define('PATH_VIEWS', PATH_SRC . '/views');
define('PATH_CACHE', PATH_APP . '/cache/dev');
define('DEBUG_MODE', TRUE);

error_reporting(E_ALL);
ini_set('display_errors', DEBUG_MODE);

require_once PATH_VENDOR .'/autoload.php';

$app = new \App\App();

$app->run();
