<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 15:36
 */

namespace App;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig_Loader_Filesystem;
use Twig_Environment;

class App
{
    private $config;
    private $routes = [];
    private $dbal;
    private $twig;
    private $isAuth=false;
    private $loader;



    /**
     * Конструктор класса
     */
    function __construct()
    {
        $this->config = require_once PATH_APP.'/config.php';
        $this->routes = require_once PATH_APP.'/routes.php';
        $session = new Session();
        if($session->get('user_id')){
            $this->isAuth = true;
        }
        $this->loader = new Twig_Loader_Filesystem(PATH_VIEWS);
        $this->twig = new Twig_Environment($this->loader, array(
            'cache' => PATH_CACHE,
        ));
    }

    /**
     * Обработка входящего запроса
     */
    public function run()
    {
        $request = Request::createFromGlobals();
        $response = new Response();

        $path = $request->getPathInfo();
        if (isset($this->routes[$path])) {
            ob_start();
            include $this->routes[$path];
            $response->setContent(ob_get_clean());
        } else {
            $response->setStatusCode(404);
            $response->setContent('Not Found');
        }

        $response->send();
    }

    public function AuthOn(User $user)
    {
    }

    public function AuthOff()
    {
    }
}