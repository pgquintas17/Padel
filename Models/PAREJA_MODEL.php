
<?php
    
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

	
	function ADD(){
				
		$sql = "INSERT INTO PAREJA (
                    nombre_pareja,
                    capitan,
                    miembro,
                    id_categoria,
                    id_grupo
				)
				VALUES (
                    '$this->nombre_pareja',
                    '$this->capitan',
                    '$this->miembro',
                    '$this->id_categoria',
                    '$this->id_grupo'
				)";

		if (!$this->mysqli->query($sql))
			return 'Error en la inserción';
		else
			return 'Inserción realizada con éxito'; 

	}

	
	function EDIT() {
	
    	$sql = "SELECT * FROM PAREJA  WHERE (id_pareja = '$this->id_pareja') ";
    	$result = $this->mysqli->query($sql);
    
    	if ($result->num_rows == 1) {	

			$sql = "UPDATE PAREJA  SET
                		nombre_pareja = '$this->nombre_pareja',
                    	capitan = '$this->capitan',
                    	miembro = '$this->miembro',
                    	id_categoria = '$this->id_categoria',
                    	id_grupo = '$this->id_grupo'

					WHERE (id_pareja = '$this->id_pareja')";


        	if (!($resultado = $this->mysqli->query($sql)))
				return 'Error en la modificación';
			else 
				return 'Modificado correctamente';
    	}
		else 
    		return 'No existe en la base de datos';
	}
		
		
	function DELETE() {	
		
		$sql = "SELECT * FROM PAREJA  WHERE (id_pareja = '$this->id_pareja') ";
		$result = $this->mysqli->query($sql);

		if (!$result)
    		return 'No se ha podido conectar con la base de datos';
		    
		if ($result->num_rows == 1) {
		    	
		    $sql = "DELETE FROM PAREJA WHERE (id_pareja = '$this->id_pareja')";
		    $this->mysqli->query($sql);
		        
		    return "Borrado correctamente";
		} 
		else
		    return "No existe";
	} 
	
	
	function mostrarTodos() {
		
		$sql = "select * from PAREJA";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}


	function consultarDatos() {
			
		$sql = "SELECT * FROM PAREJA WHERE (id_pareja = '$this->id_pareja')";
		    
		if (!($resultado = $this->mysqli->query($sql)))
			return 'No existe en la base de datos'; 
		else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
    }

}

?>