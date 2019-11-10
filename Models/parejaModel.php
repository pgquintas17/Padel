<?php
    
class ParejaModel {

 	private $id_pareja; 
 	private $nombre_pareja;
 	private $capitan; 
    private $miembro;
	private $id_grupo;
	private $id_catcamp;
	private $puntos;   
	

 	function __construct($id_pareja,$nombre_pareja,$capitan,$miembro,$id_grupo,$id_catcamp){
        $this->id_pareja = $id_pareja;
        $this->nombre_pareja = $nombre_pareja; 
		$this->capitan = $capitan; 
 		$this->miembro = $miembro;  
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