
<?php
/*  Fichero para el archivo del modelo de usuarios  */
    
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
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
	}

	//funcion ADD()
	//Mediante esta funcion añadiremos un nuevo USUARIO a la bd

	function ADD(){


		if (($this->login <> '')){ // si el atributo clave de la entidad no esta vacio

		// construimos el sql para buscar esa clave en la tabla
        $sql = "SELECT * FROM USUARIO WHERE (login = '$this->login')";

		if (!$result = $this->mysqli->query($sql)){ // si da error la ejecución de la query
			return 'No se ha podido conectar con la base de datos'; // error en la consulta (no se ha podido conectar con la bd). Devolvemos un mensaje que el controlador manejara
		}
		else { // si la ejecución de la query no da error
			if ($result->num_rows == 0){ // miramos si el resultado de la consulta es vacio (no existe el login)
				//construimos la sentencia sql de inserción en la bd
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


				if (!$this->mysqli->query($sql)) { // si da error en la ejecución del insert devolvemos mensaje
					return 'Error en la inserción';
				}
				else{ //si no da error en la insercion devolvemos mensaje de exito
					return 'Inserción realizada con éxito'; //operacion de insertado correcta
				}

			}
			else // si ya existe ese valor de clave en la tabla devolvemos el mensaje correspondiente
				return 'Ya existe en la base de datos'; // ya existe
		}
    }
    else{ // si el atributo clave de la bd es vacio solicitamos un valor en un mensaje

        return 'Introduzca un valor'; // introduzca un valor para el usuario

	}

	}

	//funcion EDIT()
	//Mediante esta funcion editaremos un USUARIO ya existente en la bd

	function EDIT()
{
	// se construye la sentencia de busqueda de la tupla en la bd
    $sql = "SELECT * FROM USUARIO  WHERE (login = '$this->login') ";
    // se ejecuta la query
    $result = $this->mysqli->query($sql);
    // si el numero de filas es igual a uno es que lo encuentra

    if ($result->num_rows == 1)

    {	// se construye la sentencia de modificacion en base a los atributos de la clase

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


		// si hay un problema con la query se envia un mensaje de error en la modificacion
        if (!($resultado = $this->mysqli->query($sql))){
			return 'Error en la modificación';
		}
		else{ // si no hay problemas con la modificación se indica que se ha modificado
			return 'Modificado correctamente';
		}
    }

    else{ // si no se encuentra la tupla se manda el mensaje de que no existe la tupla

    	return 'No existe en la base de datos';
    }
}

	//funcion SEARCH()
	//Medante esta funcion buscaremos cualquier dato relativo a un USUARIO


	function SEARCH()
{ 	// construimos la sentencia de busqueda con LIKE y los atributos de la entidad
    $sql = "select 
                login,
                nombre,
                apellidos,
                password,
                fecha_nac,
                telefono,
                email,
                genero,
                permiso

       	    from USUARIO where

                    ( (login LIKE '%$this->login%') &&
                      (nombre LIKE '%$this->nombre%') &&
                      (apellidos LIKE '%$this->apellidos%') &&
                      (fecha_nac LIKE '%$this->fecha_nac%') &&
                      (telefono LIKE '%$this->telefono%') &&
                      (email LIKE '%$this->email%') &&
                      (genero LIKE '%$this->genero%') &&
                      (permiso LIKE '%$this->permiso%') )";

    // si se produce un error en la busqueda mandamos el mensaje de error en la consulta
    if (!($resultado = $this->mysqli->query($sql))){
		return 'Error en la consulta sobre la base de datos';
	}
    else{ // si la busqueda es correcta devolvemos el recordset resultado
		return $resultado;
	}
} // fin metodo SEARCH





		// funcion DELETE()
		// comprueba que exista el valor de clave por el que se va a borrar,si existe se ejecuta el borrado, sino
		// se manda un mensaje de que ese valor de clave no existe
		function DELETE()
		{	// se construye la sentencia sql de busqueda con los atributos de la clase
		    $sql = "SELECT * FROM USUARIO  WHERE (login = '$this->login') ";
		    // se ejecuta la query
		    $result = $this->mysqli->query($sql);
		    // si existe una tupla con ese valor de clave
		    if ($result->num_rows == 1)
		    {
		    	// se construye la sentencia sql de borrado
		        $sql = "DELETE FROM  USUARIO WHERE (login = '$this->login')";
		        // se ejecuta la query
		        $this->mysqli->query($sql);
		        // se devuelve el mensaje de borrado correcto
		    	return "Borrado correctamente";
		    } // si no existe el login a borrar se devuelve el mensaje de que no existe
		    else
		        return "No existe";
		} // fin metodo DELETE

		// funcion RellenaDatos()
		// Esta función obtiene de la entidad de la bd todos los atributos a partir del valor de la clave que esta
		// en el atributo de la clase
		function RellenaDatos()
		{	// se construye la sentencia de busqueda de la tupla
		    $sql = "SELECT * FROM  USUARIO WHERE (login = '$this->login')";
		    // Si la busqueda no da resultados, se devuelve el mensaje de que no existe
		    if (!($resultado = $this->mysqli->query($sql))){
				return 'No existe en la base de datos'; //
			}
		    else{ // si existe se devuelve la tupla resultado
				$result = $resultado->fetch_array();
				return $result;
			}
		} // fin del metodo RellenaDatos()





		// funcion login: realiza la comprobación de si existe el usuario en la bd y despues si la pass
// es correcta para ese usuario. Si es asi devuelve true, en cualquier otro caso devuelve el
// error correspondiente
function Login(){

	$sql = "SELECT *
			FROM USUARIO
			WHERE (
				(login = '$this->login')
			)";
	$resultado = $this->mysqli->query($sql);
	if ($resultado->num_rows == 0){
		return 'El login no existe';
	}
	else{
		$tupla = $resultado->fetch_array();
		if ($tupla['password'] == $this->password){
			return true;
		}
		else{
			return 'La contraseña para este usuario no es correcta';
		}
	}
}//fin metodo login

//
function Register(){

		$sql = "select * from USUARIO where login = '".$this->login."'";

		$result = $this->mysqli->query($sql);
		if ($result->num_rows == 1){  // existe el usuario
				return 'El usuario ya existe';
			}
		else{
	    		return true; //no existe el usuario
		}

	}

	//funcion registrar()
	//Mediante esta funcion registraremos un nuevo usuario en la bd

function registrar(){

		//sentencia de inserción
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
					'".$this->login."',
					'".$this->nombre."',
					'".$this->apellidos."',
					'".$this->password."',
					'".$this->fecha_nac."',
					'".$this->telefono."',
                    '".$this->email."',
                    '".$this->genero."',
                    '".$this->permiso."'
					)";

		if (!$this->mysqli->query($sql)) { //si ha habido algun fallo en la sentencia
			return 'Error en la inserción';
		}
		else{
			return 'Inserción realizada con éxito'; //operacion de insertado correcta
		}
	}




}

?>