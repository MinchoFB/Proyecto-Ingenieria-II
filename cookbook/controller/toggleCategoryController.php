<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/categoriesModel.php';
session_start();

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('categories.html.twig');

$reports = array();

if ($_GET) {
    $idCategoria = $_GET['idCategoria'];
    toggleCategory($idCategoria);
}
header( 'Location: categoriesController.php' );
