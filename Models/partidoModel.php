
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
	var $id_reserva;
	var $num_plazas; 
	

 	function __construct($id_partido=null,$resultado=null,$hora=null,$fecha=null,$promocion=null,$login1=null,$login2=null,$login3=null,$login4=null,$id_reserva=null,$num_plazas=null){
		$this->id_partido = $id_partido;
		$this->resultado = $resultado;
        $this->hora = $hora; 
		$this->fecha = $fecha;
		$this->promocion = $promocion; 
 		$this->login1 = $login1; 
        $this->login2 = $login2;
        $this->login3 = $login3;
		$this->login4 = $login4;
		$this->id_reserva = $id_reserva;
		$this->num_plazas = $num_plazas;
	}


	// getters

	public function getId(){
		return $this->id_partido;
	}

	public function getResultado(){
		return $this->resultado;
	}

	public function getHora(){
		return $this->hora;
	}

	public function getFecha(){
		return $this->fecha;
	}

	public function getPromocion(){
		return $this->promocion;
	}

	public function getLogin1(){
		return $this->login1;
	}

	public function getLogin2(){
		return $this->login2;
	}

	public function getLogin3(){
		return $this->login3;
	}

	public function getLogin4(){
		return $this->login4;
	}

	public function getIdReserva(){
		return $this->id_reserva;
	}

	public function getNumPlazas(){
		return $this->numPlazas;
	}


	// setters

	public function setId($id_partido){
		$this->id_partido = $id_partido;
	}

	public function setResultado($resultado){
		$this->resultado = $resultado;
	}

	public function setHora($hora){
		$this->hora = $hora;
	}

	public function setFecha($fecha){
		$this->fecha = $fecha;
	}

	public function setPromocion($promocion){
		$this->promocion = $promocion;
	}

	public function setLogin1($login1){
		$this->login1 = $login1;
	}

	public function setLogin2($login2){
		$this->login2 = $login2;
	}

	public function setLogin3($login3){
		$this->login3 = $login3;
	}

	public function setLogin4($login4){
		$this->login4 = $login4;
	}

	public function setIdReserva($id_reserva){
		$this->id_reserva = $id_reserva;
	}

	public function setNumPlazas($num_plazas){
		$this->num_plazas = $num_plazas;
	}



	public function validarRegistro(){

		$errores = array();
		$fecha = date('Y-m-d');
		$apertura = "09:00";
		$cierre = "21:00";

		if (($this->fecha) <= $fecha) {
			$errores["Fecha"] = "Seleccione una fecha posterior a la actual.";
		}

		if (($this->hora) < $apertura) {
			$errores["Hora"] = "La hora de apertura del club es a las 9:00.";
		}

		if (($this->hora) >= $cierre) {
			$errores["Hora"] = "La hora de cierre del club es a las 21:00.";
		}
		
		
		if (sizeof($errores) > 0){
			throw new ValidationException($errores, "El usuario no es válido");
		}
	}

}

?>