<?php

 class CampeonatoCategoriaModel {
	 	
	private $id_catcamp;
 	private $id_campeonato; 
	private $id_categoria;
	private $n_plazas;  

 	function __construct($id_catcamp=null, $id_campeonato=null, $id_categoria=null){

		$this->id_catcamp = $id_catcamp;
 		$this->id_campeonato = $id_campeonato; 
		$this->id_categoria = $id_categoria;
		$this->n_plazas = $n_plazas;  
	}


	//getters

	public function getId(){
		return $this->id_catcamp;
	}

	public function getIdCampeonato(){
		return $this->id_campeonato;
	}

	public function getIdCategoria(){
		return $this->id_categoria;
	}

	public function getNumPlazas(){
		return $this->n_plazas;
	}

	//setters

	public function setId($id_catcamp){
		$this->id_catcamp = $id_catcamp;
	}

	public function setIdCampeonato($id_campeonato){
		$this->id_campeonato = $id_campeonato;
	}

	public function setIdCategoria($id_categoria){
		$this->id_categoria = $id_categoria;
	}

	public function setNumPlazas($n_plazas){
		$this->n_plazas = $n_plazas;
	}

}

?>
