
<?php
    
class PISTA_MODEL
{
 	var $id_pista; 
    var $estado;  
	var $bd; 
	

 	function __construct($id_pista,$estado){
        $this->id_pista = $id_pista;
        $this->estado = $estado;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	
	function ADD() {
				
		$sql = "INSERT INTO PISTA (
                    estado
				)
				VALUES (
                    '$this->estado'
				)";
		if (!$this->mysqli->query($sql)) 
			return 'Error en la inserción';
		else 
			return 'Inserción realizada con éxito';

	}

	
	function EDIT() {
	
    	$sql = "SELECT * FROM PISTA  WHERE (id_pista = '$this->id_pista') ";
    	$result = $this->mysqli->query($sql);
    
    	if ($result->num_rows == 1) {	

			$sql = "UPDATE PISTA  SET
                        estado = '$this->estado'

				WHERE ( id_pista = '$this->id_pista')";

	        if (!($resultado = $this->mysqli->query($sql))){
				return 'Error en la modificación';
			}
			else
				return 'Modificado correctamente';
    	}
    	else 
    		return 'No existe en la base de datos';
	}	
		
		
	function DELETE() {	

		$sql = "SELECT * FROM PISTA  WHERE (id_pista = '$this->id_pista') ";
		$result = $this->mysqli->query($sql);

		if (!$result)
    		return 'No se ha podido conectar con la base de datos';
		    
		if ($result->num_rows == 1) {
		    	
		    $sql = "DELETE FROM PISTA WHERE (id_pista = '$this->id_pista')";   
		    $this->mysqli->query($sql);
		        
		    return "Borrado correctamente";
		} 
		else
		    return "No existe";
	}
	
	
	function mostrarTodos() {
		
		$sql = "select * from PISTA";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}
	

	function consultarDatos() {	

		$sql = "SELECT * FROM PISTA WHERE (id_pista = '$this->id_pista')";
		    
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
				case "estado":
					$toret .= "(estado LIKE '%$this->estado%')";
					break;
			}
			$toret .= " && ";
		}
		$toret = chop($toret," && ");
		$toret .= " )";

		$sql = "select * from PISTA where " . $toret;

    	if (!($resultado = $this->mysqli->query($sql))) {
			return 'Error en la consulta sobre la base de datos';
		}
    	else 
			return $resultado;
	}


}

?>