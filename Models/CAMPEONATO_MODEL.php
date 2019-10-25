
<?php
    
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


	function ADD(){
			
		$sql = "INSERT INTO CAMPEONATO (
                	nombre,
                	fecha_inicio,
                	fecha_fin,
                	fecha_inicio_inscripciones,
                	fecha_fin_inscripciones
				)
				VALUES (
                	'$this->nombre',
                    '$this->fecha_inicio',
                    '$this->fecha_fin',
                    '$this->fecha_inicio_inscripciones',
                    '$this->fecha_fin_inscripciones'
				)";

		if (!$this->mysqli->query($sql))
			return 'Error en la inserción';
		else
			return 'Inserción realizada con éxito';
	}


	function EDIT() {

    	$sql = "SELECT * FROM CAMPEONATO  WHERE (id_campeonato = '$this->id_campeonato') ";
    	$result = $this->mysqli->query($sql);

    	if ($result->num_rows == 1) {

			$sql = "UPDATE CAMPEONATO  SET
                        nombre = '$this->nombre',
                        fecha_inicio = '$this->fecha_inicio',
                        fecha_fin = '$this->fecha_fin',
                        fecha_inicio_inscripciones = '$this->fecha_inicio_inscripciones',
                        fecha_fin_inscripciones = '$this->fecha_fin_inscripciones'

				WHERE (id_campeonato = '$this->id_campeonato')";

        	if (!($resultado = $this->mysqli->query($sql)))
				return 'Error en la modificación';
			else
				return 'Modificado correctamente';
    	}
    	else
			return 'No existe en la base de datos';
	}


	function mostrarTodos() {
		
		$sql = "select * from CAMPEONATO";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}


	function DELETE() {
		
		$sql = "SELECT * FROM CAMPEONATO  WHERE (id_campeonato = '$this->id_campeonato') ";
		$result = $this->mysqli->query($sql);

		if (!$result)
    		return 'No se ha podido conectar con la base de datos';
		
		if ($result->num_rows == 1) {
		    
		    $sql = "DELETE FROM CAMPEONATO WHERE (id_campeonato = '$this->id_campeonato')";
		    $this->mysqli->query($sql);
		    
		    return "Borrado correctamente";
		}
		else
		    return "No existe";
	}

	
	function consultarDatos() {	
		$sql = "SELECT * FROM CAMPEONATO WHERE (id_campeonato = '$this->id_campeonato')";
		    
		if (!($resultado = $this->mysqli->query($sql)))
			return 'No existe en la base de datos'; 
		else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
    }

}

?>