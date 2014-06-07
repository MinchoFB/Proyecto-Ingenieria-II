<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/AutorsModel.php';
session_start();

if (isset($_SESSION['user'])) {
    if (!($_SESSION['user']['nombreRol'] == "Admin")) {
        header('Location: normalUserController.php');
    }
} else {
    header('Location: homeController.php');
}

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('autors.html.twig');

$autors = getAutors();

echo $template->render(array('logged' => $_SESSION['user'], 'autores' => $autors));