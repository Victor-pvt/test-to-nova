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
use Symfony\Component\HttpFoundation\Session\Session;

class HomeController extends Controller
{
    public function home(){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        echo $twig->render('home.html.twig', [
            'name' => 'home',
        ]);
    }

}