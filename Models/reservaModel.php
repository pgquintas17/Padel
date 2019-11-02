
<?php
    
class ReservaModel {
 	var $id_reserva; 
 	var $id_pista;
 	var $hora; 
    var $fecha;
    var $login;  
	var $bd; 
	

 	function __construct($id_reserva,$id_pista,$hora,$fecha,$login){
        $this->id_reserva = $id_reserva;
        $this->id_pista = $id_pista; 
		$this->hora = $hora; 
 		$this->fecha = $fecha; 
		$this->login = $login;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	
	function ADD() {

		$sql = "INSERT RESERVA (
                    id_pista,
                    hora,
                    fecha,
                    login
				)
				VALUES (
                    '$this->id_pista',
                    '$this->hora',
                    '$this->fecha',
                    '$this->login'
				)";

		if (!$this->mysqli->query($sql)) 
			return 'Error en la inserción';
		else
			return 'Inserción realizada con éxito'; 

	}
	

	function crearFiltros($filtros) {
		$toret = "( ";
		int n = 
		foreach($filtros as $filtro) {
			switch($filtro) {
				case "id_pista":
					$toret .= "(id_pista LIKE '%$this->id_pista%')";
					break;
				case "hora":
					$toret .= "(hora LIKE '%$this->hora%')";
					break;
				case "fecha":
					$toret .= "(fecha LIKE '%$this->fecha%')";
					break;
				case "login":
					$toret .= "(login LIKE '%$this->login%')";
					break;
			}
			$toret .= " && ";
		}
		$toret = chop($toret," && ");
		$toret .= " )";

		$sql = "select * from RESERVA where " . $toret;

    	if (!($resultado = $this->mysqli->query($sql))) {
			return 'Error en la consulta sobre la base de datos';
		}
    	else 
			return $resultado;
	}


	function mostrarTodos() {
		
		$sql = "select * from RESERVA";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}

			
	function DELETE() {	

		$sql = "SELECT * FROM RESERVA  WHERE (id_reserva = '$this->id_reserva') ";    
		$result = $this->mysqli->query($sql);

		if (!$result)
    		return 'No se ha podido conectar con la base de datos';
		    
		if ($result->num_rows == 1) {
		    	
		    $sql = "DELETE FROM RESERVA WHERE (id_reserva = '$this->id_reserva')";    
		    $this->mysqli->query($sql);
		        
		    return "Borrado correctamente";
		} 
		else
		    return "No existe";
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

}

?>