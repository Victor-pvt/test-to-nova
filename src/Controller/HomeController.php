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

class HomeController extends Controller
{
    public function home(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        echo $twig->render('login.html.twig', ['name' => 'home']);
    }

}