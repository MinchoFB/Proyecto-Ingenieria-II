<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/statesModel.php';
session_start();

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('states.html.twig');

$reports = array();

if ($_GET) {
    $idEstado = $_GET['idEstado'];
    toggleState($idEstado);
}
header( 'Location: statesController.php' );