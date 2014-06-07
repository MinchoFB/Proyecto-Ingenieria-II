<?php

require_once 'model/conectarDB.php';

function getAutor($idAutor) {
    $conexion = conection();
    $query = "SELECT * FROM autor WHERE id_autor=$idAutor";
    $result = mysql_query($query, $conexion);
    $autor = mysql_fetch_assoc($result);
    return $autor;
}

function getAutors() {
    $conexion = conection();
    $query = "SELECT * FROM autor";
    $result = mysql_query($query, $conexion);

    $autors = array();
    while ($row = mysql_fetch_assoc($result)) {
        $autors[] = $row;
    }
    return $autors;
}

function addAutor($nombre) {
    $conexion = conection();
    $query = mysql_query("INSERT INTO autor (nombre, activo) "
            . "VALUES ('$nombre', 1)");

    if (!$query) {
        die('Invalid query: ' . mysql_error());
    }
}

function deleteAutor($idAutor) {
    $conexion = conection();
    $query = "DELETE FROM autor WHERE id_autor = $idAutor";
    $result = mysql_query($query, $conexion);
    if (!$result) {
        return false;
    }
    return true;
}

function toggleAutor($idAutor) {
    $conexion = conection();
    $autor = getAutor($idAutor);
    if ($autor['activo'] == 0) {
        $query = "UPDATE autor SET activo = 1 WHERE id_autor = $idAutor";
    } else {
        $query = "UPDATE autor SET activo = 0 WHERE id_autor = $idAutor";
    }
    mysql_query($query, $conexion);
}

function updateAutor($idAutor, $nombre) {
    $conexion = conection();
    $query = "UPDATE autor SET nombre = '$nombre' WHERE id_autor = $idAutor";
    $result = mysql_query($query, $conexion);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
}

function autorExist($nombre) {
    $conexion = conection();
    $query = "SELECT nombre FROM autor WHERE nombre='$nombre'";
    $result = mysql_query($query, $conexion);
    $cant = mysql_num_rows($result);
    if ($cant < 1) {
        return false;
    }
    return true;
}