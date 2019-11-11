<?php
    
class ParejaModel {

 	private $id_pareja; 
 	private $nombre_pareja;
 	private $capitan; 
	private $miembro;
	private $fecha_inscrip;
	private $id_grupo;
	private $id_catcamp;
	private $puntos;   
	

 	function __construct($id_pareja=null,$nombre_pareja=null,$capitan=null,$miembro=null,$fecha_inscrip=null,$id_grupo=null,$id_catcamp=null,$puntos=null){
        $this->id_pareja = $id_pareja;
        $this->nombre_pareja = $nombre_pareja; 
		$this->capitan = $capitan; 
		$this->miembro = $miembro;  
		$this->fecha_inscrip = $fecha_inscrip;
		$this->id_grupo = $id_grupo;
		$this->id_catcamp = $id_catcamp;
		$this->puntos = $puntos;
	}

	//getters

	public function getId(){
		return $this->id_pareja;
	}

	public function getNombre(){
		return $this->nombre_pareja;
	}

	public function getCapitan(){
		return $this->capitan;
	}

	public function getMiembro(){
		return $this->id_miembro;
	}

	public function getFechaInscrip(){
		return $this->fecha_inscrip;
	}

	public function getIdGrupo(){
		return $this->id_grupo;
	}

	public function getCatCamp(){
		return $this->id_catcamp;
	}

	public function getPuntos(){
		return $this->puntos;
	}

	//setters

	public function setId($id_pareja){
		$this->id_pareja = $id_pareja;
	}

	public function setNombre($nombre_pareja){
		$this->nombre_pareja = $nombre_pareja;
	}

	public function setCapitan($capitan){
		$this->capitan = $capitan;
	}

	public function setMiembro($miembro){
		$this->id_miembro = $miembro;
	}

	public function setFechaInscrip($fecha_inscrip){
		$this->fecha_inscrip = $fecha_inscrip;
	}

	public function setIdGrupo($id_grupo){
		$this->id_grupo = $id_grupo;
	}

	public function setCatCamp($id_catcamp){
		$this->id_catcamp = $id_catcamp;
	}

	public function setPuntos($puntos){
		$this->puntos = $puntos;
	}


}

?>