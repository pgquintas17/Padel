
<?php
    
class EnfrentamientoModel {

 	private $id_enfrentamiento; 
 	private $resultado;
 	private $fecha; 
    private $hora;
    private $set1;
    private $set2;
    private $set3;
    private $pareja1;
	private $pareja2;  
	private $id_reserva;
	

 	function __construct($id_enfrentamiento=null,$resultado=null,$fecha=null,$hora=null,$set1=null,$set2=null,$set3=null,$pareja1=null,$pareja2=null,$id_reserva=null){
        $this->id_enfrentamiento = $id_enfrentamiento;
        $this->resultado = $resultado; 
		$this->fecha = $fecha; 
 		$this->hora = $hora; 
        $this->set1 = $set1;
        $this->set2 = $set2;
        $this->set3 = $set3; 
        $this->pareja1 = $pareja1;
		$this->pareja2 = $pareja2;
		$this->id_reserva = $id_reserva; 
	}




	// getters

	public function getId(){
		return $this->id_enfrentamiento;
	}

	public function getResultado(){
		return $this->resultado;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function getHora(){
		return $this->hora;
	}

	public function getSet1(){
		return $this->set1;
	}

	public function getSet2(){
		return $this->set2;
	}

	public function getSet3(){
		return $this->set3;
	}
	
	public function getPareja1(){
		return $this->pareja1;
	}

	public function getPareja2(){
		return $this->pareja2;
	}

	public function getIdReserva(){
		return $this->id_reserva;
	}	

	public function getIdGrupo(){
		return $this->id_grupo;
	}


	// setter

	public function setId($id_enfrentamiento){
		$this->id_enfrentamiento = $id_enfrentamiento;
	}

	public function setResultado($resultado){
		$this->resultado = $resultado;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	public function setHora($hora){
		$this->hora = $hora;
	}

	public function setSet1($set1){
		$this->set1 = $set1;
	}

	public function setSet2($set2){
		$this->set2 = $set2;
	}
	
	public function setSet3($set3){
		$this->set3 = $set3;
	}
	
	public function setPareja1($pareja1){
		$this->pareja1 = $pareja1;
	}

	public function setPareja2($pareja2){
		$this->pareja2 = $pareja2;
	}

	public function setIdReserva($id_reserva){
		$this->id_reserva = $id_reserva;
	}

	public function setIdGrupo($id_grupo){
		$this->id_grupo = $id_grupo;
	}


}

?>