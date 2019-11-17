<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/campeonatoModel.php');
	require_once('Mappers/campeonatoMapper.php');
	require_once('Models/campeonatoCategoriaModel.php');
	require_once('Mappers/campeonatoCategoriaMapper.php');
	require_once('Mappers/categoriaMapper.php');
	require_once('Mappers/grupoMapper.php');

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
									$campeonato = new CampeonatoModel();
									$campeonato->setNombre($_REQUEST['nombre']);
									$campeonato->setFechaInicio($_REQUEST['fechainicio']);
									$campeonato->setFechaFin($_REQUEST['fechafin']);
									$campeonato->setFechaInicioInscripciones($_REQUEST['fechainicioins']);
									$campeonato->setFechaFinInscripciones($_REQUEST['fechafinins']);
									$errores =  $campeonato->validarRegistro();
									$campeonatoMapper = new CampeonatoMapper();
									$respuesta = $campeonatoMapper->ADD($campeonato);

									$N = count($cat);
									$idCampeonato = $campeonatoMapper->getIdByNombre($campeonato);

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
							$categoriaMapper = new CategoriaMapper();
							$categorias = $categoriaMapper->mostrarTodos();
							require_once('Views/campeonato/campeonatoADDView.php');
							(new CampeonatoADDView(SessionMessage::getMessage(),SessionMessage::getErrores(),'','',$categorias))->render();
						} 
						break;
						

                    case 'DELETE': 
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						$campeonatoMapper = new CampeonatoMapper();
						$respuesta = $campeonatoMapper->DELETE($campeonato); 
						SessionMessage::setMessage($respuesta); 
						header('Location: index.php?controller=adminCampeonatos');
						break;

					
					case 'EDIT':
						if($_REQUEST['idcampeonato']){
							$campeonato = new CampeonatoModel();
							$campeonato->setId($_REQUEST['idcampeonato']);
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

							for($i = 0; $i < $N; $i++){
								$catcamp = new CampeonatoCategoriaModel();
								$catcamp->setId($cat[$i]);
								$catcampMapper = new CampeonatoCategoriaMapper();
								$respuesta = $catcampMapper->DELETE($catcamp);
							}

							$campeonato = new CampeonatoModel();
							$campeonato->setId($_REQUEST['idcampeonato']);
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
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						$campeonatoMapper = new CampeonatoMapper();
						$datos = $campeonatoMapper->consultarDatos($campeonato);
						$categorias = $campeonatoMapper->getCategoriasByCampeonato($campeonato);
						require_once('Views/campeonato/campeonatoDetailsView.php');
						(new CampeonatoDetailsView(SessionMessage::getMessage(), SessionMessage::getErrores(),'',$datos,'',$categorias,''))->render();
						break;
					

					case 'clasificacionCampeonato':
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						$campeonatoMapper = new CampeonatoMapper();
						$parejas = $campeonatoMapper->getParejasByCampeonato($campeonato);
						$datos = $campeonatoMapper->consultarDatos($campeonato); 
						require_once('Views/campeonato/clasificacionCampeonatoView.php');
						(new ClasificacionCampeonatoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$parejas,$datos))->render();
						break;


					case 'clasificacionCategoria':
						$catcamp = new CampeonatoCategoriaModel();
						$catcamp->setId($_REQUEST['idcatcamp']);
						$catcampMapper = new CampeonatoCategoriaMapper();
						$parejas = $catcampMapper->getParejasByCategoria($catcamp); 
						$datos = $catcampMapper->getDatosCampeonatoYCategoria($catcamp);
						require_once('Views/campeonato/clasificacionCategoriaView.php');
						(new ClasificacionCategoriaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$parejas,$datos))->render();
						break;


					case 'crearGrupos':
						$campeonato = new CampeonatoModel($_REQUEST['idcampeonato']);
						$categorias = (new CampeonatoCategoriaMapper())->getCategorias($campeonato);
						
						foreach($categorias as $categoria){
							(new GrupoMapper())->generarGrupos($categoria);
						}

						header('Location: index.php?controller=adminCampeonatos');
						break;


					default: 
						break;

				}
			} else { //mostrar todos los elementos
				$campeonatoMapper = new CampeonatoMapper();
				$listaCampeonatos = $campeonatoMapper->mostrarTodos(); 
				require_once('Views/campeonato/campeonatoView.php');
				(new CampeonatoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaCampeonatos))->render();
			}
		}
	}

 ?>
