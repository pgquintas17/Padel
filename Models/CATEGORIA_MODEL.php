
<?php
    
class CATEGORIA_MODEL
{
 	var $id_categoria; 
    var $sexo;
    var $nivel;  
	var $bd; 
	

 	function __construct($id_categoria,$sexo,$nivel){
        $this->id_categoria = $id_categoria;
        $this->sexo = $sexo; 
		$this->nivel = $nivel;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	
	function mostrarTodos() {
		
		$sql = "select * from CATEGORIA";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}
	
	
	function consultarDatos() {	

		$sql = "SELECT * FROM CATEGORIA WHERE (id_categoria = '$this->id_categoria')";
		    
		if (!($resultado = $this->mysqli->query($sql)))
			return 'No existe en la base de datos'; 
		else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
    }

}

?>