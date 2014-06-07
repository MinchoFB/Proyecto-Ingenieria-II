<?php


chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
session_start();

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('home.html.twig');

if (isset($_SESSION['user'])){
    echo $template->render(array('logged' => $_SESSION['user']));
    die;
}
echo $template->render(array());