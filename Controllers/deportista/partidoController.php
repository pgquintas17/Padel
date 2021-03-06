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
	require_once('Mappers/horaMapper.php');


	class PartidoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 

						$partidosActivosCreador = (new PartidoMapper())->getNumPartidosByCreador($_SESSION['Usuario']->getLogin());

						if($partidosActivosCreador == 3){
							SessionMessage::setMessage('Has alcanzado el número máximo posibles de partidos de creación propia.');
							header('Location: index.php');

						}else{
							
							try {
								$partido = new PartidoModel('',$_POST["hora"],$_POST["fecha"],1,$_SESSION['Usuario']->getLogin(),'','','','',$_SESSION['Usuario']->getLogin());
								$errores =  $partido->validarRegistro();
								$partidoMapper = new PartidoMapper();
								$reserva = new ReservaModel();
								$reserva->setHora($_POST["hora"]);
								$reserva->setFecha($_POST["fecha"]);
								$reserva->setLogin($_SESSION['Usuario']->getLogin());

								$validacion = Utils::validarDisponibilidad($_SESSION['Usuario']->getLogin(),$_POST["fecha"],$_POST["hora"]);
								if($validacion){
									$reservaMapper = new ReservaMapper();
									$reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
									$pistaMapper = new PistaMapper();
									$pistasActivas = $pistaMapper->getNumPistasActivas();
									
									if($reservasEnFecha >= $pistasActivas){
										SessionMessage::setMessage("No hay pistas disponibles para ese día y hora.");
										header('Location: index.php');
									}
									else{
										$respuesta = $partidoMapper->ADDDeportista($partido);
										SessionMessage::setMessage($respuesta);
										header('Location: index.php');
									}
								}
								else{
									SessionMessage::setMessage("Ya tienes un partido/reserva en ese día y hora.");
									header('Location: index.php');
								}
							}
							catch (ValidationException $e){
								SessionMessage::setErrores($e->getErrores());
								SessionMessage::setMessage($e->getMessage());
								header('Location: index.php?controller=partidos&action=fecha');
							}
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
								
								if($reservasEnFecha >= $pistasActivas){

									$emails = $partidoMapper->getEmailParticipantes($partido);

									$fecha = $partidoMapper->getFechaById($partido);
									$hora = $partidoMapper->getHoraById($partido);

									foreach($emails as $email){
										$to_email_address = $email;
										$subject = 'Partido cancelado.';
										$message = '<html><head></head><body>Hola,<br>Te informamos de que debido a que no quedan pistas libres tu partido del d&#237;a ' . date('d/m',strtotime($fecha)) . ' a las ' . date('H:i',strtotime($hora)) . ' ha sido cancelado.<br>Lamentamos las molestias. <br><br>Un saludo,<br>Padelweb.</p></body></html>';
										$headers  = 'MIME-Version: 1.0' . "\r\n";
										$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
										$headers .= 'From: Padelweb <noreply@padelweb.com>' . "\r\n";
										mail($to_email_address,$subject,$message,$headers);
									}

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

									$emails = $partidoMapper->getEmailParticipantes($partido);

									$fecha = $partidoMapper->getFechaById($partido);
									$hora = $partidoMapper->getHoraById($partido);
								
									foreach($emails as $email){
										$to_email_address = $email;
										$subject = 'Reservada pista para tu partido.';
										$message = '<html><head></head><body>Hola,<br>Te informamos de que se han completado las plazas para tu partido del d&#237;a ' . date('d/m',strtotime($fecha)) . ' a las ' . date('H:i',strtotime($hora)) . '.<br>Se llevar&#225; acabo en la pista ' . $idPista . '<br><br>Un saludo,<br>Padelweb.</p></body></html>';
										$headers  = 'MIME-Version: 1.0' . "\r\n";
										$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
										$headers .= 'From: Padelweb <noreply@padelweb.com>' . "\r\n";
										mail($to_email_address,$subject,$message,$headers);
									}

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
						

					case 'desapuntarse': 
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

							$fecha = $partidoMapper->getFechaById($partido);
							$hora = $partidoMapper->getHoraById($partido);

							$numPlazas = $partidoMapper->getNumPlazasLibres($_REQUEST["idpartido"]);
							if($numPlazas == 0){
								$emails = $partidoMapper->getEmailParticipantes($partido);

								$creador = $partidoMapper->getCreadorByID($partido);

								if($creador == $_SESSION['Usuario']->getLogin()){
									var_dump($emails);
									$respuesta = $partidoMapper->DELETE($partido);
									foreach($emails as $email){
										$to_email_address = $email;
										$subject = 'Partido cancelado.';
										$message = '<html><head></head><body>Hola,<br>Te informamos de que tu partido del d&#237;a ' . date('d/m',strtotime($fecha)) . ' a las ' . date('H:i',strtotime($hora)) . ' ha sido cancelado.<br>Lamentamos las molestias. <br><br>Un saludo,<br>Padelweb.</p></body></html>';
										$headers  = 'MIME-Version: 1.0' . "\r\n";
										$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
										$headers .= 'From: Padelweb <noreply@padelweb.com>' . "\r\n";
										mail($to_email_address,$subject,$message,$headers);
									}
								}else{
									$respuesta = $partidoMapper->cancelarInscripcion($partido,$_SESSION['Usuario']);
									$partidoMapper->borrarReserva($partido);
									foreach($emails as $email){
										$to_email_address = $email;
										$subject = 'Reserva cancelada.';
										$message = '<html><head></head><body>Hola,<br>Te informamos de que debido a que alguien se ha desapuntado de tu partido del d&#237;a ' . date('d/m',strtotime($fecha)) . ' a las ' . date('H:i',strtotime($hora)) . ' la reserva ha sido cancelada. Cuando se vuelvan a completar las plazas te avisaremos con la nueva pista.<br>Lamentamos las molestias. <br><br>Un saludo,<br>Padelweb.</p></body></html>';
										$headers  = 'MIME-Version: 1.0' . "\r\n";
										$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
										$headers .= 'From: Padelweb <noreply@padelweb.com>' . "\r\n";
										mail($to_email_address,$subject,$message,$headers);
									}
								}	
							}
							else{
								$creador = $partidoMapper->getCreadorByID($partido);

								$emails = $partidoMapper->getEmailParticipantes($partido);

								var_dump($emails);

								if($creador == $_SESSION['Usuario']->getLogin()){
									$respuesta = $partidoMapper->DELETE($partido);
									foreach($emails as $email){
										$to_email_address = $email;
										$subject = 'Partido cancelado.';
										$message = '<html><head></head><body>Hola,<br>Te informamos de que tu partido del d&#237;a ' . date('d/m',strtotime($fecha)) . ' a las ' . date('H:i',strtotime($hora)) . ' ha sido cancelado.<br>Lamentamos las molestias. <br><br>Un saludo,<br>Padelweb.</p></body></html>';
										$headers  = 'MIME-Version: 1.0' . "\r\n";
										$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
										$headers .= 'From: Padelweb <noreply@padelweb.com>' . "\r\n";
										mail($to_email_address,$subject,$message,$headers);
									}
								}else{
									$respuesta = $partidoMapper->cancelarInscripcion($partido,$_SESSION['Usuario']); 
								}
							}
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
