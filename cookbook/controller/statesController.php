<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/statesModel.php';
session_start();

if (isset($_SESSION['user'])) {
    if (!($_SESSION['user']['nombreRol'] == "Admin")) {
        header('Location: normalUserController.php');
    }
} else {
    header('Location: homeController.php');
}

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('states.html.twig');

$states = getStates();

echo $template->render(array('logged' => $_SESSION['user'], 'estados' => $states));