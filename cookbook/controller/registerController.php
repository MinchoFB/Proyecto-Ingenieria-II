<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/registerModel.php';
session_start();

$reports = array();
$errors = array();

$twig = getTwigEnviroment();
$template = $twig->loadTemplate('register.html.twig');

function emptyFields($email, $emailCheck, $password, $passwordCheck, $nombre, $apellido, $dni) {
    if ($email == '' || $emailCheck == '' || $password == '' || $passwordCheck == '' || $nombre == '' || $apellido == '' || $dni == '') {
        return true;
    }
    return false;
}

function emailCheckMatches($email, $emailCheck) {
    if ($email == $emailCheck) {
        return true;
    }
    return false;
}

function passwordIsOk($password) {
    //debe contener entre 5 y 12 caracteres, 1 uppercase, 1 lowercase y 1 numero
    if (preg_match('/^(?=^.{5,12}$)((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.*$/', $password)) {
        return true;
    }
    return false;
}

function PasswordCheckMatches($password, $passwordCheck) {
    if ($password == $passwordCheck) {
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

function nameIsOk($nombre) {
    //Solo letras y espacios
    if (preg_match('/^[a-zA-Záéíóú\s]+$/', $nombre)) {
        return true;
    }
    return false;
}

function apellidoIsOk($apellido) {
    //Solo letras y espacios
    if (preg_match('/^[a-zA-Záéíóú\s]+$/', $apellido)) {
        return true;
    }
    return false;
}

function dniIsOk($dni) {
    //solo numeros, cantidad = 8
    if (preg_match('/^\d{7,8}$/', $dni)) {
        return true;
    }
    return false;
}

if ($_POST) {
    $email = $_POST['email'];
    $emailCheck = $_POST['emailCheck'];
    $password = $_POST['password'];
    $passwordCheck = $_POST['passwordCheck'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    // procesar formulario

    if (emptyFields($email, $emailCheck, $password, $passwordCheck, $nombre, $apellido, $dni)) {
        $errors[] = "Uno de los campos esta vacio";
        echo $template->render(array('errors' => $errors, 'email' => $email, 'emailCheck' => $emailCheck, 'password' => $password, 'passwordCheck' => $passwordCheck, 'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni));
        die;
    }
    if (!(mailIsOk($email))) {
        $errors[] = "Ese email no es válido";
        echo $template->render(array('errors' => $errors, 'email' => $email, 'emailCheck' => $emailCheck, 'password' => $password, 'passwordCheck' => $passwordCheck, 'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni));
        die;
    }
    if (!emailCheckMatches($email, $emailCheck)) {
        $errors[] = "La confirmacion del email es incorrecta";
        echo $template->render(array('errors' => $errors, 'email' => $email, 'emailCheck' => $emailCheck, 'password' => $password, 'passwordCheck' => $passwordCheck, 'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni));
        die;
    }
    if (emailExist($email)) {
        $errors[] = "Ese email ya se encuentra en uso";
        echo $template->render(array('errors' => $errors, 'email' => $email, 'emailCheck' => $emailCheck, 'password' => $password, 'passwordCheck' => $passwordCheck, 'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni));
        die;
    }

    if (!PasswordIsOK($password)) {
        $errors[] = "El password debe conterner entre 5 y 12 caracteres y al menos 1 mayúscula, 1 minúscula y un número. Ingreselo nuevamente por favor.";
        echo $template->render(array('errors' => $errors, 'email' => $email, 'emailCheck' => $emailCheck, 'password' => $password, 'passwordCheck' => $passwordCheck, 'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni));
        die;
    }

    if (!passwordCheckMatches($password, $passwordCheck)) {
        $errors[] = "La confirmacion del password es incorrecta";
        echo $template->render(array('errors' => $errors, 'email' => $email, 'emailCheck' => $emailCheck, 'password' => $password, 'passwordCheck' => $passwordCheck, 'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni));
        die;
    }

    if (!(nameIsOk($nombre)) || !(apellidoIsOk($apellido)) || !(dniIsOk($dni))) {
        $errors[] = "Alguno de los datos personales (nombre, apellido, dni) no es correcto";
        echo $template->render(array('errors' => $errors, 'email' => $email, 'emailCheck' => $emailCheck, 'password' => $password, 'passwordCheck' => $passwordCheck, 'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni));
        die;
    }

    signUpUser($email, $password, $nombre, $apellido, $dni);
    $reports[] = "Usuario creado correctamente!";
    echo $template->render(array('reports' => $reports));
    die;
}

echo $template->render(array());
