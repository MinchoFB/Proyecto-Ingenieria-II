<?php

function conection(){
    if(!($conexion = mysql_connect('localhost','root'))){
        echo "Error en conectar a la db"; die;
    }
    else {
         mysql_select_db("cookbookdb",$conexion) or die("No se pudo conectar a la db");
    }
    return $conexion;
}

    //$query = "select nombre from rol where id_rol=1";
    
    //$q = mysql_query($query, $conexion) or die(mysql_error());
    
    //$resultado = mysql_result($q, 0);
    //echo $resultado;

?>