
<?php

 class CAMPEONATOCATEGORIA_MODEL
 {	
	var $id_catcamp;
 	var $id_campeonato; 
	var $id_categoria;
	var $n_plazas; 
 	var $bd; 

 	function __construct($id_catcamp, $id_campeonato, $id_categoria ){

		$this->id_catcamp = $id_catcamp;
 		$this->id_campeonato = $id_campeonato; 
		$this->id_categoria = $id_categoria;
		$this->n_plazas = $n_plazas; 

		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

  
	function ADD(){

		$sql = "INSERT INTO CAMPEONATO_CATEGORIA (
					id_campeonato,
					id_categoria,
					n_plazas
				)
				VALUES (
					'$this->id_campeonato',
					'$this->id_categoria',
					'$this->n_plazas'
				)";

		if (!$this->mysqli->query($sql))  
			return 'Error en la inserción';
		else
			return 'Inserción realizada con éxito';  

	}


	function EDIT() {
	
    	$sql = "SELECT * FROM  CAMPEONATO_CATEGORIA  WHERE (id_catcamp = '$this->id_catcamp')";
    	$result = $this->mysqli->query($sql);
    
    	if ($result->num_rows == 1) {	

		$sql = "UPDATE CAMPEONATO_CATEGORIA  SET
					id_campeonato = '$this->id_campeonato',
					id_categoria = '$this->id_categoria',
					n_plazas = '$this->n_plazas'

				WHERE (id_catcamp = '$this->id_catcamp')";
		
        	if (!($resultado = $this->mysqli->query($sql)))
				return 'Error en la modificación';
			else
				return 'Modificado correctamente';
		}
		else
    		return 'No existe en la base de datos';
	}
	

	function mostrarTodos() {
		
		$sql = "select * from CAMPEONATO_CATEGORIA";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}

	
	function DELETE() {	
		
		$sql = "SELECT * FROM  CAMPEONATO_CATEGORIA  WHERE  (id_catcamp = '$this->id_catcamp') ";
		
    	if (!$result = $this->mysqli->query($sql))
    		return 'No se ha podido conectar con la base de datos'; 
    
		if ($result->num_rows == 1){
		    
		    $sql = "DELETE FROM  CAMPEONATO_CATEGORIA  WHERE (id_camtcamp = '$this->id_catcamp')";
		    $this->mysqli->query($sql);
		    
		    return "Borrado correctamente";
		} 
		else
		    return "No existe";
	} 
	
	
	function consultarDatos() {	

		$sql = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE (id_catcamp = '$this->id_catcamp')";
		    
		if (!($resultado = $this->mysqli->query($sql)))
			return 'No existe en la base de datos'; 
		else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
	}
	
	//Si N_PLAZAS aumenta con cada inscripción, se podría usar esta función, si no, usar COUNT en parejas
	function getNParejas(){
		
		$sql = "SELECT N_PLAZAS FROM CAMPEONATO_CATEGORIA WHERE (id_catcamp = '$this->id_catcamp')";

		if (!($resultado = $this->mysqli->query($sql)))
			return 'No existe en la base de datos'; 
		else
			return $resultado;
	}


}

?>
