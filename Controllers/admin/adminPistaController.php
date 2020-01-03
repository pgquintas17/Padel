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
