
<?php
    
class PartidoModel {
	
	var $id_partido;
	var $resultado; 
 	var $hora;
	var $fecha; 
	var $promocion;
    var $login1;
    var $login2;
    var $login3;
	var $login4;
	var $id_pista  
	var $bd; 
	

 	function __construct($id_partido,$resultado,$hora,$fecha,$promocion,$login1,$login2,$login3,$login4,$id_pista){
		$this->id_partido = $id_partido;
		$this->resultado = $resultado;
        $this->hora = $hora; 
		$this->fecha = $fecha;
		$this->promocion = $promocion; 
 		$this->login1 = $login1; 
        $this->login2 = $login2;
        $this->login3 = $login3;
		$this->login4 = $login4;
		$this->id_pista = $id_pista
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	
	function ADD() {
				
		$sql = "INSERT INTO PARTIDO (
					resultado
                    hora,
                    fecha,
					promocion,
                    login1,
                    login2,
                    login3,
                    login4,
					id_pista
				)
				VALUES (
					'$this->resultado',
                    '$this->hora',
                    '$this->fecha',
					'$this->promocion',
                    '$this->login1',
                    '$this->login2',
                    '$this->login3',
                    '$this->login4',
					'$this->id_pista'
				)";

		if (!$this->mysqli->query($sql))
			return 'Error en la inserción';
		else
			return 'Inserción realizada con éxito'; 
	}

	
	function EDIT() {
	
    	$sql = "SELECT * FROM PARTIDO  WHERE (id_partido = '$this->id_partido') ";
    	$result = $this->mysqli->query($sql);
    
    	if ($result->num_rows == 1) {	

			$sql = "UPDATE PARTIDO  SET
					resultado = '$this->resultado',
                    hora = '$this->hora',
                    fecha = '$this->fecha',
					promocion = '$this->promocion',
                    login1 = '$this->login1',
                    login2 = '$this->login2',
                    login3 = '$this->login3',
                    login4 = '$this->login4',
					id_pista = '$this->id_pista'

					WHERE ( id_partido = '$this->id_partido')";

    		if (!($resultado = $this->mysqli->query($sql)))
				return 'Error en la modificación';
			else 
				return 'Modificado correctamente';
		}
		else
			return 'No existe en la base de datos';
	}
	
		
	function DELETE() {	
			
		$sql = "SELECT * FROM PARTIDO  WHERE (id_partido = '$this->id_partido') ";
		$result = $this->mysqli->query($sql);

		if (!$result)
    		return 'No se ha podido conectar con la base de datos';
		    
		if ($result->num_rows == 1) {
		    	
		    $sql = "DELETE FROM PARTIDO WHERE (id_partido = '$this->id_partido')";
		    $this->mysqli->query($sql);
		        
		    return "Borrado correctamente";
		} 
		else
		    return "No existe";
	} 


	function mostrarTodos() {
		
		$sql = "select * from PARTIDO";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}
	

	function consultarDatos() {	

		$sql = "SELECT * FROM PARTIDO WHERE (id_partido = '$this->id_partido')";
		    
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
				case "promocion":
					$toret .= "(promocion LIKE '%$this->promocion%')";
					break;
				case "login1":
					$toret .= "((login1 LIKE '%$this->login1%')";
					$toret .= "| (login2 LIKE '%$this->login1%')";
					$toret .= "| (login3 LIKE '%$this->login1%')";
					$toret .= "| (login4 LIKE '%$this->login1%'))";
					break;
				case "login2":
					$toret .= "((login1 LIKE '%$this->login2%')";
					$toret .= " | (login2 LIKE '%$this->login2%')";
					$toret .= " | (login3 LIKE '%$this->login2%')";
					$toret .= " | (login4 LIKE '%$this->login2%'))";
					break;
				case "login3":
					$toret .= "((login1 LIKE '%$this->login3%')";
					$toret .= " | (login2 LIKE '%$this->login3%')";
					$toret .= " | (login3 LIKE '%$this->login3%')";
					$toret .= " | (login4 LIKE '%$this->login3%'))";
					break;
				case "login4":
					$toret .= "((login1 LIKE '%$this->login4%')";
					$toret .= " | (login2 LIKE '%$this->login4%')";
					$toret .= " | (login3 LIKE '%$this->login4%')";
					$toret .= " | (login4 LIKE '%$this->login4%'))";
					break;	
				case "id_pista":
					$toret .= "(id_pista LIKE '%$this->id_pista%')";
					break;
			}
			$toret .= " && ";
		}
		$toret = chop($toret," && ");
		$toret .= " )";

		$sql = "select * from PARTIDO where " . $toret;

    	if (!($resultado = $this->mysqli->query($sql))) {
			return 'Error en la consulta sobre la base de datos';
		}
    	else 
			return $resultado;
	}


}

?>