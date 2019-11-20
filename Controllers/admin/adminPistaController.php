<?php

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/pistaModel.php');
	require_once('Mappers/pistaMapper.php');
	require_once('Mappers/reservaMapper.php');
	
	class AdminPistaController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if ($_POST){
							$pista = new PistaModel();
							$pista->setId($_POST["inputID"]);
							$pista->setEstado("0");
                            $pistaMapper = new PistaMapper();
							$respuesta = $pistaMapper->ADD($pista);
							if($respuesta){
								SessionMessage::setMessage("La pista ha sido añadida. Recuerda activarla para su uso.");
							}
							else{
								SessionMessage::setMessage("Se ha producido un error.");
							}
							header('Location: index.php?controller=adminPistas');
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
