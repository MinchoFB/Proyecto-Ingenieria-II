<?php

chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
require_once 'model/loginModel.php';
session_start();

$reports = array();
$twig = getTwigEnviroment();
$template = $twig->loadTemplate('login.html.twig');

function validateEmptyField($email, $password) {
    $result = true;
    if ($email == '' || $password == '') {
        $result = false;
    }
    return $result;
}

function emailAndPassMatches($password, $user){
    if($password != $user['password']){
        return false;
    }
    return true;
}

if ($_POST) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    // procesar formulario
    if (!validateEmptyField($email, $password)) {
        $reports[] = "Falta completar alguno de los campos";
        echo $template->render(array('reports' => $reports));
        die;
    }
    $user = getUser($email);
//    var_dump($user);
    if (is_null($user)) {
        $reports[] = "El email o contraseña ingresada no coinciden";
        echo $template->render(array('reports' => $reports));
        die;
    }
    if (!emailAndPassMatches($password, $user)) {
        $reports[] = "El email o contraseña ingresada no coinciden ";
        echo $template->render(array('reports' => $reports));
        die;
    }
    // guardar usuario en $_SESSION
    $_SESSION['user'] = $user;
    
    if ($user['nombreRol'] == "Admin" ){
        header( 'Location: adminUserController.php' ) ;
    }
    if ($user['nombreRol'] == "Normal" ){
        header( 'Location: normalUserController.php' ) ;
    }
    
}

echo $template->render(array());

