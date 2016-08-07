<?php

/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 17:26
 */
namespace Controller;

use App\Controller;

class HomeController extends Controller
{
    /**
     * домашняя страница, с очищение флеш переменных сессии
     */
    public function home(){
        $twig = $this->app->getTwig();
        echo $twig->render('home.html.twig', ['name' => 'home',]);
        $this->clearSession();
    }
}