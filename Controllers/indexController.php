<?php

	require_once('Functions/Utils.php');
	require_once('Views/indexView.php');

class indexController {

	function __construct(){
		$usuario = null;

		if (Utils::conectado()) {
			// if (!$_REQUEST['']) {
			// 	header('Location: ../');
			// 	session_destroy();
			// }
			$usuario = $_SESSION['login'];
		}
		
		(new indexView($usuario))->render();
	}
}

?>