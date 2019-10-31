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
    
}
?>

