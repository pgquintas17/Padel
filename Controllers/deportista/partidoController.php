<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';
	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once("Services/Utils.php");

	class PartidoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'APUNTARSE': 
						if ($_REQUEST["idpartido"]){
								require_once('Models/usuarioModel.php');
								$usuario = $_SESSION["Usuario"];
								require_once('Models/partidoModel.php');
								$partido = new PartidoModel();
								$partido->setId($_REQUEST["idpartido"]);
								require_once('Mappers/partidoMapper.php');
                            	$partidoMapper = new PartidoMapper();
								require_once('Models/reservaModel.php');
								$reserva = new ReservaModel();
								$reserva->setLogin($_SESSION['Usuario']->getLogin());
								$reserva->setHora($partidoMapper->getHoraById($partido));
								$reserva->setFecha($partidoMapper->getFechaById($partido));
								require_once('Mappers/reservaMapper.php');
								$reservaMapper = new ReservaMapper();
								$validacion1 = $partidoMapper->comprobarDisponibilidadUsuario($reserva);
								$validacion2 = $reservaMapper->comprobarDisponibilidadUsuario($reserva);
								if($validacion1 && $validacion2){
									$respuesta = $partidoMapper->añadirParticipante($partido,$usuario);
									$numPlazas = $partidoMapper->getNumPlazasLibres($_REQUEST["idpartido"]);
									if($numPlazas == 0){
										require_once('Models/UsuarioModel.php');
										require_once('Mappers/UsuarioMapper.php');
										$admin = (new UsuarioMapper())->getAdmin();
										$reserva->setLogin($admin->getLogin());
										$reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
										require_once('Mappers/pistaMapper.php');
										$pistaMapper = new PistaMapper();
										$pistasActivas = $pistaMapper->getNumPistasActivas();
										if($reservasEnFecha == $pistasActivas){
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
							
						}else{
							echo "else";
							header('Location: index.php');
						}
						break;
						

					case 'borrar': 
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['idpartido']);
						require_once('Mappers/partidoMapper.php');
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
						$respuesta = $partidoMapper->cancelarInscripcion($partido,$_SESSION['Usuario']); 
						SessionMessage::setMessage($respuesta); 
						header('Location: index.php?controller=perfil');
						}
						break;
					
					default: 
						echo "default";
						header('Location: index.php');
						break;

				}
			} else {
				echo "sin action";
				header('Location: index.php');
			}
		}
	}

 ?>
