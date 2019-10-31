<?php

session_start();

if(isset($_REQUEST['controller'])) {
    echo "hola";
}
else {
    require_once('Controllers/indexController.php');
    new indexController();
    exit;
}