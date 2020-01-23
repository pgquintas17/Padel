
<?php
    
class ReservaModel {
	
 	private $id_reserva; 
 	private $id_pista;
 	private $hora; 
    private $fecha;
    private $login;
	

 	function __construct($id_reserva=null,$id_pista=null,$hora=null,$fecha=null,$login=null){
        $this->id_reserva = $id_reserva;
        $this->id_pista = $id_pista; 
		$this->hora = $hora; 
 		$this->fecha = $fecha; 
		$this->login = $login;  
	}


	// getters

	public function getId(){
		return $this->id_reserva;
	}

	public function getIdPista(){
		return $this->id_pista;
	}

	public function getHora(){
		return $this->hora;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function getLogin(){
		return $this->login;
	}


	// setters

	public function setId($id_reserva){
		$this->id_reserva = $id_reserva;
	}

	public function setIdPista($id_pista){
		$this->id_pista = $id_pista;
	}

	public function setHora($hora){
		$this->hora = $hora;
	}
	
	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	public function setLogin($login){
		$this->login = $login;
	}

}

?>