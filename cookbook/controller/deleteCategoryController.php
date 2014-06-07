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
    if (!deleteCategory($idCategoria)) {
        $categories = getCategories();
        $reports[] = "La categoria no se puede eliminar porque tiene libros asociados a ella!";
        echo $template->render(array('reports' => $reports, 'categorias' => $categories));
        die;
    }
}
header( 'Location: categoriesController.php' );