<?php

class Utils {

    static function conectado(){
	    if (!isset($_SESSION['login']))
		    return false;
	    else
		    return true;
	}

	static function desconectar() {
		session_start();
		session_destroy();
		header('Location: index.php');
	}
	
	static function nivelPermiso($nivelRequerido){
		$login = $_SESSION['login'];
		require_once('Models/USUARIO_MODEL.php');
		$control = new USUARIO_MODEL($login,0,0,0,0,0,0,0,$nivelRequerido);
		$resultado = $control->comprobarNivelAcceso();
		if($resultado == true)
			return true;
		else
			return false;
	}
    
}
?>

