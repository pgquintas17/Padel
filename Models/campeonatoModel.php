
<?php
    
class CampeonatoModel {

 	private $id_campeonato; 
 	private $nombre;
 	private $fecha_inicio; 
    private $fecha_fin;
    private $fecha_inicio_inscripciones;
 	private $fecha_fin_inscripciones;
	

 	function __construct($id_campeonato=null,$nombre=null,$fecha_inicio=null,$fecha_fin=null,$fecha_inicio_inscripciones=null,$fecha_fin_inscripciones=null){
        $this->id_campeonato = $id_campeonato;
        $this->nombre = $nombre; 
		$this->fecha_inicio = $fecha_inicio; 
 		$this->fecha_fin = $fecha_fin; 
		$this->fecha_inicio_inscripciones = $fecha_inicio_inscripciones; 
        $this->fecha_fin_inscripciones = $fecha_fin_inscripciones; 
	}



	// getters

	public function getId(){
		return $this->id_campeonato;
	}

	public function getNombre(){
		return $this->nombre;
	}

	public function getFechaInicio(){
		return $this->fecha_inicio;
	}

	public function getFechaFin(){
		return $this->fecha_fin;
	}

	public function getFechaInicioInscripciones(){
		return $this->fecha_inicio_inscripciones;
	}

	public function getFechaFinInscripciones(){
		return $this->fecha_fin_inscripciones;
	}

	// setters

	public function setId($id_campeonato){
		$this->id_campeonato = $id_campeonato;
	}

	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function setFechaInicio($fecha_inicio){
		$this->fecha_inicio = $fecha_inicio;
	}

	public function setFechaFin($fecha_fin){
		$this->fecha_fin = $fecha_fin;
	}

	public function setFechaInicioInscripciones($fecha_inicio_inscripciones){
		$this->fecha_inicio_inscripciones = $fecha_inicio_inscripciones;
	}

	public function setFechaFinInscripciones($fecha_fin_inscripciones){
		$this->fecha_fin_inscripciones = $fecha_fin_inscripciones;
	}




	public function validarRegistro(){

		$errores = array();
		$hoy = date('Y-m-d H:i:s');

		if (strlen($this->nombre) == 0 || strlen($this->nombre) > 30) {
			$errores["nombre"] = "El nombre no puede superar los 30 caracteres ni ser vacío";
		}

		if ($this->fecha_inicio_inscripciones == null) {
			$errores["fecha_ii"] = "Debe seleccionarse una fecha de inicio para el periodo de inscripción.";
		}
		if ($this->fecha_inicio_inscripciones < $hoy) {
			$errores["fecha_ii_2"] = "El periodo de inscripción no puede ser anterior a la fecha actual.";
		}

		if ($this->fecha_fin_inscripciones == null) {
			$errores["fecha_fi"] = "Debe seleccionarse una fecha de fin para el periodo de inscripción.";
		}
		if ($this->fecha_fin_inscripciones < $this->fecha_inicio_inscripciones) {
			$errores["fecha_fi_2"] = "El periodo de inscripción no puede finalizar antes de empezar.";
		}

		if ($this->fecha_inicio == null) {
			$errores["fecha_i"] = "Debe seleccionarse una fecha de inicio para el campeonato.";
		}
		if ($this->fecha_inicio < $this->fecha_fin_inscripciones) {
			$errores["fecha_i_2"] = "El campeonato no puede ser empezar antes de terminar el periodo de inscripción.";
		}
		
		if ($this->fecha_fin == null) {
			$errores["fecha_f"] = "Debe seleccionarse una fecha de fin para el campeonato.";
		}
		if ($this->fecha_fin < $this->fecha_inicio) {
			$errores["fecha_f_2"] = "El campeonato no puede ser finalizar antes de empezar.";
		}
		
		
		if (sizeof($errores) > 0){
			throw new ValidationException($errores, "Datos no válidos");
		}
	}

}

?>