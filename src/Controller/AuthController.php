<?php

/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 17:26
 */
namespace Controller;

use App\App;
use App\Controller;
use Symfony\Component\HttpFoundation\Request;
use Model\User;

class AuthController extends Controller
{
    public function login(){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        echo $twig->render('login.html.twig', ['name' => 'login']);
    }
    public function register(){
        /** @var App $app */
        $app = $this->app;
        $user = new User($app);
        
        $twig = $app->getTwig();
        echo $twig->render('register.html.twig', ['user' => $user]);
    }
    public function loginCheck(Request $request){
        /** @var App $app */
        $app = $this->app;
        $user = new User($app, $request);
        $user->login();
        $twig = $app->getTwig();
        echo $twig->render('home.html.twig', ['name' => 'loginCheck']);
    }
    public function registerCheck(Request $request){
        /** @var App $app */
        $app = $this->app;
        $user = new User($app, $request);
        $user->register();

        $twig = $app->getTwig();
        echo $twig->render('home.html.twig', ['name' => 'registerCheck']);
    }
    public function logout(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        $app->AuthOff();

        echo $twig->render('home.html.twig', ['name' => 'До свидания']);
    }
}