<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
session_start();

$reports = array();
$errors = array();

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('contact.html.twig');

function emptyFields($nombre, $email, $asunto, $mensaje) {
    if ($nombre == '' || $email == '' || $asunto == '' || $mensaje == '') {
        return true;
    }
    return false;
}

function nameIsOk($nombre) {
    //Solo letras y espacios
    if (preg_match('/^[a-zA-Záéíóú\s]+$/', $nombre)) {
        return true;
    }
    return false;
}

function mailIsOk($email) {
    if (preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email)) {
        return true;
    }
    return false;
}

if ($_POST) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $asunto = $_POST['asunto'];
    $mensaje = $_POST['mensaje'];
    // procesar formulario

    if (emptyFields($nombre, $email, $asunto, $mensaje)) {
        $errors[] = "Uno de los campos esta vacio";
        echo $template->render(array('errors' => $errors));
        die;
    }

    if (!(nameIsOk($nombre))) {
        $errors[] = "El nombre no es válido. Sólo debe contener caracteres alfabeticos";
        echo $template->render(array('errors' => $errors));
        die;
    }

    if (!(mailIsOk($email))) {
        $errors[] = "Ese email no es válido";
        echo $template->render(array('errors' => $errors));
        die;
    }

    $para = 'juanpablogaliotti@gmail.com';
    $msj = wordwrap($mensaje, 70, "\r\n");
    $body = "Nombre: " . $nombre . " \n\nEmail: " . $email . " \n\nAsunto: " . $asunto . " \n\nMensaje:\n. " . $msj;


    mail($para, $asunto, $body);
    $reports[] = "Mensaje correctamente enviado!";
    echo $template->render(array('reports' => $reports));
    die;
}
//    signUpUser($email, $password, $nombre, $apellido, $dni);
//    $reports[] = "Mensaje correctamente enviado!";
//    echo $template->render(array('reports' => $reports));
//    die;

echo $template->render(array());
