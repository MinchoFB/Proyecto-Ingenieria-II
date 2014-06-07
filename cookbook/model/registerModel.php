<?php

require_once 'model/conectarDB.php';

function emailExist($email){
    $conexion = conection();
    $query = "SELECT email FROM usuario WHERE email='" . $email . "'";
    $result = mysql_query($query,$conexion);
    $cant = mysql_num_rows($result);
    if ($cant < 1){
        return false;
    }
    return true;
}

function signUpUser($email, $password, $nombre, $apellido, $dni){
    $conexion = conection();
    date_default_timezone_set("America/Argentina/Buenos_Aires");
    $fecha = date("Y-m-d");
    
    $idRolQuery = mysql_query ("SELECT id_rol FROM rol WHERE nombre='Normal'",$conexion);
    $idRol = mysql_fetch_array($idRolQuery);

    $queryInsertUser = mysql_query("INSERT INTO usuario (email, password, activo, fecha_alta, id_rol) "
            . "VALUES ('$email', '$password',1, '$fecha', '$idRol[id_rol]')");
    
    if (!$queryInsertUser){
        die('Invalid query: ' . mysql_error());
    }

    $idUser = mysql_insert_id();
    mysql_query("INSERT INTO persona (nombre, apellido, dni, id_usuario) "
            . "VALUES ('$nombre', '$apellido', '$dni', $idUser)", $conexion);
}


