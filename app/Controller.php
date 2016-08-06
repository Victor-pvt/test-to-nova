<?php

namespace App;

use App\App;

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
}