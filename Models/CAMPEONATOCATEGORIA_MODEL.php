
<?php
/*  Fichero para el archivo del modelo de asignar categorías a campeonatos */

 class CAMPEONATOCATEGORIA_MODEL
 {
 	var $id_campeonato; 
 	var $id_categoria; 
 	var $bd; 

 	function __construct( $id_campeonato, $id_categoria ){

 		$this->id_campeonato = $id_campeonato; 
 		$this->id_categoria = $id_categoria; 

		include_once '../Models/BdAdmin.php'; // incluimos la función de acceso a la bd
		$this->mysqli = ConectarBD();  //almacenamos la conexión con la bd
	}

  //funcion ADD()
  //Mediante esta función añadiremos una CATEGORIA a un CAMPEONATO 

	function ADD(){


		if (($this->id_campeonato <> '') || ($this->id_categoria <> '')){ // si el atributo clave de la entidad no esta vacio

		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE (id_campeonato = '$this->id_campeonato') && (id_categoria = '$this->id_categoria') ";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio
				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO CAMPEONATO_CATEGORIA (
					id_campeonato,
					id_categoria
					)
						VALUES (
						'$this->id_campeonato',
						'$this->id_categoria'
						)";


				if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
					return 'Error en la inserción';
				}
				else{ //si no da error en la insercion devolvemos mensaje de exito
					return 'Inserción realizada con éxito'; //operacion de insertado correcta
				}

			}
			else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
				return 'Ya existe en la base de datos'; // ya existe
		}
    }
    else{ // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje

        return 'Introduzca un valor'; // introduzca un valor para la categoria

	}

	}

  //funcion EDIT()
  //Mediante esta función editaremos las categorias que pertenecen a un campeonato


	function EDIT()
{
	// se construye la sentencia de busqueda de la tupla en la bd
    $sql = "SELECT * FROM  CAMPEONATO_CATEGORIA  WHERE ((id_campeonato = '$this->id_campeonato') && (id_categoria = '$this->id_categoria'))";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si el numero de filas es igual a uno es que lo encuentra

    if ($result->num_rows == 1)

    {	// se construye la sentencia de modificacion en base a los atributos de la clase

		$sql = "UPDATE CAMPEONATO_CATEGORIA  SET
						id_campeonato = '$this->id_campeonato',
						id_categoria = '$this->id_categoria'


				WHERE ((id_campeonato = '$this->id_campeonato') && (id_categoria = '$this->id_categoria'))";


		// si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
			return 'Error en la modificación';
		}
		else{ // si no hay problemas con la modificación se indica que se ha modificado
			return 'Modificado correctamente';
		}
    }

    else{ // si no se encuentra la tupla se manda el mensaje de que no existe la tupla

    	return 'No existe en la base de datos';
    }
}


  //funcion SEARCH()
  //Mediante esta funcion buscaremos los datos relativos a un categoria de un campeonato

	function SEARCH()
{ 	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "select id_campeonato,
    				id_categoria

       	    from  CAMPEONATO_CATEGORIA where

    				((id_campeonato LIKE '%$this->id_campeonato%') &&
    				(id_categoria LIKE '%$this->id_categoria%'))";

    // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
		return 'Error en la consulta sobre la base de datos';
	}
    else{ // si la busqueda es correcta devolvemos el recordset resultado
		return $resultado;
	}
} // fin metodo SEARCH





	// funcion DELETE()
	// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
	// se manda un mensaje de que ese valor de clave no existe
	function DELETE()
	{	// se construye la sentencia sql de busqueda con los atributos de la clase
		$sql = "SELECT * FROM  CAMPEONATO_CATEGORIA  WHERE  ((id_campeonato = '$this->id_campeonato' ) && (id_categoria = '$this->id_categoria')) ";
		// se ejecuta la query
    if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
    		return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
    	}
    // si existe una tupla con ese valor de clave
		if ($result->num_rows == 1)
		{
		    // se construye la sentencia sql de borrado
		    $sql = "DELETE FROM  CAMPEONATO_CATEGORIA  WHERE ((id_campeonato = '$this->id_campeonato') && (id_categoria = '$this->id_categoria'))";
		    // se ejecuta la query
		    $this->mysqli->query($sql);
		    // se devuelve el mensaje de borrado correcto
		    	return "Borrado correctamente";
		} // si no existe el id_campeonato a borrar se devuelve el mensaje de que no existe
		else
		    return "No existe";
    } // fin metodo DELETE
        

  // funcion DELETE()
  // comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
  // se manda un mensaje de que ese valor de clave no existe
  function DELETECATEGORIA()
  {	// se construye la sentencia sql de busqueda con los atributos de la clase
      $sql = "SELECT * FROM  CAMPEONATO_CATEGORIA  WHERE (id_categoria = '$this->id_categoria') ";
      // se ejecuta la query
      if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
        return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
      }
     // si existe una tupla con ese valor de clave
      if ($result->num_rows >= 1)
      {
        // se construye la sentencia sql de borrado
          $sql = "DELETE FROM  CAMPEONATO_CATEGORIA  WHERE  (id_categoria = '$this->id_categoria')";
          // se ejecuta la query
          $this->mysqli->query($sql);
          // se devuelve el mensaje de borrado correcto
          return "Borrado correctamente";
      } // si no existe el id_categoria a borrar se devuelve el mensaje de que no existe
      else
          return "No existe";
  } // fin metodo DELETE


		// funcion RellenaDatos()
		// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
		// en el atributo de la clase
		function RellenaDatos()
		{	// se construye la sentencia de busqueda de la tupla
		    $sql = "SELECT * FROM CAMPEONATO_CATEGORIA   WHERE  ((id_campeonato = '$this->id_campeonato') && (id_categoria = '$this->id_categoria'))";
		    // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		    if (!($resultado = $this->mysqli->query($sql))){
				return 'No existe en la base de datos'; //
			}
		    else{ // si existe se devuelve la tupla resultado
				$result = $resultado->fetch_array();
				return $result;
			}
		} // fin del metodo RellenaDatos()




}

?>
