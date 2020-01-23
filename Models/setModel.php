
<?php
    
class SetModel {

    private $pareja1;  
	private $pareja2; 
	

 	function __construct($pareja1=null,$pareja2=null){
        $this->pareja1 = $pareja1;
        $this->pareja2 = $pareja2;  
	}


	// getters

	public function getPareja1(){
		return $this->pareja1;
	}

	public function getPareja2(){
		return $this->pareja2;
	}

	// setters

	public function setPareja1($pareja1){
		$this->pareja1 = $pareja1;
	}

	public function setPareja2($pareja2){
		$this->pareja2 = $pareja2;
	}



	function validarSet(){

		$errores = array();
		
		if(($this->pareja1 == null && $this->pareja2 != null) || ($this->pareja1 != null && $this->pareja2 == null)){
			$errores['puntuacion0'] = "1Puntuación de set no válida.";
		}

		if($this->pareja1 < 6 && $this->pareja2 < 6){
			$errores['puntuacion1'] = "Puntuación de set no válida.";
		}

		if($this->pareja1 > 7 || $this->pareja2 > 7){
			$errores['puntuacion2'] = "Puntuación de set no válida.";
		}

		if(($this->pareja1 == 7 && ($this->pareja2 != 5 && $this->pareja2 != 6)) || ($this->pareja2 == 7 && ($this->pareja1 != 5 && $this->pareja1 != 6))){
			$errores['puntuacion3'] = "Puntuación de set no válida.";
		}

		if(($this->pareja1 == 6 && $this->pareja2 > 4 && $this->pareja2 != 7) || ($this->pareja2 == 6 && $this->pareja1 > 4 && $this->pareja1 != 7)){
			$errores['puntuacion4'] = "Puntuación de set no válida.";
		}

		if (sizeof($errores) > 0){
			throw new ValidationException($errores, "Datos no válidos");
		}
	}





}

?>