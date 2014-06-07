<?php

$ROOTPATH = getcwd();
$SERVER = 'http://localhost/cookbook/';
require_once $ROOTPATH.'/lib/Twig/Twig-1.14.2/lib/Twig/Autoloader.php';
require_once $ROOTPATH.'/model/conectarDB.php';
\Twig_Autoloader::register(); //carga Twig al sistema

