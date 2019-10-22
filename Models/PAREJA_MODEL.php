
<?php
/*  Fichero para el archivo del modelo de pareja  */
    
class PAREJA_MODEL
{
 	var $id_pareja; 
 	var $nombre_pareja;
 	var $capitan; 
    var $miembro;
    var $id_categoria;
 	var $id_grupo;  
	var $bd; 
	



 	function __construct($id_pareja,$nombre_pareja,$capitan,$miembro,$id_categoria,$id_grupo){
        $this->id_pareja = $id_pareja;
        $this->nombre_pareja = $nombre_pareja; 
		$this->capitan = $capitan; 
 		$this->miembro = $miembro; 
		$this->id_categoria = $id_categoria; 
        $this->id_grupo = $id_grupo;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	//funcion ADD()
	//Mediante esta funcion añadiremos un nuevo PAREJA a la bd

	function ADD(){


		if (($this->id_pareja <> '')){ // si el atributo clave de la entidad no esta vacio

		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM PAREJA WHERE (id_pareja = '$this->id_pareja')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el id_pareja)
				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO PAREJA (
					        id_pareja,
                            nombre_pareja,
                            capitan,
                            miembro,
                            id_categoria,
                            id_grupo
					    )
						VALUES (
						    '$this->id_pareja',
                            '$this->nombre_pareja',
                            '$this->capitan',
                            '$this->miembro',
                            '$this->id_categoria',
                            '$this->id_grupo'
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

        return 'Introduzca un valor'; // introduzca un valor para el pareja

	}

	}

	//funcion EDIT()
	//Mediante esta funcion editaremos un PAREJA ya existente en la bd

	function EDIT()
{
	// se construye la sentencia de busqueda de la tupla en la bd
    $sql = "SELECT * FROM PAREJA  WHERE (id_pareja = '$this->id_pareja') ";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si el numero de filas es igual a uno es que lo encuentra

    if ($result->num_rows == 1)

    {	// se construye la sentencia de modificacion en base a los atributos de la clase

		$sql = "UPDATE PAREJA  SET
						id_pareja = '$this->id_pareja',
                        nombre_pareja = '$this->nombre_pareja',
                        capitan = '$this->capitan',
                        miembro = '$this->miembro',
                        id_categoria = '$this->id_categoria',
                        id_grupo = '$this->id_grupo'

				WHERE ( id_pareja = '$this->id_pareja')";


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
	//Medante esta funcion buscaremos cualquier dato relativo a un PAREJA


	function SEARCH()
{ 	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "select 
                id_pareja,
                nombre_pareja,
                capitan,
                miembro,
                id_categoria,
                id_grupo

       	    from PAREJA where

                    ( (id_pareja LIKE '%$this->id_pareja%') &&
                      (nombre_pareja LIKE '%$this->nombre_pareja%') &&
                      (capitan LIKE '%$this->capitan%') &&
                      (miembro LIKE '%$this->miembro%') &&
                      (id_categoria LIKE '%$this->id_categoria%') &&
                      (id_grupo LIKE '%$this->id_grupo%')	)";

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
		    $sql = "SELECT * FROM PAREJA  WHERE (id_pareja = '$this->id_pareja') ";
		    // se ejecuta la query
		    $result = $this->mysqli->query($sql);
		    // si existe una tupla con ese valor de clave
		    if ($result->num_rows == 1)
		    {
		    	// se construye la sentencia sql de borrado
		        $sql = "DELETE FROM PAREJA WHERE (id_pareja = '$this->id_pareja')";
		        // se ejecuta la query
		        $this->mysqli->query($sql);
		        // se devuelve el mensaje de borrado correcto
		    	return "Borrado correctamente";
		    } // si no existe el id_pareja a borrar se devuelve el mensaje de que no existe
		    else
		        return "No existe";
		} // fin metodo DELETE

		// funcion RellenaDatos()
		// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
		// en el atributo de la clase
		function RellenaDatos()
		{	// se construye la sentencia de busqueda de la tupla
		    $sql = "SELECT * FROM PAREJA WHERE (id_pareja = '$this->id_pareja')";
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