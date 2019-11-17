<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/campeonatoModel.php');
	require_once('Mappers/campeonatoMapper.php');
	require_once('Models/campeonatoCategoriaModel.php');
	require_once('Mappers/campeonatoCategoriaMapper.php');
	require_once('Models/enfrentamientoModel.php');
	require_once('Mappers/enfrentamientoMapper.php');
	require_once('Models/parejaModel.php');
	require_once('Mappers/parejaMapper.php');
	require_once('Models/grupoModel.php');
	require_once('Mappers/grupoMapper.php');

	class CampeonatoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

                    case 'inscripcion': 
						if(isset($_REQUEST['idcampeonato'])){
							if ($_POST){
								$hoy = date('Y-m-d H:i:s');
								$campeonato = new CampeonatoModel();
								$campeonato->setId($_REQUEST['idcampeonato']);
								$campeonatoMapper = new CampeonatoMapper();
								$fechaFinInsc = $campeonatoMapper->getFechaFinInsById($campeonato);

								if($fechaFinInsc < $hoy){
									SessionMessage::setMessage("El plazo de inscripción para este campeonato ha finalizado.");
									header('Location: index.php?');
								}
								else{
									$catcamp = new CampeonatoCategoriaModel();
									$catcamp->setId($_REQUEST['categoria']);
									$catcampMapper = new CampeonatoCategoriaMapper();
									$numParejas = $catcampMapper->getNumParejas($catcamp);
									if($numParejas == 96){
										SessionMessage::setMessage("No quedan plazas disponibles en esta categoría.");
										header('Location: index.php?');
									}else{
										try {
											$pareja = new ParejaModel();
											$pareja->setNombre($_REQUEST['nombre']);
											$pareja->setCapitan($_SESSION['Usuario']->getLogin());
											$pareja->setMiembro($_REQUEST['miembro']);
											$pareja->setCatCamp($_REQUEST['categoria']);
											$pareja->setFechaInscrip($hoy);
											$errores =  $pareja->validarRegistro();
											$parejaMapper = new ParejaMapper();
											$catcampMapper->addParejas($catcamp);
											$respuesta = $parejaMapper->ADD($pareja);
											
											SessionMessage::setMessage($respuesta);
											header('Location: index.php?');
										}
										catch (ValidationException $e){
											SessionMessage::setErrores($e->getErrores());
											SessionMessage::setMessage($e->getMessage());
											$goto = 'Location: index.php?controller=campeonatos&action=inscripcion&idcampeonato='.$_REQUEST['idcampeonato'];
											header($goto);
										}
									}
								}
							}else{
								$campeonato = new CampeonatoModel();
								$campeonato->setId($_REQUEST['idcampeonato']);
								$campeonatoMapper = new CampeonatoMapper();
								$categorias = $campeonatoMapper->getCategoriasByCampeonato($campeonato);
								$camp = array($campeonatoMapper->getNombreById($campeonato),$_REQUEST['idcampeonato']);;
								require_once('Views/campeonato/inscripcionCampeonatoView.php');
								(new InscripcionCampeonatoView(SessionMessage::getMessage(),SessionMessage::getErrores(),'','',$categorias,$camp))->render();
							}
						}else{
							header('Location: index.php');
							break;
						}
						break;
						

                    case 'borrar': 
						
						$hoy = date('Y-m-d H:i:s');

						if($_REQUEST['fechafininscripciones'] < $hoy){
							SessionMessage::setMessage("El plazo de inscripción ha cerrado. No puedes borrar tu inscripción al campeonato.");
							header('Location: index.php?controller=perfil');
						}
						else{
							$pareja = new ParejaModel();
							$pareja->setId($_REQUEST['idpareja']);
							$parejaMapper = new ParejaMapper();
							$respuesta = $parejaMapper->DELETE($pareja); 
							SessionMessage::setMessage($respuesta);
							header('Location: index.php?controller=perfil');
						}
						break;
						

                    case 'DETAILS': 
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						$campeonatoMapper = new CampeonatoMapper();
						$datos = $campeonatoMapper->consultarDatos($campeonato);
						require_once('Views/campeonato/campeonatoDetailsView.php');
						$categorias = $campeonatoMapper->getCategoriasByCampeonato($campeonato);
						(new CampeonatoDetailsView('','','',$datos,'',$categorias,''))->render();
						break;


					case 'grupo':
						$grupo = new GrupoModel();
						$grupo->setId($_REQUEST['idgrupo']);
						$grupoMapper = new GrupoMapper();
						$parejas = $grupoMapper->getParejasByGrupo($grupo); 
						$enfrentamientos = $grupoMapper->getEnfrentamientosByGrupo($grupo);
						$datos = $grupoMapper->getDatosGrupo($grupo);
						require_once('Views/campeonato/grupoDetailsView.php');
						(new GrupoDetailsView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$enfrentamientos,'',$parejas,$datos))->render();
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
					

					case 'clasificacionCampeonato':
						$campeonato = new CampeonatoModel();
						$campeonato->setId($_REQUEST['idcampeonato']);
						$campeonatoMapper = new CampeonatoMapper();
						$parejas = $campeonatoMapper->getParejasByCampeonato($campeonato);
						$datos = $campeonatoMapper->consultarDatos($campeonato);  
						require_once('Views/campeonato/clasificacionCampeonatoView.php');
						(new ClasificacionCampeonatoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$parejas,$datos))->render();
						break;


					case 'enfDETAILS': 
						$enfrentamiento = new EnfrentamientoModel();
						$enfrentamiento->setId($_REQUEST['idenfrentamiento']);
						$enfrentamientoMapper = new EnfrentamientoMapper();
						$datos = $enfrentamientoMapper->consultarDatos($enfrentamiento);
						require_once('Views/campeonato/enfrentamientoDetailsView.php');
						(new EnfrentamientoDetailsView('','','',$datos))->render();
						break;
					

					default: 
						echo "hey, estoy viniendo aquí";
						header('Location: index.php?controller=adminUsuarios');
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
