<?php	
	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/partidoModel.php');
	require_once('Mappers/partidoMapper.php');
	require_once('Models/reservaModel.php');
	require_once('Mappers/reservaMapper.php');
	require_once('Mappers/pistaMapper.php');
	require_once('Mappers/horaMapper.php');


	class AdminPartidoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						try {
							$partido = new PartidoModel('',$_POST["hora"],$_POST["fecha"],'','','','','','');
							$errores =  $partido->validarRegistro();
							$partidoMapper = new PartidoMapper();
							$reserva = new ReservaModel();
							$reserva->setHora($_POST["inputHora"]);
							$reserva->setFecha($_POST["inputFecha"]);
							$reservaMapper = new ReservaMapper();
							$reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
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
							header('Location: index.php?controller=adminPartidos&action=fecha');
						}
						break;

					case 'fecha':	
						if(isset($_REQUEST["fecha"])){
							$horaMapper = new HoraMapper();
							$listaHoras = $horaMapper->mostrarTodos();
							require_once('Views/partido/partidoADDView.php');
							(new PartidoADDView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,$_REQUEST["fecha"]))->render();
						}
						else{
							$horaMapper = new HoraMapper();
							$listaHoras = $horaMapper->mostrarTodos();
							require_once('Views/partido/partidoADDView.php');
							(new PartidoADDView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,''))->render();
						}
						break;
						

					case 'DELETE': 
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['idpartido']);
						$partidoMapper = new PartidoMapper();
						$respuesta = $partidoMapper->DELETE($partido); 
						SessionMessage::setMessage($respuesta); 
						header('Location: index.php?controller=adminPartidos');
						break;
						

					case 'DETAILS': 
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['idpartido']);
						$partidoMapper = new PartidoMapper();
						$datos = $partidoMapper->consultarDatos($partido);
						require_once('Views/partido/partidoDetailsView.php');
						(new PartidoDetailsView('','','',$datos))->render();
                        break;


                    case 'PROMOCION':
						$partido = new PartidoModel();
                        $partido->setId($_REQUEST['idpartido']);
						$partidoMapper = new PartidoMapper();
						$partidoMapper->cambiarPromocion($partido);
						header('Location: index.php?controller=adminPartidos'); 
						break;
                    

					default: 
						header('Location: index.php?controller=adminPartidos');
						break;

				}
			} else { //mostrar todos los elementos
				$partidoMapper = new PartidoMapper();
				$listaPartidos = $partidoMapper->mostrarTodos();
				$horaMapper = new HoraMapper();
				$listaHoras = $horaMapper->mostrarTodos(); 
				require_once('Views/partido/adminPartidoView.php');
				(new AdminPartidoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaPartidos,'',$listaHoras))->render();
			}
		}
	}

 ?>
