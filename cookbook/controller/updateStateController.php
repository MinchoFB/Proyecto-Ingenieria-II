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
$template = $twig->loadTemplate('updateState.html.twig');

$reports = array();

function nameIsOk($nombre) {
    //Solo letras y espacios
    if (preg_match('/^[a-zA-Záéíóú\s]+$/', $nombre)) {
        return true;
    }
    return false;
}

if ($_GET) {
    $idEstado = $_GET['idEstado'];
    $estado = getState($idEstado);
    echo $template->render(array('logged' => $_SESSION['user'], 'estado' => $estado));
    die;
}

if ($_POST) {
    $idEstado = $_POST['idEstado'];
    $nombre = $_POST['nombre'];
    $estado = getState($idEstado);
    if (!nameIsOk($nombre)) {
        $reports[] = "Ese nombre no es válido. Debe contener solo caracteres alfabéticos.";
        echo $template->render(array('logged' => $_SESSION['user'], 'reports' => $reports, 'estado' => $estado));
        die;
    }
    if ((stateExist($nombre))) {
        $reports[] = "Ese estado ya existe.";
        echo $template->render(array('logged' => $_SESSION['user'], 'reports' => $reports, 'estado' => $estado));
        die;
    }
    updateState($idEstado, $nombre);
}

header('Location: StatesController.php');