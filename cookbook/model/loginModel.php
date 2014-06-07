<?php

require_once 'model/conectarDB.php';

function getUser($email){
    $conexion = conection();
//    $query = "SELECT * FROM usuario WHERE email='" . $email . "'" ;
    $query = "SELECT usuario.*,rol.nombre as nombreRol, persona.nombre as nombrePersona "
            . "FROM usuario INNER JOIN rol ON usuario.id_rol=rol.id_rol "
                            . "INNER JOIN persona ON usuario.id_usuario=persona.id_usuario "
            . "WHERE email='" . $email . "'";
//    $q = mysql_query($query,$conexion) or die(mysql_error());
    $q = mysql_query($query,$conexion);
    $user = mysql_fetch_array($q);
//    var_dump($row);die;
//    $user = mysql_result($q,0);

    return $user;
}

