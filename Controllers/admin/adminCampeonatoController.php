<?php	

	require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

	class AdminCampeonatoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

                    case 'ADD': 
						if ($_POST){
							$cat = $_REQUEST['categoria'];
							if(empty($cat)){
								SessionMessage::setMessage("Debes seleccionar al menos una categoría");
								header('Location: index.php?controller=adminCampeonatos&action=ADD');
							}
							else{
								try {
									require_once('Models/campeonatoModel.php');
									$campeonato = new CampeonatoModel();
									$campeonato->setNombre($_REQUEST['nombre']);
									$campeonato->setFechaInicio($_REQUEST['fechainicio']);
									$campeonato->setFechaFin($_REQUEST['fechafin']);
									$campeonato->setFechaInicioInscripciones($_REQUEST['fechainicioins']);
									$campeonato->setFechaFinInscripciones($_REQUEST['fechafinins']);
									$errores =  $campeonato->validarRegistro();
									require_once('Mappers/campeonatoMapper.php');
									$campeonatoMapper = new CampeonatoMapper();
									$respuesta = $campeonatoMapper->ADD($campeonato);

									$N = count($cat);
									$idCampeonato = $campeonatoMapper->getIdByNombre($campeonato);
									require_once('Models/campeonatoCategoriaModel.php');
									require_once('Mappers/campeonatoCategoriaMapper.php');
									for($i = 0; $i < $N; $i++){
										$catcamp = new CampeonatoCategoriaModel();
										$catcamp->setIdCampeonato($idCampeonato);
										$catcamp->setIdCategoria($cat[$i]);
										
										$catcampMapper = new CampeonatoCategoriaMapper();
										$catcampMapper->ADD($catcamp);
									}

									SessionMessage::setMessage($respuesta);
									header('Location: index.php?controller=adminCampeonatos');
								}
								catch (ValidationException $e){
									SessionMessage::setErrores($e->getErrores());
									SessionMessage::setMessage($e->getMessage());
									header('Location: index.php?controller=adminCampeonatos&action=ADD');
								}
							}
						}else{
							require_once('Mappers/categoriaMapper.php');
							$categoriaMapper = new CategoriaMapper();
							$categorias = $categoriaMapper->mostrarTodos();
							require_once('Views/campeonatoADDView.php');
							(new CampeonatoADDView(SessionMessage::getMessage(),SessionMessage::getErrores(),'','',$categorias))->render();
						} 
						break;
						

                    case 'DELETE': 
						require_once('Models/campeonatoModel.php');
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						require_once('Mappers/campeonatoMapper.php');
						$campeonatoMapper = new CampeonatoMapper();
						$respuesta = $campeonatoMapper->DELETE($campeonato); 
						SessionMessage::setMessage($respuesta); 
						header('Location: index.php?controller=adminCampeonatos');
						break;
						

                    case 'DETAILS': 
						require_once('Models/campeonatoModel.php');
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						require_once('Mappers/campeonatoMapper.php');
						$campeonatoMapper = new CampeonatoMapper();
						$datos = $campeonatoMapper->consultarDatos($campeonato);
						require_once('Views/campeonatoDetailsView.php');
						$categorias = $campeonatoMapper->getCategoriasByCampeonato($campeonato);
						$grupos = $campeonatoMapper->getGruposByCampeonato($campeonato);
						(new CampeonatoDetailsView('','','',$datos,'',$categorias,'',$grupos))->render();
						break;


					default: 
						echo "hey, estoy viniendo aquí";
						header('Location: index.php?controller=adminUsuarios');
						break;

				}
			} else { //mostrar todos los elementos
				require_once('Mappers/campeonatoMapper.php');
				$campeonatoMapper = new CampeonatoMapper();
				$listaCampeonatos = $campeonatoMapper->mostrarTodos(); 
				require_once('Views/campeonatoView.php');
				(new CampeonatoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaCampeonatos))->render();
			}
		}
	}

 ?>
