<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';
	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");

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
								$validacion = $partidoMapper->validarUsuario($partido,$usuario);
								var_dump($validacion);
								if($validacion){
									$respuesta = $partidoMapper->añadirParticipante($partido,$usuario);
									SessionMessage::setMessage($respuesta);
									header('Location: index.php');
									
								}
								else{
									SessionMessage::setMessage("Ya estás anotado en este partido.");
									header('Location: index.php');
								}
							
						}else{
							echo "else";
							header('Location: index.php');
						}
						break;
						

					/* case 'BORRARSE': 
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['id_partido']);
						require_once('Mappers/partidoMapper.php');
						$partidoMapper = new PartidoMapper();
						$respuesta = $partidoMapper->DELETE($partido); 
						SessionMessage::setMessage("Partido eliminado."); 
						header('Location: index.php?controller=partidos');
						break; */
						

					/* case 'DETAILS': 
						require_once('Models/partidoModel.php');
						$partido = new PartidoModel();
						$partido->setId($_REQUEST['id_partido']);
						require_once('Mappers/partidoMapper.php');
						$partidoMapper = new PartidoMapper();
						$datos = $partidoMapper->consultarDatos($partido);
						require_once('Views/partidoDetailsView.php');
						(new PartidoDetailsView('','','',$datos))->render();
                        break; */


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
