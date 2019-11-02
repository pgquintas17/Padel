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
		require_once('Models/usuarioModel.php');
		$control = new UsuarioModel();
		$control->setLogin($login);
		require_once('Mappers/usuarioMapper.php');
		$controlMapper = new UsuarioMapper();
		$resultado = $controlMapper->comprobarNivelAcceso($control,$nivelRequerido);
		if($resultado == true)
			return true;
		else
			return false;
	}
    
}
?>

