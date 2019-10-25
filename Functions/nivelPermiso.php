<?php

    function nivelPermiso($login, $nivelRequerido){

        $login = $_SESSION['login'];

        include '../Models/USUARIO_MODEL.php';
        $control = new USUARIO_MODEL($login,0,0,0,0,0,0,0,$nivelRequerido);
        $resultado = $control->comprobarNivelAcceso();

        if($resultado == true)
            return true;
        else
            return false;
    }
?>