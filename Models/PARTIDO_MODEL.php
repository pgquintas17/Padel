
<?php
    
class PARTIDO_MODEL
{
	var $id_partido;
	var $resultado; 
 	var $hora;
	var $fecha; 
	var $promocion;
    var $login1;
    var $login2;
    var $login3;
    var $login4;  
	var $bd; 
	

 	function __construct($id_partido,$resultado,$hora,$fecha,$promocion,$login1,$login2,$login3,$login4){
		$this->id_partido = $id_partido;
		$this->resultado = $resultado;
        $this->hora = $hora; 
		$this->fecha = $fecha;
		$this->promocion = $promocion; 
 		$this->login1 = $login1; 
        $this->login2 = $login2;
        $this->login3 = $login3;
        $this->login4 = $login4;
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
                    login4
				)
				VALUES (
					'$this->resultado',
                    '$this->hora',
                    '$this->fecha',
					'$this->promocion',
                    '$this->login1',
                    '$this->login2',
                    '$this->login3',
                    '$this->login4'
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
                    login4 = '$this->login4'

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


}

?>