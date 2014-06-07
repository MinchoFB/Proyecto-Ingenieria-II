<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/autorsModel.php';
session_start();

if (isset($_SESSION['user'])) {
    if (!($_SESSION['user']['nombreRol'] == "Admin")) {
        header('Location: normalUserController.php');
    }
} else {
    header('Location: homeController.php');
}

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('updateAutor.html.twig');

$reports = array();

function nameIsOk($nombre) {
    //Solo letras y espacios
    if (preg_match('/^[a-zA-Záéíóú\s]+$/', $nombre)) {
        return true;
    }
    return false;
}

if ($_GET) {
    $idAutor = $_GET['idAutor'];
    $autor = getAutor($idAutor);
    echo $template->render(array('logged' => $_SESSION['user'], 'autor' => $autor));
    die;
}

if ($_POST) {
    $idAutor = $_POST['idAutor'];
    $nombre = $_POST['nombre'];
    $autor = getAutor($idAutor);
    if (!nameIsOk($nombre)) {
        $reports[] = "Ese nombre no es válido. Debe contener solo caracteres alfabéticos.";
        echo $template->render(array('logged' => $_SESSION['user'], 'reports' => $reports, 'autor' => $autor));
        die;
    }
    if ((autorExist($nombre))) {
        $reports[] = "Ese autor ya existe.";
        echo $template->render(array('logged' => $_SESSION['user'], 'reports' => $reports, 'autor' => $autor));
        die;
    }
    updateAutor($idAutor, $nombre);
}

header('Location: autorsController.php');