
<?php
/*  Fichero para el archivo del modelo de enfrentamiento  */
    
class ENFRENTAMIENTO_MODEL
{
 	var $id_enfrentamiento; 
 	var $resultado;
 	var $fecha; 
    var $hora;
    var $set1;
    var $set2;
    var $set3;
    var $pareja1;
	var $pareja2;  
	var $id_pista;
	var $bd; 
	



 	function __construct($id_enfrentamiento,$resultado,$fecha,$hora,$set1,$set2,$set3,$pareja1,$pareja2,$id_pista){
        $this->id_enfrentamiento = $id_enfrentamiento;
        $this->resultado = $resultado; 
		$this->fecha = $fecha; 
 		$this->hora = $hora; 
        $this->set1 = $set1;
        $this->set2 = $set2;
        $this->set3 = $set3; 
        $this->pareja1 = $pareja1;
		$this->pareja2 = $pareja2;
		$this->id_pista = $id_pista;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	//funcion ADD()
	//Mediante esta funcion añadiremos un nuevo ENFRENTAMIENTO a la bd

	function ADD(){


		if (($this->id_enfrentamiento <> '')){ // si el atributo clave de la entidad no esta vacio

		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM ENFRENTAMIENTO WHERE (id_enfrentamiento = '$this->id_enfrentamiento')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el id_enfrentamiento)
				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO ENFRENTAMIENTO (
					        id_enfrentamiento,
                            resultado,
                            fecha,
                            hora,
                            set1,
                            set2,
                            set3,
                            pareja1,
                            pareja2,
							id_pista
					    )
						VALUES (
						    '$this->id_enfrentamiento',
                            '$this->resultado',
                            '$this->fecha',
                            '$this->hora',
                            '$this->set1',
                            '$this->set2',
                            '$this->set3',
                            '$this->pareja1',
                            '$this->pareja2',
							'$this->id_pista'
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

        return 'Introduzca un valor'; // introduzca un valor para el enfrentamiento

	}

	}

	//funcion EDIT()
	//Mediante esta funcion editaremos un ENFRENTAMIENTO ya existente en la bd

	function EDIT()
{
	// se construye la sentencia de busqueda de la tupla en la bd
    $sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$this->id_enfrentamiento') ";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si el numero de filas es igual a uno es que lo encuentra

    if ($result->num_rows == 1)

    {	// se construye la sentencia de modificacion en base a los atributos de la clase

		$sql = "UPDATE ENFRENTAMIENTO  SET
						id_enfrentamiento = '$this->id_enfrentamiento',
                        resultado = '$this->resultado',
                        fecha = '$this->fecha',
                        hora = '$this->hora',
                        set1 = '$this->set1',
                        set2 = '$this->set2',
                        set3 = '$this->set3',
                        pareja1 = '$this->pareja1',
                        pareja2 = '$this->pareja2',
						id_pista = '$this->id_pista'

				WHERE ( id_enfrentamiento = '$this->id_enfrentamiento')";


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
	//Medante esta funcion buscaremos cualquier dato relativo a un ENFRENTAMIENTO


	function SEARCH()
{ 	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "select 
                id_enfrentamiento,
                resultado,
                fecha,
                hora,
                set1,
                set2,
                set3,
                pareja1,
				pareja2,
				id_pista

       	    from ENFRENTAMIENTO where

                    ( (id_enfrentamiento LIKE '%$this->id_enfrentamiento%') &&
                      (resultado LIKE '%$this->resultado%') &&
                      (fecha LIKE '%$this->fecha%') &&
                      (hora LIKE '%$this->hora%') &&
                      (set1 LIKE '%$this->set1%') &&
                      (set2 LIKE '%$this->set2%') &&
                      (set3 LIKE '%$this->set3%') &&
                      (pareja1 LIKE '%$this->pareja1%') &&
					  (pareja2 LIKE '%$this->pareja2%') &&
					  (id_pista LIKE '%$this->id_pista%'	)";

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
		    $sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$this->id_enfrentamiento') ";
		    // se ejecuta la query
		    $result = $this->mysqli->query($sql);
		    // si existe una tupla con ese valor de clave
		    if ($result->num_rows == 1)
		    {
		    	// se construye la sentencia sql de borrado
		        $sql = "DELETE FROM ENFRENTAMIENTO WHERE (id_enfrentamiento = '$this->id_enfrentamiento')";
		        // se ejecuta la query
		        $this->mysqli->query($sql);
		        // se devuelve el mensaje de borrado correcto
		    	return "Borrado correctamente";
		    } // si no existe el id_enfrentamiento a borrar se devuelve el mensaje de que no existe
		    else
		        return "No existe";
		} // fin metodo DELETE

		// funcion RellenaDatos()
		// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
		// en el atributo de la clase
		function RellenaDatos()
		{	// se construye la sentencia de busqueda de la tupla
		    $sql = "SELECT * FROM ENFRENTAMIENTO WHERE (id_enfrentamiento = '$this->id_enfrentamiento')";
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