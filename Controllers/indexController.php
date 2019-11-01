<?php

	require_once('Services/Utils.php');
	require_once('Views/indexView.php');

class IndexController {

	function __construct(){
		$usuario = null;

		if (Utils::conectado()) {
			$usuario = $_SESSION['login'];
		}
		
		(new indexView($usuario))->render();
	}
}

?>