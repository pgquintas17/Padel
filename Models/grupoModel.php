<?php
    
class GrupoModel {

 	var $id_grupo; 
    var $id_catcamp;
	var $bd; 
	

 	function __construct($id_grupo,$id_catcamp){
        $this->id_grupo = $id_grupo;
        $this->id_catcamp = $id_catcamp;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

		
	function ADD(){

		$sql = "INSERT INTO GRUPO (
                    id_catcamp
				)
				VALUES (
                    '$this->id_catcamp'
				)";
		if (!$this->mysqli->query($sql))
			return 'Error en la inserción';
		else 
			return 'Inserción realizada con éxito'; 
	}
	
	
	function EDIT() {
	
    	$sql = "SELECT * FROM GRUPO  WHERE (id_grupo = '$this->id_grupo') ";
   		$result = $this->mysqli->query($sql);
    
    	if ($result->num_rows == 1) {	

			$sql = "UPDATE GRUPO  SET
                        id_catcamp = '$this->id_catcamp'

					WHERE ( id_grupo = '$this->id_grupo')";

        	if (!($resultado = $this->mysqli->query($sql)))
				return 'Error en la modificación';
		else 
			return 'Modificado correctamente';
    	}
		else
			return 'No existe en la base de datos';
	}

		
	function DELETE() {	
		
		$sql = "SELECT * FROM GRUPO  WHERE (id_grupo = '$this->id_grupo') ";
		$result = $this->mysqli->query($sql);

		if (!$result)
    		return 'No se ha podido conectar con la base de datos';
		    
		if ($result->num_rows == 1) {
		    	
		    $sql = "DELETE FROM GRUPO WHERE (id_grupo = '$this->id_grupo')";
		    $this->mysqli->query($sql);
		        
		    return "Borrado correctamente";
		} 
		else
		    return "No existe";
	} 


	function mostrarTodos() {
		
		$sql = "SELECT * FROM RESERVA";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}


	function consultarDatos() {

		$sql = "SELECT * FROM RESERVA WHERE (id_reserva = '$this->id_reserva')";
		    
		if (!($resultado = $this->mysqli->query($sql)))
			return 'No existe en la base de datos'; 
		else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
	}
	
	
	function crearFiltros($filtros) {
		$toret = "( ";
		int n = 
		foreach($filtros as $filtro) {
			switch($filtro) {
				case "id_catcamp":
					$toret .= "(id_catcamp LIKE '%$this->id_catcamp%')";
					break;
			}
			$toret .= " && ";
		}
		$toret = chop($toret," && ");
		$toret .= " )";

		$sql = "SELECT * FROM GRUPO WHERE " . $toret;

    	if (!($resultado = $this->mysqli->query($sql))) {
			return 'Error en la consulta sobre la base de datos';
		}
    	else 
			return $resultado;
	}


}

?>