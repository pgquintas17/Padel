<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Mappers/reservaMapper.php');
	require_once('Models/reservaModel.php');
	require_once('Models/usuarioModel.php');
	require_once('Mappers/partidoMapper.php');
	require_once('Mappers/enfrentamientoMapper.php');
	require_once('Mappers/pistaMapper.php');
	require_once('Mappers/horaMapper.php');

	class ReservaPistaController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD':
                            $hoy = date('Y-m-d');
                            if($_POST["fecha"] <= $hoy){
                                SessionMessage::setMessage("No se puede reservar en fechas pasadas.");
                                header('Location: index.php?controller=reservas&action=reservar');
                            }
                            else{

								$maxReservas = 5;

								$reservaMapper = new ReservaMapper();
								$numReservas = $reservaMapper->getNumReservasActivasByLogin($_SESSION['Usuario']);

								if($numReservas == $maxReservas){
									SessionMessage::setMessage("Has llegado al máximo permitido de reservas activas.");
									header('Location: index.php');
								}
								else{
									$reserva = new ReservaModel();
									$reserva->setLogin($_SESSION['Usuario']->getLogin());
									$reserva->setFecha($_POST["fecha"]);
									$reserva->setHora($_POST["inputHora"]);
									$validacion = Utils::validarDisponibilidad($_SESSION['Usuario']->getLogin(),$_REQUEST['fecha'],$_REQUEST['inputHora']);
									if($validacion){
										$reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
										$pistaMapper = new PistaMapper();
										$pistasActivas = $pistaMapper->getNumPistasActivas();
										if($reservasEnFecha >= $pistasActivas){
											SessionMessage::setMessage("No hay pistas disponibles para ese día y hora.");
											header('Location: index.php?controller=reservas&action=reservar');
										}
										else{
											$idPista = $pistaMapper->findPistaLibre($reserva);
											$reserva->setIdPista($idPista);
											$reservaMapper->ADD($reserva);
											$reservaHecha = "La reserva ha sido registrada en la pista: " . $idPista;

											$to_email_address = $_SESSION['Usuario']->getEmail();
											$subject = 'Reserva de pista realizada.';
											$message = '<html><head></head><body>Hola,<br>Te informamos de que has reservado pista para la fecha ' . date('d/m',strtotime($_POST["fecha"])) . ' y hora ' . date('H:i',strtotime($_POST["inputHora"])) . '.<br>Tu reserva es en la pista ' . $idPista .'.<br>Recuerda que puedes cancelarla desde tu pefil. <br><br>Un saludo,<br>Padelweb.</p></body></html>';
											$headers  = 'MIME-Version: 1.0' . "\r\n";
											$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
											$headers .= 'From: noreply@padelweb.com';
											mail($to_email_address,$subject,$message,$headers);
											

											SessionMessage::setMessage($reservaHecha);
											header('Location: index.php?controller=reservas&action=reservar');
										}	
									}
									else{
										SessionMessage::setMessage("Tienes otra reserva/partido en ese día y hora.");
										header('Location: index.php?controller=reservas&action=reservar');
									}
								}
							}
						break;
						
						case 'reservar':	
                            if(isset($_REQUEST["fecha"])){
                                $horaMapper = new HoraMapper();
                                $listaHoras = $horaMapper->mostrarTodos();
                                require_once('Views/reserva/pistaReservarView.php');
                                (new PistaReservarView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,$_REQUEST["fecha"]))->render();
                            }
                            else{
                                $horaMapper = new HoraMapper();
                                $listaHoras = $horaMapper->mostrarTodos();
                                require_once('Views/reserva/pistaReservarView.php');
                                (new PistaReservarView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,''))->render();
                            }
							break;
						

					case 'borrar':
						$reserva = new ReservaModel();
						$reserva->setId($_REQUEST['idreserva']);
						$reservaMapper = new ReservaMapper();
						$fecha = $reservaMapper->getFechaById($reserva);
						$reserva->setLogin($_SESSION['Usuario']->getLogin());
						
						$hoy = date('Y-m-d');
						$limit = date_create($fecha);
						date_sub($limit, date_interval_create_from_date_string('1 day'));
						$limite = date_format($limit, 'Y-m-d');

						if($hoy >= $limite){
							SessionMessage::setMessage("No se puede cancelar la reserva con tan poca antelación."); 
							header('Location: index.php?controller=perfil');	
						}
						else{
							$respuesta = $reservaMapper->cancelarReserva($reserva); 
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
