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
		return $this->miembro;
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
		$this->miembro = $miembro;
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




	public function validarRegistro(){

		$errores = array();
		require_once('Mappers/parejaMapper.php');
		require_once('Models/campeonatoCategoriaModel.php');
		require_once('Mappers/campeonatoCategoriaMapper.php');
		require_once('Models/usuarioModel.php');
		require_once('Mappers/usuarioMapper.php');
		require_once('Models/campeonatoModel.php');
		

		$catcampMapper = new CampeonatoCategoriaMapper();
		$usuarioMapper = new UsuarioMapper();
		$parejaMapper = new ParejaMapper();
		$capitan = new UsuarioModel();
		$capitan->setLogin($this->capitan);
		$miembro = new UsuarioModel();
		$miembro->setLogin($this->miembro);
		$catcamp = new CampeonatoCategoriaModel();
		$catcamp->setId($this->id_catcamp);
		$campeonato = new CampeonatoModel(($catcampMapper->getCampeonatoByCategoria($catcamp)));


		if (strlen($this->nombre_pareja) == 0 || strlen($this->nombre_pareja) > 20) {
			$errores["nombre"] = "El nombre no puede estar vacio ni superar los 20 caracteres.";
		}

		if($parejaMapper->validarNombrePorCampeonato($this,$campeonato)){
			$errores["nombre2"] = "Ya existe una pareja inscrita en el campeonato con ese nombre.";
		}

		if($usuarioMapper->validarExisteDeportista($miembro)){
			$errores['miembro'] = "El usuario elegido como miembro no existe o no es deportista.";	
		}

		if ($this->capitan == $this->miembro) {
			$errores["miembros"] = "Los miembros de la pareja deben ser distintos.";
		}

		if($parejaMapper->getUsuarioRepetidoEnCategoria($this)){
			$errores["usuario_repetido"] = "Uno de los usuarios ya está apuntado en esta categoría.";
		}

		$sexo = $catcampMapper->getSexonivelById($catcamp);

		$sexoC = $usuarioMapper->getSexoByLogin($capitan);
		$sexoM = $usuarioMapper->getSexoByLogin($miembro);

		if(($sexo == "M1" || $sexo == "M2" || $sexo == "M3") && ($sexoM == "femenino" || $sexoC == "femenino")){

			$errores["genero"] = "En las categorías masculinas sólo pueden jugar hombres.";

		}
		
		if(($sexo == "F1" || $sexo == "F2" || $sexo == "F3") && ($sexoM == "masculino" || $sexoC == "masculino")){

			$errores["genero"] = "En las categorías femeninas sólo pueden jugar mujeres.";
		}
		
		if(($sexo == "MX1" || $sexo == "MX2" || $sexo == "MX3") && ($sexoM == $sexoC)){
				$errores["genero"] = "En las categorías mixtas sólo pueden jugar parejas mixtas.";
		}
		

		if (sizeof($errores) > 0){
			throw new ValidationException($errores, "Datos no válidos");
		}
	}


}

?>