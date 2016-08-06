<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 06.08.16
 * Time: 12:12
 */

use Twig_Loader_Filesystem;
use Twig_Environment;
$loader = new Twig_Loader_Filesystem(PATH_VIEWS);
$twig = new Twig_Environment($loader, ['cache' => PATH_CACHE,]);

echo $twig->render('login.html.twig', ['name' => 'home']);
