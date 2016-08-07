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
    /**
     * страница вызова формы логина
     */
    public function login(){
        $twig = $this->app->getTwig();
        echo $twig->render('login.html.twig', ['name' => 'login']);
        $this->clearSession();
    }

    /**
     * страница вызова формы регистрации
     */
    public function register(){
        /** @var User $user */
        $user = new User($this->app);
        $twig = $this->app->getTwig();
        echo $twig->render('register.html.twig', ['user' => $user,]);
        $this->clearSession();
    }

    /**
     * страница обработки формы логина
     * @param Request $request
     */
    public function loginCheck(Request $request){
        /** @var User $user */
        $user = new User($this->app, $request);
        if($user->login()){
            $this->redirect('/');
        }else{
            $this->redirect('/login');
        }
    }

    /**
     * страница обработки формы регистрации
     * @param Request $request
     */
    public function registerCheck(Request $request){
        /** @var User $user */
        $user = new User($this->app, $request);
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
            $this->app->getSession()->set('errors', $errors);
            $this->redirect('/register');
        }else{
            $this->registerSession($user->register());
            $this->redirect('/');
        }
    }

    /**
     * выход из системы
     */
    public function logout(){
        $this->app->AuthOff();
        $this->redirect('/');
    }
}