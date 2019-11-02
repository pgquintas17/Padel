
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


}

?>