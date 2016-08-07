<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 15:36
 */

namespace App;

use Model\User;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
    /** @var  Session */
    private $session;
    /** @var  FormFactory */
    private $formFactory;
    /** @var  ValidatorInterface */
    private $validator;
    /** @var  Translator */
    private $translator;

    /**
     * Конструктор класса
     * задаем параметры системы, роуты, переменные
     */
    function __construct()
    {
        $this->config = require_once PATH_APP.'/config.php';
        $this->routes = require_once PATH_APP.'/routes.php';
        require_once PATH_APP.'/setup.php';
        if($this->session->get('user_id')){
            $this->isAuth = true;
        }
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
        $token = md5($user->getId());
        $this->session->set('user_id', $token);
        $this->session->set('username', $user->getUsername());
    }

    /**
     * удаляем из сессии токен юзера, выход из системы
     */
    public function AuthOff()
    {
        if($this->session->get('user_id')){
            $this->session->remove('user_id');
            $this->session->remove('username');
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

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return array|mixed
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return boolean
     */
    public function isIsAuth()
    {
        return $this->isAuth;
    }

    /**
     * @return FormFactory
     */
    public function getFormFactory()
    {
        return $this->formFactory;
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }
    
}