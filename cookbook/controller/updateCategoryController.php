<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/categoriesModel.php';
session_start();

if (isset($_SESSION['user'])) {
    if (!($_SESSION['user']['nombreRol'] == "Admin")) {
        header('Location: normalUserController.php');
    }
} else {
    header('Location: homeController.php');
}

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('updateCategory.html.twig');

$reports = array();

function nameIsOk($nombre) {
    //Solo letras y espacios
    if (preg_match('/^[a-zA-Záéíóú\s]+$/', $nombre)) {
        return true;
    }
    return false;
}

if ($_GET) {
    $idCategoria = $_GET['idCategoria'];
    $categoria = getCategory($idCategoria);
    echo $template->render(array('logged' => $_SESSION['user'], 'categoria' => $categoria));
    die;
}

if ($_POST) {
    $idCategoria = $_POST['idCategoria'];
    $nombre = $_POST['nombre'];
    $categoria = getCategory($idCategoria);
    if (!nameIsOk($nombre)) {
        $reports[] = "Ese nombre no es válido. Debe contener solo caracteres alfabéticos.";
        echo $template->render(array('logged' => $_SESSION['user'], 'reports' => $reports, 'categoria' => $categoria));
        die;
    }
    if ((categoryExist($nombre))) {
        $reports[] = "Esa categoría ya existe!";
        echo $template->render(array('logged' => $_SESSION['user'], 'reports' => $reports, 'categoria' => $categoria));
        die;
    }
    updateCategory($idCategoria, $nombre);
}

header('Location: categoriesController.php');