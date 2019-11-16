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
							require_once('Views/campeonato/campeonatoADDView.php');
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

					
					case 'EDIT':
						if($_REQUEST['idcampeonato']){
							require_once('Models/campeonatoModel.php');
							$campeonato = new CampeonatoModel();
							$campeonato->setId($_REQUEST['idcampeonato']);
							require_once('Mappers/campeonatoMapper.php');
							$campeonatoMapper = new CampeonatoMapper();
							$categoriasFaltan = $campeonatoMapper->getCategoriasNotInCampeonato($campeonato);
							$categoriasActuales = $campeonatoMapper->getCategoriasByCampeonato($campeonato);
							$datos = $campeonatoMapper->consultarDatos($campeonato);

							require_once('Views/campeonato/campeonatoEDITView.php');
							(new CampeonatoEDITView(SessionMessage::getMessage(),SessionMessage::getErrores(),'','',$categoriasActuales,'',$categoriasFaltan,$datos))->render();

						}
						else{
							header('Location: index.php?controller=adminCampeonatos');
						}
						
						break;


					case 'borrarCategorias': 
						if ($_POST){
							
							$cat = $_REQUEST['categoria'];
							$N = count($cat);
							
							require_once('Models/campeonatoCategoriaModel.php');
							require_once('Mappers/campeonatoCategoriaMapper.php');

							for($i = 0; $i < $N; $i++){
								$catcamp = new CampeonatoCategoriaModel();
								$catcamp->setId($cat[$i]);
								$catcampMapper = new CampeonatoCategoriaMapper();
								$respuesta = $catcampMapper->DELETE($catcamp);
							}

							require_once('Models/campeonatoModel.php');
							$campeonato = new CampeonatoModel();
							$campeonato->setId($_REQUEST['idcampeonato']);
							require_once('Mappers/campeonatoMapper.php');
							$campeonatoMapper = new CampeonatoMapper();
							$numCategorias = $campeonatoMapper->getNumCategoriasByCampeonato($campeonato);

							if($numCategorias == 0){
								$campeonatoMapper->DELETE($campeonato);
								SessionMessage::setMessage("El campeonato y sus categorías han sido eliminados.");
								header('Location: index.php?controller=adminCampeonatos');
							}
							else{
								SessionMessage::setMessage($respuesta);
								$goto = 'Location: index.php?controller=adminCampeonatos&action=DETAILS&idcampeonato='.$_REQUEST['idcampeonato'];
								header($goto);
							}
						}else{
							header('Location: index.php?controller=adminCampeonatos');
						}
						break;


					case 'addCategorias': 
						if ($_POST){
							$cat = $_REQUEST['categoria'];
							$N = count($cat);
							
							require_once('Models/campeonatoCategoriaModel.php');
							require_once('Mappers/campeonatoCategoriaMapper.php');

							for($i = 0; $i < $N; $i++){
								$catcamp = new CampeonatoCategoriaModel();
								$catcamp->setIdCampeonato($_REQUEST['idcampeonato']);
								$catcamp->setIdCategoria($cat[$i]);
								
								$catcampMapper = new CampeonatoCategoriaMapper();
								$respuesta=$catcampMapper->ADD($catcamp);
							}

							SessionMessage::setMessage($respuesta);
							$goto = 'Location: index.php?controller=adminCampeonatos&action=DETAILS&idcampeonato='.$_REQUEST['idcampeonato'];
							header($goto);
						}else{
							header('Location: index.php?controller=adminCampeonatos');
						}
						break;
						

                    case 'DETAILS': 
						require_once('Models/campeonatoModel.php');
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						require_once('Mappers/campeonatoMapper.php');
						$campeonatoMapper = new CampeonatoMapper();
						$datos = $campeonatoMapper->consultarDatos($campeonato);
						require_once('Views/campeonato/campeonatoDetailsView.php');
						$categorias = $campeonatoMapper->getCategoriasByCampeonato($campeonato);
						(new CampeonatoDetailsView(SessionMessage::getMessage(), SessionMessage::getErrores(),'',$datos,'',$categorias,''))->render();
						break;
					

					case 'clasificacionCampeonato':
						require_once('Models/CampeonatoModel.php');
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						require_once('Mappers/CampeonatoMapper.php');
						$campeonatoMapper = new CampeonatoMapper();
						$parejas = $campeonatoMapper->getParejasByCampeonato($campeonato);
						$datos = $campeonatoMapper->consultarDatos($campeonato); 
						require_once('Views/campeonato/clasificacionCampeonatoView.php');
						(new ClasificacionCampeonatoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$parejas,$datos))->render();
						break;


					case 'clasificacionCategoria':
						require_once('Models/CampeonatoCategoriaModel.php');
						$catcamp = new CampeonatoCategoriaModel();
						$catcamp->setId($_REQUEST['idcatcamp']);
						require_once('Mappers/CampeonatoCategoriaMapper.php');
						$catcampMapper = new CampeonatoCategoriaMapper();
						$parejas = $catcampMapper->getParejasByCategoria($catcamp); 
						$datos = $catcampMapper->getDatosCampeonatoYCategoria($catcamp);
						require_once('Views/campeonato/clasificacionCategoriaView.php');
						(new ClasificacionCategoriaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$parejas,$datos))->render();
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
				require_once('Views/campeonato/campeonatoView.php');
				(new CampeonatoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaCampeonatos))->render();
			}
		}
	}

 ?>
