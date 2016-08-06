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

class AuthController extends Controller
{
    public function login(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        echo $twig->render('login.html.twig', ['name' => 'login']);
    }
    public function register(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        echo $twig->render('login.html.twig', ['name' => 'register']);
    }
    public function loginCheck(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        echo $twig->render('login.html.twig', ['name' => 'loginCheck']);
    }
    public function registerCheck(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        echo $twig->render('login.html.twig', ['name' => 'registerCheck']);
    }
    public function logout(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        $app->AuthOff();

        echo $twig->render('home.html.twig', ['name' => 'До свидания']);
    }
}