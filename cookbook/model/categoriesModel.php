<?php

require_once 'model/conectarDB.php';

function getCategory($idCategoria) {
    $conexion = conection();
    $query = "SELECT * FROM categoria WHERE id_categoria=$idCategoria";
    $result = mysql_query($query, $conexion);
    $categoria = mysql_fetch_assoc($result);
    return $categoria;
}

function getCategories() {
    $conexion = conection();
    $query = "SELECT * FROM categoria";
    $result = mysql_query($query, $conexion);

    $categorias = array();
    while ($row = mysql_fetch_assoc($result)) {
        $categorias[] = $row;
    }
    return $categorias;
}

function addCategorie($nombre) {
    $conexion = conection();
    $query = mysql_query("INSERT INTO categoria (nombre, activo) "
            . "VALUES ('$nombre', 1)");

    if (!$query) {
        die('Invalid query: ' . mysql_error());
    }
}

function deleteCategory($idCategoria) {
    $conexion = conection();
    $query = "DELETE FROM categoria WHERE id_categoria = $idCategoria";
    $result = mysql_query($query, $conexion);
    if (!$result) {
        return false;
    }
    return true;
}

function toggleCategory($idCategoria) {
    $conexion = conection();
    $categoria = getCategory($idCategoria);
    if ($categoria['activo'] == 0) {
        $query = "UPDATE categoria SET activo = 1 WHERE id_categoria = $idCategoria";
    } else {
        $query = "UPDATE categoria SET activo = 0 WHERE id_categoria = $idCategoria";
    }
    mysql_query($query, $conexion);
}

function updateCategory($idCategory, $nombre) {
    $conexion = conection();
    $query = "UPDATE categoria SET nombre = '$nombre' WHERE id_categoria = $idCategory";
    $result = mysql_query($query, $conexion);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
}

function categoryExist($nombre) {
    $conexion = conection();
    $query = "SELECT nombre FROM categoria WHERE nombre='$nombre'";
    $result = mysql_query($query, $conexion);
    $cant = mysql_num_rows($result);
    if ($cant < 1) {
        return false;
    }
    return true;
}