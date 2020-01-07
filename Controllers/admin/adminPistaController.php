<?php

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/pistaModel.php');
	require_once('Mappers/pistaMapper.php');
	require_once('Models/reservaModel.php');
	require_once('Mappers/reservaMapper.php');
	require_once('Mappers/partidoMapper.php');
	require_once('Mappers/usuarioMapper.php');
	
	class AdminPistaController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if ($_POST){
							try {
								$pista = new PistaModel();
								$pista->setId($_POST["inputID"]);
								$pista->setTipo($_POST["inputTipo"]);
								$pista->setEstado("0");
								$errores =  $pista->validarRegistro();
								$pistaMapper = new PistaMapper();
								$respuesta = $pistaMapper->ADD($pista);
								SessionMessage::setMessage($respuesta);
								header('Location: index.php?controller=adminPistas');
							}
							catch (ValidationException $e){
								SessionMessage::setErrores($e->getErrores());
								SessionMessage::setMessage($e->getMessage());
								header('Location: index.php?controller=adminPistas');
							}
						}else{
							require_once('Views/pista/adminPistaView.php');
							(new AdminPistaView(SessionMessage::getMessage()))->render();
						}
						break;
						

					case 'ESTADO':
						$pista = new PistaModel();
                        $pista->setId($_REQUEST['idpista']);
						$pistaMapper = new PistaMapper();
						$respuesta = $pistaMapper->cambiarEstado($pista);
						
						if($_REQUEST['estado'] == 1){
							$partidoMapper = new PartidoMapper();
							$partidos = $partidoMapper->getPartidoByPista($_REQUEST['idpista']);
							
							foreach($partidos as $partido){
								$reserva = new ReservaModel();
								$reserva->setId($partido->getIdReserva());
								$emails = $partidoMapper->getEmailParticipantes($partido);

								foreach($emails as $email){
									$to_email_address = $email;
									$subject = 'Partido cancelado.';
									$message = '<html><head></head><body>Hola,<br>Te informamos de que debido a que un problema con la pista tu partido del d&#237;a ' . date('d/m',strtotime($partido->getFecha())) . ' a las ' . date('H:i',strtotime($partido->getHora())) . ' ha sido cancelado.<br>Lamentamos las molestias. <br><br>Un saludo,<br>Padelweb.</p></body></html>';
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									$headers .= 'From: Padelweb <noreply@padelweb.com>' . "\r\n";
									mail($to_email_address,$subject,$message,$headers);
								}

								$partidoMapper->DELETE($partido);
								$reservaMapper = new ReservaMapper();
								$reservaMapper->DELETE($reserva);
							}

							$reservaMapper = new ReservaMapper();
							$reservas = $reservaMapper->getReservaCanceladaByPista($_REQUEST['idpista']);

							foreach($reservas as $reserva){

								$email = (new UsuarioMapper())->getEmailByLogin($reserva->getLogin());

								$to_email_address = $email;
								$subject = 'Reserva cancelada.';
								$message = '<html><head></head><body>Hola,<br>Te informamos de que debido a que un problema con la pista tu reserva del d&#237;a ' . date('d/m',strtotime($reserva->getFecha())) . ' a las ' . date('H:i',strtotime($reserva->getHora())) . ' ha sido cancelada.<br>Lamentamos las molestias. <br><br>Un saludo,<br>Padelweb.</p></body></html>';
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
								$headers .= 'From: Padelweb <noreply@padelweb.com>' . "\r\n";
								mail($to_email_address,$subject,$message,$headers);

								$reservaMapper->DELETE($reserva);

							}
						}

						header('Location: index.php?controller=adminPistas');
						break;

					case 'RESERVAS':
						$pista = new PistaModel();
						$pista->setId($_REQUEST['idpista']);
						$reservaMapper = new ReservaMapper();
						$lista = $reservaMapper->getReservasByPista($pista);
						require_once('Views/reserva/adminReservaPistaView.php');
						(new AdminReservaPistaView(SessionMessage::getMessage(),SessionMessage::getErrores(),'',$_REQUEST['idpista'],'',$lista))->render();
						break;


					default: 
						header('Location: index.php?controller=adminPistas');
						break;

				}
            } else { //mostrar todos los elementos
				$pistaMapper = new PistaMapper();
				$listaPistas = $pistaMapper->mostrarTodos();
				require_once('Views/pista/adminPistaView.php');
				(new AdminPistaView(SessionMessage::getMessage(),SessionMessage::getErrores(),'','',$listaPistas))->render();
			}
		}
	}

 ?>
