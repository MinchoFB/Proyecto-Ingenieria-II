<?php

require_once 'model/conectarDB.php';

function getState($idEstado) {
    $conexion = conection();
    $query = "SELECT * FROM estado WHERE id_estado=$idEstado";
    $result = mysql_query($query, $conexion);
    $estado = mysql_fetch_assoc($result);
    return $estado;
}

function getStates() {
    $conexion = conection();
    $query = "SELECT * FROM estado";
    $result = mysql_query($query, $conexion);

    $estados = array();
    while ($row = mysql_fetch_assoc($result)) {
        $estados[] = $row;
    }
    return $estados;
}

function addState($nombre) {
    $conexion = conection();
    $query = mysql_query("INSERT INTO estado (nombre, activo) "
            . "VALUES ('$nombre', 1)");

    if (!$query) {
        die('Invalid query: ' . mysql_error());
    }
}

function deleteState($idEstado) {
    $conexion = conection();
    $query = "DELETE FROM estado WHERE id_estado = $idEstado";
    $result = mysql_query($query, $conexion);
    if (!$result) {
        return false;
    }
    return true;
}

function toggleState($idEstado) {
    $conexion = conection();
    $estado = getState($idEstado);
    if ($estado['activo'] == 0) {
        $query = "UPDATE estado SET activo = 1 WHERE id_estado = $idEstado";
    } else {
        $query = "UPDATE estado SET activo = 0 WHERE id_estado = $idEstado";
    }
    mysql_query($query, $conexion);
}

function updateState($idState, $nombre) {
    $conexion = conection();
    $query = "UPDATE estado SET nombre = '$nombre' WHERE id_estado = $idState";
    $result = mysql_query($query, $conexion);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
}

function stateExist($nombre) {
    $conexion = conection();
    $query = "SELECT nombre FROM estado WHERE nombre='$nombre'";
    $result = mysql_query($query, $conexion);
    $cant = mysql_num_rows($result);
    if ($cant < 1) {
        return false;
    }
    return true;
}