<?php

function ConectarBD() {
		
	    $mysqli = new mysqli("localhost", "padelweb", "padelweb", "abp35_padelweb"); //maquina, user, pass, bd

		if ($mysqli->connect_errno) {
			include '../Views/MESSAGE.php';
		   echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
		}
		// la función devuelve el manejador
		return $mysqli;
	}
?>