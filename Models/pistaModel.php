
<?php
    
class PistaModel {

 	var $id_pista; 
    var $estado;   
	

 	function __construct($id_pista=null,$estado=null){
        $this->id_pista = $id_pista;
        $this->estado = $estado; 
	}



	//getters

	public function getId(){
		return $this->id_pista;
	}

	public function getEstado(){
		return $this->estado;
	}

	//setters

	public function setId($id){
		$this->id_pista = $id;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}


}

?>