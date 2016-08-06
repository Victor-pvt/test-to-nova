<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 12:06
 */

$map = array(
    '/' => PATH_PAGES.'/home.php',
    '/login' => PATH_PAGES.'/login.php',
    '/register'   => PATH_PAGES.'/register.php',
);
$routes = array(
    '/' => [
        'controller' => 'home',
        'action' => 'home',
    ],
    '/login' => [
        'controller' => 'auth',
        'action' => 'login',
    ],
    '/register'   => [
        'controller' => 'auth',
        'action' => 'register',
    ],
    '/login/check' => [
        'controller' => 'auth',
        'action' => 'loginCheck',
    ],
    '/register/check' => [
        'controller' => 'auth',
        'action' => 'registerCheck',
    ],
    '/logout' => [
        'controller' => 'auth',
        'action' => 'logout',
    ],
);

return $routes;