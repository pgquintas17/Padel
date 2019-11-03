<?php

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
								echo "Pista añadida. Recuerda activarla para su uso.";
							}
							else{
								echo "la has liado";
							}
							header('Location: index.php?controller=adminPista');
						}else{
							require_once('Views/adminPistaView.php');
							(new adminPistaView())->render();
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
							header('Location: index.php?controller=adminPista');
						}
						else{
							echo "error";
						} 
						break;

					case 'RESERVAS':
						require_once('Models/pistaModel.php');
						$pista = new PistaModel();
                        $pista->setId($_REQUEST['idpista']);
						require_once('Mappers/pistaMapper.php');
						$pistaMapper = new PistaMapper();
						$respuesta = $pistaMapper->cambiarEstado($pista);
						if($respuesta){
							header('Location: index.php?controller=adminPista');
						}
						else{
							echo "error";
						} 
						break;


					default: 
						header('Location: index.php?controller=adminPista');
						break;

				}
            } else { //mostrar todos los elementos
				require_once('Mappers/pistaMapper.php');
				$pistaMapper = new PistaMapper();
				$listaPistas = $pistaMapper->mostrarTodos();
				require_once('Views/adminPistaView.php');
				(new AdminPistaView('','','','',$listaPistas))->render();
			}
		}
	}

 ?>
