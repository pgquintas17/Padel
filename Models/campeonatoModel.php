
<?php
    
class CampeonatoModel {

 	var $id_campeonato; 
 	var $nombre;
 	var $fecha_inicio; 
    var $fecha_fin;
    var $fecha_inicio_inscripciones;
 	var $fecha_fin_inscripciones;  
	var $bd; 
	

 	function __construct($id_campeonato,$nombre,$fecha_inicio,$fecha_fin,$fecha_inicio_inscripciones,$fecha_fin_inscripciones){
        $this->id_campeonato = $id_campeonato;
        $this->nombre = $nombre; 
		$this->fecha_inicio = $fecha_inicio; 
 		$this->fecha_fin = $fecha_fin; 
		$this->fecha_inicio_inscripciones = $fecha_inicio_inscripciones; 
        $this->fecha_fin_inscripciones = $fecha_fin_inscripciones;
		include_once '../Models/BdAdmin.php'; 
		$this->mysqli = ConectarBD();  
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

}

?>