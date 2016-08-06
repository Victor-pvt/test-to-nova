<?php

/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 17:48
 */
namespace Exeption;
use App\App;
use App\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExeptionController extends Controller
{
    public function _404Action(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();

        echo $twig->render('_404.html.twig', ['name' => 'нет такой странице в этом месте']);
    }
}