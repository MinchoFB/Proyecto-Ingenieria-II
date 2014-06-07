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
    if (!deleteAutor($idAutor)) {
        $autors = getAutors();
        $reports[] = "El autor no se puede eliminar porque hay en existencia libros escritos por él!";
        echo $template->render(array('reports' => $reports, 'autores' => $autors));
        die;
    }
}
header( 'Location: autorsController.php' );