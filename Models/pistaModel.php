
<?php
    
class PistaModel {

	private $id_pista;
	private $tipo;  
    private $estado;   
	

 	function __construct($id_pista=null,$tipo=null,$estado=null){
		$this->id_pista = $id_pista;
		$this->tipo = $tipo;
        $this->estado = $estado; 
	}



	//getters

	public function getId(){
		return $this->id_pista;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function getEstado(){
		return $this->estado;
	}

	//setters

	public function setId($id){
		$this->id_pista = $id;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function setEstado($estado){
		$this->estado = $estado;
	}


	public function validarRegistro(){

		$errores = array();

		if (strlen($this->id_pista) == 0 || strlen($this->id_pista) > 2) {
			$errores["id"] = "El número de pista no puede ser mayor de 99 ni ser vacío";
		}
		if (strlen($this->tipo) == null) {
			$errores["tipo"] = "Debe seleccionar un tipo de pista.";
		}
		if($this->tipo != "1" && $this->tipo != "2" && $this->tipo != "3" && $this->tipo != "4"){
			$errores["tipo2"] = "Tipo incorrecto";
		}
		
		if (sizeof($errores) > 0){
			throw new ValidationException($errores, "Datos no válidos");
		}
	}


}

?>