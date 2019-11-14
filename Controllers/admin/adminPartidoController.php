<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';
	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");

	class AdminPartidoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if ($_POST){
							try {
								require_once('Models/partidoModel.php');
								$partido = new PartidoModel('',$_POST["inputHora"],$_POST["inputFecha"],'','','','','','');
								$errores =  $partido->validarRegistro();
								require_once('Mappers/partidoMapper.php');
								$partidoMapper = new PartidoMapper();
								require_once('Models/reservaModel.php');
								$reserva = new ReservaModel();
								$reserva->setHora($_POST["inputHora"]);
								$reserva->setFecha($_POST["inputFecha"]);
								require_once('Mappers/reservaMapper.php');
								$reservaMapper = new ReservaMapper();
								$reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
								require_once('Mappers/pistaMapper.php');
								$pistaMapper = new PistaMapper();
								$pistasActivas = $pistaMapper->getNumPistasActivas(); 
								if($reservasEnFecha == $pistasActivas){
									SessionMessage::setMessage("No hay pistas disponibles para ese día y hora.");
									header('Location: index.php?controller=adminPartidos');
								}
								else{
									$respuesta = $partidoMapper->ADD($partido);
									SessionMessage::setMessage($respuesta);
									header('Location: index.php?controller=adminPartidos');
								}
							}
							catch (ValidationException $e){
								SessionMessage::setErrores($e->getErrores());
								SessionMessage::setMessage($e->getMessage());
								header('Location: index.php?controller=adminPartidos&action=ADD');
							}
						}else{
							require_once('Views/adminPartidoView.php');
							header('Location: index.php?controller=adminPartidos');
						}
						break;
						

					case 'DELETE': 
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['idpartido']);
						require_once('Mappers/partidoMapper.php');
						$partidoMapper = new PartidoMapper();
						$respuesta = $partidoMapper->DELETE($partido); 
						SessionMessage::setMessage($respuesta); 
						header('Location: index.php?controller=adminPartidos');
						break;
						

					case 'DETAILS': 
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['idpartido']);
						require_once('Mappers/partidoMapper.php');
						$partidoMapper = new PartidoMapper();
						$datos = $partidoMapper->consultarDatos($partido);
						require_once('Views/partidoDetailsView.php');
						(new PartidoDetailsView('','','',$datos))->render();
                        break;


                    case 'PROMOCION':
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
                        $partido->setId($_REQUEST['idpartido']);
						require_once('Mappers/partidoMapper.php');
						$partidoMapper = new PartidoMapper();
						$partidoMapper->cambiarPromocion($partido);
						header('Location: index.php?controller=adminPartidos'); 
						break;
                    

					default: 
						header('Location: index.php?controller=adminPartidos');
						break;

				}
			} else { //mostrar todos los elementos
				require_once('Mappers/partidoMapper.php');
				$partidoMapper = new PartidoMapper();
				$listaPartidos = $partidoMapper->mostrarTodos();
				require_once('Mappers/horaMapper.php');
				$horaMapper = new HoraMapper();
				$listaHoras = $horaMapper->mostrarTodos(); 
				require_once('Views/adminPartidoView.php');
				(new AdminPartidoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaPartidos,'',$listaHoras))->render();
			}
		}
	}

 ?>
