
<?php
/*  Fichero para el archivo del modelo de campeonato  */
    
class CAMPEONATO_MODEL
{
 	var $id_campeonato; 
 	var $nombre;
 	var $fecha_inicio; 
    var $fecha_fin;
    var $fecha_inicio_inscripciones;
 	var $fecha_fin_inscripciones;  
	var $bd; 
	



 	function __construct($id_campeonato,$nombre,$fecha_inicio,$fecha_fin,$fecha_inicio_inscripciones,$fecha_fin_inscripciones){
        $this->id_campeonato = $id_campeonato;
        $this->nombre = $nombre; 
		$this->fecha_inicio = $fecha_inicio; 
 		$this->fecha_fin = $fecha_fin; 
		$this->fecha_inicio_inscripciones = $fecha_inicio_inscripciones; 
        $this->fecha_fin_inscripciones = $fecha_fin_inscripciones;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	//funcion ADD()
	//Mediante esta funcion añadiremos un nuevo CAMPEONATO a la bd

	function ADD(){


		if (($this->id_campeonato <> '')){ // si el atributo clave de la entidad no esta vacio

		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM CAMPEONATO WHERE (id_campeonato = '$this->id_campeonato')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el id_campeonato)
				//construimos la sentencia sql de inserción en la bd
				$sql = "INSERT INTO CAMPEONATO (
					        id_campeonato,
                            nombre,
                            fecha_inicio,
                            fecha_fin,
                            fecha_inicio_inscripciones,
                            fecha_fin_inscripciones
					    )
						VALUES (
						    '$this->id_campeonato',
                            '$this->nombre',
                            '$this->fecha_inicio',
                            '$this->fecha_fin',
                            '$this->fecha_inicio_inscripciones',
                            '$this->fecha_fin_inscripciones'
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

        return 'Introduzca un valor'; // introduzca un valor para el campeonato

	}

	}

	//funcion EDIT()
	//Mediante esta funcion editaremos un CAMPEONATO ya existente en la bd

	function EDIT()
{
	// se construye la sentencia de busqueda de la tupla en la bd
    $sql = "SELECT * FROM CAMPEONATO  WHERE (id_campeonato = '$this->id_campeonato') ";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si el numero de filas es igual a uno es que lo encuentra

    if ($result->num_rows == 1)

    {	// se construye la sentencia de modificacion en base a los atributos de la clase

		$sql = "UPDATE CAMPEONATO  SET
						id_campeonato = '$this->id_campeonato',
                        nombre = '$this->nombre',
                        fecha_inicio = '$this->fecha_inicio',
                        fecha_fin = '$this->fecha_fin',
                        fecha_inicio_inscripciones = '$this->fecha_inicio_inscripciones',
                        fecha_fin_inscripciones = '$this->fecha_fin_inscripciones'

				WHERE ( id_campeonato = '$this->id_campeonato')";


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
	//Medante esta funcion buscaremos cualquier dato relativo a un CAMPEONATO


	function SEARCH()
{ 	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "select 
                id_campeonato,
                nombre,
                fecha_inicio,
                fecha_fin,
                fecha_inicio_inscripciones,
                fecha_fin_inscripciones

       	    from CAMPEONATO where

                    ( (id_campeonato LIKE '%$this->id_campeonato%') &&
                      (nombre LIKE '%$this->nombre%') &&
                      (fecha_inicio LIKE '%$this->fecha_inicio%') &&
                      (fecha_fin LIKE '%$this->fecha_fin%') &&
                      (fecha_inicio_inscripciones LIKE '%$this->fecha_inicio_inscripciones%') &&
                      (fecha_fin_inscripciones LIKE '%$this->fecha_fin_inscripciones%')	)";

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
		    $sql = "SELECT * FROM CAMPEONATO  WHERE (id_campeonato = '$this->id_campeonato') ";
		    // se ejecuta la query
		    $result = $this->mysqli->query($sql);
		    // si existe una tupla con ese valor de clave
		    if ($result->num_rows == 1)
		    {
		    	// se construye la sentencia sql de borrado
		        $sql = "DELETE FROM CAMPEONATO WHERE (id_campeonato = '$this->id_campeonato')";
		        // se ejecuta la query
		        $this->mysqli->query($sql);
		        // se devuelve el mensaje de borrado correcto
		    	return "Borrado correctamente";
		    } // si no existe el id_campeonato a borrar se devuelve el mensaje de que no existe
		    else
		        return "No existe";
		} // fin metodo DELETE

		// funcion RellenaDatos()
		// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
		// en el atributo de la clase
		function RellenaDatos()
		{	// se construye la sentencia de busqueda de la tupla
		    $sql = "SELECT * FROM CAMPEONATO WHERE (id_campeonato = '$this->id_campeonato')";
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