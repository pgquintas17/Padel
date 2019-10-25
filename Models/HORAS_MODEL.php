
<?php
    
class HORAS_MODEL
{
 	var $id; 
    var $hora;  
	var $bd; 
	

 	function __construct($id,$hora){
        $this->id = $id;
        $this->hora = $hora;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}


	function mostrarTodos() {
		
		$sql = "select * from HORAS";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}
	

	function consultarDatos() {	
		$sql = "SELECT * FROM HORAS WHERE (id = '$this->id')";
		    
		if (!($resultado = $this->mysqli->query($sql)))
			return 'No existe en la base de datos'; 
		else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
    }
 


}

?>