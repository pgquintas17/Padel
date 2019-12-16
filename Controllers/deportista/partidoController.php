<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once("Services/Utils.php");
	require_once('Models/usuarioModel.php');
	require_once('Mappers/UsuarioMapper.php');
	require_once('Models/partidoModel.php');
	require_once('Mappers/partidoMapper.php');
	require_once('Models/reservaModel.php');
	require_once('Mappers/reservaMapper.php');
	require_once('Mappers/enfrentamientoMapper.php');
	require_once('Mappers/pistaMapper.php');


	class PartidoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'APUNTARSE': 
						$usuario = $_SESSION["Usuario"];
						$partido = new PartidoModel();
						$partido->setId($_REQUEST["idpartido"]);
						$partidoMapper = new PartidoMapper();
						$reserva = new ReservaModel();
						$reserva->setLogin($_SESSION['Usuario']->getLogin());
						$reserva->setHora($partidoMapper->getHoraById($partido));
						$reserva->setFecha($partidoMapper->getFechaById($partido));
						$reservaMapper = new ReservaMapper();
						$validacion = Utils::validarDisponibilidad($_SESSION['Usuario']->getLogin(),$partidoMapper->getFechaById($partido),$partidoMapper->getHoraById($partido));
						if($validacion){
							$respuesta = $partidoMapper->añadirParticipante($partido,$usuario);
							$numPlazas = $partidoMapper->getNumPlazasLibres($_REQUEST["idpartido"]);
							if($numPlazas == 0){
								$login = $partidoMapper->getCreadorById($partido);;
								$reserva->setLogin($login);
								$reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
								$pistaMapper = new PistaMapper();
								$pistasActivas = $pistaMapper->getNumPistasActivas();
								if($reservasEnFecha == $pistasActivas){
									$partidoMapper->DELETE($partido);
									SessionMessage::setMessage("No hay pistas disponibles para ese día y hora. El partido se ha eliminado.");
									header('Location: index.php');
								}
								else{
									$idPista = $pistaMapper->findPistaLibre($reserva);
									$reserva->setIdPista($idPista);
									$reservaMapper->ADD($reserva);
									$partido->setIdReserva($reservaMapper->getIdReserva($reserva));
									$partidoMapper->añadirReserva($partido);
									SessionMessage::setMessage($respuesta);
									header('Location: index.php');
								}
							}
							else{
								SessionMessage::setMessage($respuesta);
								header('Location: index.php');
							}
						}
						else{
							SessionMessage::setMessage("Ya estás anotado en este partido o tienes otro partido/reserva en ese día y hora.");
							header('Location: index.php');
						}
						break;
						

					case 'borrar': 
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['idpartido']);
						$partidoMapper = new PartidoMapper();
						$fecha = $partidoMapper->getFechaById($partido);

						$hoy = date('Y-m-d');
						$limit = date_create($fecha);
						date_sub($limit, date_interval_create_from_date_string('1 day'));
						$limite = date_format($limit, 'Y-m-d');

						if($hoy >= $limite){
							SessionMessage::setMessage("No se puede cancelar la inscripción con tan poca antelación."); 
							header('Location: index.php?controller=perfil');	
						}
						else{

							$numPlazas = $partidoMapper->getNumPlazasLibres($_REQUEST["idpartido"]);
							if($numPlazas == 0){
								$partidoMapper->borrarReserva($partido);
							}
							$respuesta = $partidoMapper->cancelarInscripcion($partido,$_SESSION['Usuario']); 
							SessionMessage::setMessage($respuesta); 
							header('Location: index.php?controller=perfil');
						}
						break;
					
					default:
						header('Location: index.php');
						break;

				}
			} else {
				header('Location: index.php');
			}
		}
	}

 ?>
