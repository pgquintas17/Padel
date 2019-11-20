
<?php
    
class CategoriaModel {

 	private $id_categoria; 
    private $sexo;
	

 	function __construct($id_categoria=null,$sexonivel=null){
        $this->id_categoria = $id_categoria;
        $this->sexonivel = $sexonivel;  
	}


	//getters

	public function getId(){
		return $this->id_categoria;
	}

	public function getSexoNivel(){
		return $this->sexonivel;
	}


	//setters

	public function setId($id_categoria){
		$this->id_categoria = $id_categoria;
	}

	public function setSexoNivel($sexonivel){
		$this->sexonivel = $sexonivel;
	}

}

?>