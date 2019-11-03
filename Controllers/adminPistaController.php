<?php

	class AdminPistaController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
					//echo "CASI YAAAY.    ";
						if ($_POST){
							//echo "YAYYYYY";
							//echo "REQUEST: "; var_dump($_REQUEST); echo "     ";
							require_once('Models/pistaModel.php');
							$pista = new PistaModel($_POST["idpista"],0);
                            require_once('Mappers/pistaMapper.php');
                            $pistaMapper = new PistaMapper();
                            $pistaMapper->ADD($pista); 
                            echo "Pista añadida. Recuerda activarla para su uso.";
							
							header('Location: index.php?controller=adminPista');
						}else{
							//echo "NOS PASAMOS DE YAAAY.    ";
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
