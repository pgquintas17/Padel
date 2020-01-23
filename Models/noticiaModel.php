<?php
    
class NoticiaModel {

 	private $id_noticia; 
	private $titulo;
	private $cuerpo;
	private $fecha_creacion; 
	

 	function __construct($id_noticia=null,$titulo=null,$cuerpo=null,$fecha_creacion=null){
        $this->id_noticia = $id_noticia;
		$this->titulo = $titulo;
		$this->cuerpo = $cuerpo;
		$this->fecha_creacion = $fecha_creacion;  
	}


	//getters

	public function getId(){
		return $this->id_noticia;
	}

	public function getTitulo(){
		return $this->titulo;
	}

	public function getCuerpo(){
		return $this->cuerpo;
	}

	public function getFechaCreacion(){
		return $this->fecha_creacion;
	}

	//setters

	public function setId($id_noticia){
		$this->id_noticia = $id_noticia;
	}

	public function setTitulo($titulo){
		$this->titulo = $titulo;
	}

	public function setCuerpo($cuerpo){
		$this->cuerpo = $cuerpo;
	}

	public function setFechaCreacion($fecha_creacion){
		$this->fecha_creacion = $fecha_creacion;
	}


    public function validarRegistro(){

		$errores = array();

		if (strlen($this->titulo) == 0 || strlen($this->titulo) > 45) {
			$errores["titulo"] = "El titulo no puede superar los 45 caracteres ni ser vacío";
        }
        
        if (strlen($this->cuerpo) == 0) {
			$errores["cuerpo"] = "El cuerpo de la noticia no puede ser vacío";
		}
		
		if (sizeof($errores) > 0){
			throw new ValidationException($errores, "Datos no válidos");
		}
	}

}

?>