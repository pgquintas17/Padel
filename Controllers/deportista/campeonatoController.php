<?php	

	require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

	class CampeonatoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

                    case 'inscripcion': 
						if(isset($_REQUEST['idcampeonato'])){
							if ($_POST){
								$hoy = date('Y-m-d H:i:s');
								require_once('Models/campeonatoModel.php');
								$campeonato = new CampeonatoModel();
								$campeonato->setId($_REQUEST['idcampeonato']);
								require_once('Mappers/campeonatoMapper.php');
								$campeonatoMapper = new CampeonatoMapper();
								$fechaFinInsc = $campeonatoMapper->getFechaFinInsById($campeonato);

								if($fechaFinInsc < $hoy){
									SessionMessage::setMessage("El plazo de inscripción para este campeonato ha finalizado.");
									header('Location: index.php?');
								}
								else{
									try {
										require_once('Models/parejaModel.php');
										$pareja = new ParejaModel();
										$pareja->setNombre($_REQUEST['nombre']);
										$pareja->setCapitan($_SESSION['Usuario']->getLogin());
										$pareja->setMiembro($_REQUEST['miembro']);
										$pareja->setCatCamp($_REQUEST['categoria']);
										$pareja->setFechaInscrip($hoy);
										$errores =  $pareja->validarRegistro();
										require_once('Mappers/parejaMapper.php');
										$parejaMapper = new ParejaMapper();
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
							}else{
								require_once('Models/campeonatoModel.php');
								$campeonato = new CampeonatoModel();
								$campeonato->setId($_REQUEST['idcampeonato']);
								require_once('Mappers/campeonatoMapper.php');
								$campeonatoMapper = new CampeonatoMapper();
								$categorias = $campeonatoMapper->getCategoriasByCampeonato($campeonato);
								$camp = array($campeonatoMapper->getNombreById($campeonato),$_REQUEST['idcampeonato']);;
								require_once('Views/inscripcionCampeonatoView.php');
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
							require_once('Models/parejaModel.php');
							$pareja = new ParejaModel();
							$pareja->setId($_REQUEST['idpareja']);
							require_once('Mappers/parejaMapper.php');
							$parejaMapper = new ParejaMapper();
							$respuesta = $parejaMapper->DELETE($pareja); 
							SessionMessage::setMessage($respuesta);
							header('Location: index.php?controller=perfil');
						}
						break;
						

                    case 'DETAILS': 
                        echo "details";
						/* require_once('Models/usuarioModel.php');
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['username']);
						require_once('Mappers/usuarioMapper.php');
						$usuarioMapper = new UsuarioMapper();
						$datos = $usuarioMapper->consultarDatos($usuario);
						require_once('Views/usuarioDetailsView.php');
						(new UsuarioDetailsView('','','',$datos))->render(); */
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
