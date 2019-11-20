
<?php
    
class UsuarioModel {
	 
	private $login; 
 	private $nombre; 
    private $password;
    private $fecha_nac;
 	private $telefono; 
    private $email; 
    private $genero; 
    private $permiso; 
	
	
 	function __construct($login=null,$nombre=null,$password=null,$fecha_nac=null,$telefono=null,$email=null,$genero=null,$permiso=null){
        $this->login = $login;
        $this->nombre = $nombre;
 		$this->password = $password; 
		$this->fecha_nac = $fecha_nac; 
        $this->telefono = $telefono;  
		$this->email = $email; 
        $this->genero = $genero;
        $this->permiso = $permiso;  
	}

	
	//getters

	public function getLogin(){
		return $this->login;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getPassword(){
		return $this->password;
	}

	public function getFechaNac(){
		return $this->fecha_nac;
	}

	public function getTelefono(){
		return $this->telefono;
	}

	public function getEmail(){
		return $this->email;
	}

	public function getGenero(){
		return $this->genero;
	}

	public function getPermiso(){
		return $this->permiso;
	}

	//setters

	public function setLogin($login){
		$this->login = $login;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setPassword($password){
		$this->password = $password;
	}

	public function setFechaNac($fecha_nac){
		$this->fecha_nac = $fecha_nac;
	}

	public function setTelefono($telefono){
		$this->telefono = $telefono;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function setGenero($genero){
		$this->genero = $genero;
	}

	public function setPermiso($permiso){
		$this->permiso = $permiso;
	} 
	
	

	public function validarRegistro(){

		$errores = array();

		if (strlen($this->login) == 0 || strlen($this->login) > 15) {
			$errores["login"] = "El login no puede superar los 15 caracteres ni ser vacío";
		}
		if($this->password != $this->login){
			if (strlen($this->password) < 6 || strlen($this->password) == 0) {
				$errores["passwordd"] = "La contraseña debe tener como mínimo 6 caracteres";
			}
		}
		if (strlen($this->nombre) == 0 || strlen($this->nombre) > 100) {
			$errores["nombre"] = "El nombre no puede estar vacio";
		}
		if (strlen($this->genero) == 0) {
			$errores["genero"] = "Debe seleccionarse un género";
		}
		if ($this->fecha_nac == null) {
			$errores["fecha_nac"] = "Debe seleccionarse una fecha de nacimiento";
		}
		if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
			$errores["email"] = "El formato del email es incorrecto";
		}
		if ($this->permiso == null) {
			$errores["permiso"] = "Debe seleccionarse una categoría para el usuario";
		}
		if ((!filter_var($this->telefono, FILTER_SANITIZE_NUMBER_INT)) || strlen($this->telefono) != 9) {
			$errores["telefono"] = "Formato del teléfono erróneo";
		}
		
		if (sizeof($errores) > 0){
			throw new ValidationException($errores, "Datos no válidos");
		}
	}


}

?>