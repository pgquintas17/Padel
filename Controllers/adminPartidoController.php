<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';
	require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

	class AdminPartidoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if ($_POST){
							try {
								require_once('Models/partidoModel.php');
								$partido = new PartidoModel('','',$_POST["inputHora"],$_POST["inputFecha"],'','','','','','');
								$errores =  $partido->validarRegistro();
								require_once('Mappers/partidoMapper.php');
                            	$partidoMapper = new PartidoMapper();
								$respuesta = $partidoMapper->ADD($partido);

								SessionMessage::setMessage($respuesta);
								header('Location: index.php?controller=adminPartidos');
							}
							catch (ValidationException $e){
								SessionMessage::setErrores($e->getErrores());
								SessionMessage::setMessage($e->getMessage());
								header('Location: index.php?controller=adminPartidos&action=ADD');
							}
						}else{
							require_once('Views/adminPartidoView.php');
							header('Location: index.php?controller=adminPartidos');
						}
						break;
						

					case 'DELETE': 
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['id_partido']);
						require_once('Mappers/partidoMapper.php');
						$partidoMapper = new PartidoMapper();
						$respuesta = $partidoMapper->DELETE($partido); 
						SessionMessage::setMessage("Partido eliminado."); 
						header('Location: index.php?controller=adminPartidos');
						break;
						

					case 'DETAILS': 
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['id_partido']);
						require_once('Mappers/partidoMapper.php');
						$partidoMapper = new PartidoMapper();
						$datos = $partidoMapper->consultarDatos($partido);
						require_once('Views/partidoDetailsView.php');
						(new PartidoDetailsView('','','',$datos))->render();
                        break;


                    case 'PROMOCION':
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
                        $partido->setId($_REQUEST['idpartido']);
						require_once('Mappers/partidoMapper.php');
						$partidoMapper = new PartidoMapper();
						$partidoMapper->cambiarPromocion($partido);
						header('Location: index.php?controller=adminPartidos'); 
						break;
                        
                    
                    case 'CERRAR':
                        echo "nada";
                        break;
                    

                    case 'RESULTADO':
                        echo "nada";
                        break;


					default: 
						header('Location: index.php?controller=adminPartidos');
						break;

				}
			} else { //mostrar todos los elementos
				require_once('Mappers/partidoMapper.php');
				$partidoMapper = new PartidoMapper();
				$listaPartidos = $partidoMapper->mostrarTodos(); 
				require_once('Views/adminPartidoView.php');
				(new AdminPartidoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaPartidos))->render();
			}
		}
	}

 ?>
