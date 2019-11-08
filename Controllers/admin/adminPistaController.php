<?php

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	
	class AdminPistaController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if ($_POST){
							require_once('Models/pistaModel.php');
							$pista = new PistaModel();
							$pista->setId($_POST["inputID"]);
							$pista->setEstado("0");
                            require_once('Mappers/pistaMapper.php');
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
							require_once('Views/adminPistaView.php');
							(new adminPistaView(SessionMessage::getMessage()))->render();
						}
						break;
						

					case 'ESTADO':
						require_once('Models/pistaModel.php');
						$pista = new PistaModel();
                        $pista->setId($_REQUEST['idpista']);
						require_once('Mappers/pistaMapper.php');
						$pistaMapper = new PistaMapper();
						$respuesta = $pistaMapper->cambiarEstado($pista);
						if($respuesta){
							header('Location: index.php?controller=adminPistas');
						}
						else{
							echo "error";
						} 
						break;

					case 'RESERVAS':
						require_once('Models/pistaModel.php');
						$pista = new PistaModel();
						$pista->setId($_REQUEST['idpista']);
						require_once('Mappers/reservaMapper.php');
						$reservaMapper = new ReservaMapper();
						$lista = $reservaMapper->getReservasByPista($pista);
						require_once('Views/adminReservaPistaView.php');
						(new AdminReservaPistaView(SessionMessage::getMessage(),SessionMessage::getErrores(),'',$_REQUEST['idpista'],'',$lista))->render();
						break;


					default: 
						header('Location: index.php?controller=adminPistas');
						break;

				}
            } else { //mostrar todos los elementos
				require_once('Mappers/pistaMapper.php');
				$pistaMapper = new PistaMapper();
				$listaPistas = $pistaMapper->mostrarTodos();
				require_once('Views/adminPistaView.php');
				(new AdminPistaView(SessionMessage::getMessage(),SessionMessage::getErrores(),'','',$listaPistas))->render();
			}
		}
	}

 ?>
