<?php

namespace App;
use App\App;
use Model\User;

class Controller {
	/** @var App $app */
	public $app;
    /**
	 * Конструктор класса, требует передачи App
	 * @param App $app
	 */
	function __construct(App $app) {
		$this->app = $app;
	}
	/**
	 * @param string $url
	 */
	public function redirect($url = '/') {
		header("Location: {$url}");
		exit();
	}

    /**
     * очистка флеш переменных сессии, после регистрации
     */
	public function clearSession(){
		if($this->app->getSession()->get('errors')){
			$this->app->getSession()->remove('errors');
		}
		if($this->app->getSession()->get('success')){
			$this->app->getSession()->remove('success');
		}
	}

    /**
     * установка флеш переменных сессии, в случае успешной или неуспешной регистрации
     * @param User|null $user
     */
	public function registerSession(User $user = null){
		if($user){
			$success[$user->getUsername()] = 'Успешно зарегистрировался';
			$this->app->getSession()->set('success', $success);
		}else{
			$errors['error'] = 'не Успешная регистрация';
			$this->app->getSession()->set('errors', $errors);
		}
	}
}