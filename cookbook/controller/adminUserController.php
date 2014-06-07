<?php


chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
session_start();
$twig = getTwigEnviroment();
$template = $twig->loadTemplate('adminUserHome.html.twig');
echo $template->render(array('logged' => $_SESSION['user']));