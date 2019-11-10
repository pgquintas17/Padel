<?php
    
class GrupoModel {

 	private $id_grupo; 
	private $id_catcamp;
	private $n_parejas; 
	

 	function __construct($id_grupo=null,$id_catcamp=null,$n_parejas=null){
        $this->id_grupo = $id_grupo;
		$this->id_catcamp = $id_catcamp;
		$this->n_parejas = $n_parejas;  
	}


	//getters

	public function getId(){
		return $this->id_grupo;
	}

	public function getIdCatCamp(){
		return $this->id_catcamp;
	}

	public function getNumParejas(){
		return $this->n_parejas;
	}

	//setters

	public function setId($id_grupo){
		$this->id_grupo = $id_grupo;
	}

	public function setIdCatCamp($id_catcamp){
		$this->id_catcamp = $id_catcamp;
	}

	public function setNumParejas($n_parejas){
		$this->n_parejas = $n_parejas;
	}


}

?>