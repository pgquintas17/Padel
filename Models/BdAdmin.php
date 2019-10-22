<!--
  Autores: Paula González Quintas, Francisco Lopez Alonso, Juio Quinteiro Soto, Andrés Soto de la Concepción, Milagros Somoza Salinas
  Fecha: 10/12/2017
En este fichero se realiza la conexion sobre la base de datos
-->
<?php
// funcion ConectarBD()
// funcion de conexión única para toda la aplicación a la bd
// Es el único lugar donde se definen los parametros de conexión a la bd
function ConectarBD() //declaración de funcion
	{
		// se ejecuta la función de conexión mysqli y se recoge el manejador
	    $mysqli = new mysqli("localhost", "root", "root", "padelweb"); //maquina, user, pass, bd
		// si hay error en la conexión se muestra el mensaje de error
		if ($mysqli->connect_errno) {
			include '../Views/MESSAGE.php';
		   new MESSAGE("Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error, './index.php');
		}
		// la función devuelve el manejador
		return $mysqli;
	}
?>