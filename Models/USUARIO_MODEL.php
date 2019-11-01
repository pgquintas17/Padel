
<?php
    
class USUARIO_MODEL
{
 	var $login; 
 	var $nombre;
 	var $apellidos; 
    var $password;
    var $fecha_nac;
 	var $telefono; 
    var $email; 
    var $genero; 
    var $permiso; 
	var $bd; 
	
	
 	function __construct($login,$nombre,$apellidos,$password,$fecha_nac,$telefono,$email,$genero,$permiso){
        $this->login = $login;
        $this->nombre = $nombre; 
		$this->apellidos = $apellidos; 
 		$this->password = $password; 
		$this->fecha_nac = $fecha_nac; 
        $this->telefono = $telefono;  
		$this->email = $email; 
        $this->genero = $genero;
        $this->permiso = $permiso; 
		include_once 'Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	
	function ADD(){

		if (($this->login <> '')){ 

        	$sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";

			if (!$result = $this->mysqli->query($sql)) 
				return 'No se ha podido conectar con la base de datos'; 
			else { 
				if ($result->num_rows == 0){ 
				
					$sql = "INSERT INTO USUARIO (
					        login,
                            nombre,
                            apellidos,
                            password,
                            fecha_nac,
                            telefono,
                            email,
                            genero,
                            permiso
					    )
						VALUES (
						    '$this->login',
                            '$this->nombre',
                            '$this->apellidos',
                            '$this->password',
                            '$this->fecha_nac',
                            '$this->telefono',
                            '$this->email',
                            '$this->genero',
                            '$this->permiso'
						)";

					if (!$this->mysqli->query($sql)) 
						return 'Error en la inserción';
					else 
						return 'Inserción realizada con éxito'; 
				}
				else 
					return 'Ya existe en la base de datos'; 
			}
    	}
    	else 
			return 'Introduzca un valor'; 
	}


	function EDIT() {
	
    	$sql = "SELECT * FROM USUARIO  WHERE (login = '$this->login') ";
    	$result = $this->mysqli->query($sql);
    
    	if ($result->num_rows == 1) {	

			$sql = "UPDATE USUARIO  SET
						login = '$this->login',
                        nombre = '$this->nombre',
                        apellidos = '$this->apellidos',
                        password = '$this->password',
                        fecha_nac = '$this->fecha_nac',
                        telefono = '$this->telefono',
                        email = '$this->email',
                        genero = '$this->genero',
                        permiso = '$this->permiso'

					WHERE ( login = '$this->login')";

        	if (!($resultado = $this->mysqli->query($sql)))
				return 'Error en la modificación';
			else
				return 'Modificado correctamente';
    	}
    	else 
    		return 'No existe en la base de datos';
	}

			
	function DELETE() {	
		
		$sql = "SELECT * FROM USUARIO  WHERE (login = '$this->login') ";    
		$result = $this->mysqli->query($sql);

		if (!$result)
    		return 'No se ha podido conectar con la base de datos';
		    
		if ($result->num_rows == 1) {
		    	
		    $sql = "DELETE FROM  USUARIO WHERE (login = '$this->login')";   
			$this->mysqli->query($sql);
			
		    return "Borrado correctamente";
		} 
		else
		    return "No existe";
	}  


	function mostrarTodos() {
		
		$sql = "select * from USUARIO";

    	if (!($resultado = $this->mysqli->query($sql)))
			return 'Error en la consulta sobre la base de datos';
    	else
			return $resultado;
	}


	function consultarDatos() {	

		$sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";
		    
		if (!($resultado = $this->mysqli->query($sql)))
			return 'No existe en la base de datos'; 
		else{ 
			$result = $resultado->fetch_array();
			return $result;
		}
    }


	function Login(){

		$sql = "SELECT * FROM USUARIO
			WHERE  ( (login = '$this->login') )";
		
		$resultado = $this->mysqli->query($sql);
		
		if ($resultado->num_rows == 0)
			return 'El login no existe';
		else{
			$tupla = $resultado->fetch_array();
			if ($tupla['password'] == $this->password)
				return true;
			else
				return 'La contraseña para este usuario no es correcta';
		}
	}


	function comprobarNivelAcceso(){
		
		$sql = "SELECT * FROM USUARIO WHERE ((login = '$this->login') && (permiso = '$this->permiso'))";
		
		if (!($resultado = $this->mysqli->query($sql)))
			return false;

		if ($resultado->num_rows == 1)
			return true;
		else 
			return false;
	}


}

?>