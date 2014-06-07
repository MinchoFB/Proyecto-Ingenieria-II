<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/autorsModel.php';
session_start();

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('autors.html.twig');

$reports = array();

if ($_GET) {
    $idAutor = $_GET['idAutor'];
    toggleAutor($idAutor);
}
header( 'Location: autorsController.php' );
