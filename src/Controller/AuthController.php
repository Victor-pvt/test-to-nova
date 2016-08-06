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
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;
use Exception;

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
        $session = new Session();
        $user = new User($app);
        $twig = $app->getTwig();
        echo $twig->render('register.html.twig', ['user' => $user,]);
        if($session->get('errors')){
            $session->remove('errors');
        }
    }
    public function loginCheck(Request $request){
        /** @var App $app */
        $app = $this->app;
        $user = new User($app, $request);
        $user->login();
        $twig = $app->getTwig();
        $twig->addExtension(new \Twig_Extension_Core());
        echo $twig->render('home.html.twig', ['name' => 'loginCheck']);
    }
    public function registerCheck(Request $request){
        /** @var App $app */
        $app = $this->app;
        $twig = $app->getTwig();
        $session = new Session();
        if($session->get('errors')){
           $session->remove('errors');
        }
        $user = new User($app, $request);

        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();
        $violations = $validator->validate($user);

        $errors = [];
        if (count($violations) > 0) {
            /** @var  Validator\ConstraintViolation $violation */
            foreach ($violations as $violation){
                $key = $violation->getPropertyPath();
                $errors[$key] = $violation->getMessage();
            }
            $session->set('errors', $errors);
            $this->redirect('/register');
        }
        $user->register();
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