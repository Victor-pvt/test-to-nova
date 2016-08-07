<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 07.08.16
 * Time: 14:21
 */

define('PATH_ROOT', dirname(__DIR__));
define('PATH_APP', dirname(__DIR__) . '/app');
define('PATH_WEB', PATH_ROOT . '/web');
define('PATH_VENDOR', PATH_ROOT . '/vendor');
define('PATH_SRC', PATH_ROOT . '/src');
define('PATH_PAGES', PATH_SRC . '/pages');
define('PATH_VIEWS', PATH_SRC . '/views');
define('PATH_CACHE', PATH_APP . '/cache/dev');

define('DEFAULT_FORM_THEME', 'form_div_layout.html.twig');

define('VENDOR_DIR', realpath(__DIR__ . '/../vendor'));
define('VENDOR_FORM_DIR', VENDOR_DIR . '/symfony/form');
define('VENDOR_VALIDATOR_DIR', VENDOR_DIR . '/symfony/validator');
define('VENDOR_TWIG_BRIDGE_DIR', VENDOR_DIR . '/symfony/twig-bridge');

define('DEBUG_MODE', TRUE);
