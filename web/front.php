<?php
require_once dirname(__DIR__) . '/app/constans.php';
error_reporting(E_ALL);
ini_set('display_errors', DEBUG_MODE);

require_once PATH_VENDOR .'/autoload.php';
$app = new \App\App();
$app->run();
