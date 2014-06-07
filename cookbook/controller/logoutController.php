<?php


chdir('..');
require_once 'index.php';
require_once 'controller/twigLoader.php';
session_start();
$_SESSION = array();
session_destroy();
header( 'Location: homeController.php' ) ;