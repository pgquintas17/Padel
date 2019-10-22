
<?php
    
class RESERVA_MODEL
{
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

	
	

	function ADD(){


		if (($this->id_reserva <> '')){ 

		
        $sql = "SELECT * FROM RESERVA WHERE (id_reserva = '$this->id_reserva')";

		if (!$result = $this->mysqli->query($sql)){ 
			return 'No se ha podido conectar con la base de datos'; 
		}
		else { 
			if ($result->num_rows == 0){ 
				
				$sql = "INSERT RESERVA (
					        id_reserva,
                            id_pista,
                            hora,
                            fecha,
                            login
					    )
						VALUES (
						    '$this->id_reserva',
                            '$this->id_pista',
                            '$this->hora',
                            '$this->fecha',
                            '$this->login'
						)";


				if (!$this->mysqli->query($sql)) { 
					return 'Error en la inserción';
				}
				else{ 
					return 'Inserción realizada con éxito'; 
				}

			}
			else 
				return 'Ya existe en la base de datos'; 
		}
    }
    else{ 

        return 'Introduzca un valor'; 

	}

    }
    

	
	


	function SEARCH()
{ 	
    $sql = "select 
                id_reserva,
                id_pista,
                hora,
                fecha,
                login,
                id_grupo

       	    from RESERVA where

                    ( (id_reserva LIKE '%$this->id_reserva%') &&
                      (id_pista LIKE '%$this->id_pista%') &&
                      (hora LIKE '%$this->hora%') &&
                      (fecha LIKE '%$this->fecha%') &&
                      (login LIKE '%$this->login%') )";

    
    if (!($resultado = $this->mysqli->query($sql))){
		return 'Error en la consulta sobre la base de datos';
	}
    else{ 
		return $resultado;
	}
} 

function crearFiltros($filtros) {
	$toret = ""
	foreach($filtros as $filtro) {
		switch($filtro) {
			case 
		}
	}
}





		
		
		
		function DELETE()
		{	
		    $sql = "SELECT * FROM RESERVA  WHERE (id_reserva = '$this->id_reserva') ";
		    
		    $result = $this->mysqli->query($sql);
		    
		    if ($result->num_rows == 1)
		    {
		    	
		        $sql = "DELETE FROM RESERVA WHERE (id_reserva = '$this->id_reserva')";
		        
		        $this->mysqli->query($sql);
		        
		    	return "Borrado correctamente";
		    } 
		    else
		        return "No existe";
		} 

		
		
		
		function RellenaDatos()
		{	
		    $sql = "SELECT * FROM RESERVA WHERE (id_reserva = '$this->id_reserva')";
		    
		    if (!($resultado = $this->mysqli->query($sql))){
				return 'No existe en la base de datos'; 
			}
		    else{ 
				$result = $resultado->fetch_array();
				return $result;
			}
        } 
        

        function reservaUsuario()
        {
            $sql = "SELECT * FROM RESERVA WHERE (login = '$this->login')"; 
            $resultado = $this->mysqli->query($sql);
            return $resultado->fetch_array();
        } 

}

?>