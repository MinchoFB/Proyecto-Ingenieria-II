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

$reports = array();
$twig = getTwigEnviroment();
$template = $twig->loadTemplate('addCategory.html.twig');

function nameIsOk($nombre) {
    //Solo letras y espacios
    if (preg_match('/^[a-zA-Záéíóú\s]+$/', $nombre)) {
        return true;
    }
    return false;
}

if ($_POST) {
    $nombre = $_POST['nombre'];

    if (!nameIsOk($nombre)) {
        $reports[] = "Ese nombre no es válido. Debe contener solo caracteres alfabéticos.";
        echo $template->render(array('logged' => $_SESSION['user'], 'reports' => $reports));
        die;
    }
    if ((categoryExist($nombre))) {
        $reports[] = "Esa categoría ya existe!";
        echo $template->render(array('logged' => $_SESSION['user'], 'reports' => $reports));
        die;
    }

    addCategorie($nombre);
    header('Location: categoriesController.php');
}

echo $template->render(array('logged' => $_SESSION['user']));
