<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 15:36
 */

namespace App;

use Doctrine\DBAL\Configuration;
use Model\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Twig_Loader_Filesystem;
use Twig_Environment;
use Exception;

class App
{
    /** @var mixed  */
    private $config;
    /** @var array|mixed  */
    private $routes = [];
    /** @var \Doctrine\DBAL\Connection  */
    private $connection;
    /** @var Twig_Environment  */
    private $twig;
    /** @var bool  */
    private $isAuth=false;
    /** @var Twig_Loader_Filesystem  */
    private $loader;

    /**
     * Конструктор класса
     * задаем параметры системы, роуты, переменные
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
//            'cache' => PATH_CACHE,
        ));
        $this->twig->addGlobal('session', $session);

        $config = new \Doctrine\DBAL\Configuration();
        $this->connection = \Doctrine\DBAL\DriverManager::getConnection($this->config['dbal'], $config);
    }

    /**
     * Обработка входящего запроса
     * при обработке проверяем полученный путь, сверяем с имеющимся в параметрах, при наличие, подключаем нужный контроллер
     * если путь не найден, переводим на 404
     */
    public function run()
    {
        $request = Request::createFromGlobals();
        $response = new Response();

        $path = $request->getPathInfo();

        if (isset($this->routes[$path])) {
            ob_start();
            $className = 'Controller\\' . ucfirst($this->routes[$path]['controller']).'Controller';
            $action = $this->routes[$path]['action'];
            $controller = new $className($this);
            $response->setContent(ob_get_clean());
        } else {
            $className = 'Exeption\\ExeptionController';
            $action = '_404Action';
            $response->setStatusCode(404);
            $controller = new $className($this);
        }

        if ((isset($controller)) && is_callable([$controller, $action])) {
            if ($request) {
                $controller->$action($request);
            } else {
                $controller->$action();
            }
        } else {
            throw new Exception('In controller '.get_class($controller).' method '.$action.' not found!');
        }
    }

    /**
     * записываем в сессию токе текущего юзера, сессия авторизована
     */
    public function AuthOn(User $user)
    {
        $session = new Session();
        $token = md5($user->getId());
        $session->set('user_id', $token);
        $session->set('username', $user->getUsername());

//        session_start();
//        $path = '/';
//        $_SESSION['user_id'] = $user->id;
//        $this->user = $user;
//        if (isset($_SESSION['path_referer'])) {
////            $path = $_SESSION['path_referer'];
//            unset($_SESSION['path_referer']);
//        }
//        return $path;

    }

    /**
     * удаляем из сессии токен юзера, выход из системы
     */
    public function AuthOff()
    {
        $session = new Session();
        if($session->get('user_id')){
            $session->remove('user_id');
        }
    }

    /**
     * @return Twig_Loader_Filesystem
     */
    public function getLoader()
    {
        return $this->loader;
    }

    /**
     * @return Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }
}