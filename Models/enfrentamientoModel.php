
<?php
    
class EnfrentamientoModel {

 	var $id_enfrentamiento; 
 	var $resultado;
 	var $fecha; 
    var $hora;
    var $set1;
    var $set2;
    var $set3;
    var $pareja1;
	var $pareja2;  
	var $id_reserva;
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


	function ADD(){

		$sql = "INSERT INTO ENFRENTAMIENTO (
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

		if (!$this->mysqli->query($sql)) 
			return 'Error en la inserción';
		else 
			return 'Inserción realizada con éxito';   
	}

	
	function EDIT() {
	
    	$sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$this->id_enfrentamiento') ";
    	$result = $this->mysqli->query($sql);

    	if ($result->num_rows == 1) {	

			$sql = "UPDATE ENFRENTAMIENTO  SET
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

        	if (!($resultado = $this->mysqli->query($sql)))
				return 'Error en la modificación';
			else 
				return 'Modificado correctamente';
    	}
		else 
			return 'No existe en la base de datos';
	}

	
	function DELETE() {	
		
		$sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$this->id_enfrentamiento') ";    
		$result = $this->mysqli->query($sql);

		if (!$result)
    		return 'No se ha podido conectar con la base de datos';
		    
		if ($result->num_rows == 1) {
		    	
		    $sql = "DELETE FROM ENFRENTAMIENTO WHERE (id_enfrentamiento = '$this->id_enfrentamiento')";    
		    $this->mysqli->query($sql);
		        
		    return "Borrado correctamente";
		} 
		else
		    return "No existe";
	} 


	function mostrarTodos() {
		
		$sql = "SELECT * FROM ENFRENTAMIENTO";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}


	function consultarDatos() {	

		$sql = "SELECT * FROM ENFRENTAMIENTO WHERE (id_enfrentamiento = '$this->id_enfrentamiento')";
		    
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
				case "fecha":
					$toret .= "(fecha LIKE '%$this->fecha%')";
					break;
				case "pareja1":
					$toret .= "((pareja1 LIKE '%$this->pareja1%')";
					$toret .= " | (pareja2 LIKE '%$this->pareja1%'))";
					break;
				case "pareja2":
					$toret .= "((pareja1 LIKE '%$this->pareja2%')";
					$toret .= " | (pareja2 LIKE '%$this->pareja2%'))";
					break;
				case "id_pista":
					$toret .= "(id_pista LIKE '%$this->id_pista%')";
					break;
			}
			$toret .= " && ";
		}
		$toret = chop($toret," && ");
		$toret .= " )";

		$sql = "SELECT * FROM ENFRENTAMIENTO WHERE " . $toret;

    	if (!($resultado = $this->mysqli->query($sql))) {
			return 'Error en la consulta sobre la base de datos';
		}
    	else 
			return $resultado;
	}



}

?>