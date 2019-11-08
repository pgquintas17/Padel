<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';
	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");

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
								require_once('Models/usuarioModel.php');
								$usuario = $_SESSION["Usuario"];
								require_once('Models/reservaModel.php');
                                $reserva = new ReservaModel();
                                $reserva->setLogin($_SESSION['Usuario']->getLogin());
                                $reserva->setFecha($_POST["fecha"]);
                                $reserva->setHora($_POST["inputHora"]);
								require_once('Mappers/reservaMapper.php');
								$reservaMapper = new ReservaMapper();
                                $validacion1 = $reservaMapper->comprobarDisponibilidadUsuario($reserva);
                                require_once('Mappers/partidoMapper.php');
                            	$partidoMapper = new PartidoMapper();
								$validacion2 = $partidoMapper->comprobarDisponibilidadUsuario($reserva);
								if($validacion1 && $validacion2){
									$reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
                                    require_once('Mappers/pistaMapper.php');
                                    $pistaMapper = new PistaMapper();
                                    $pistasActivas = $pistaMapper->getNumPistasActivas();
                                    if($reservasEnFecha == $pistasActivas){
                                        SessionMessage::setMessage("No hay pistas disponibles para ese día y hora.");
                                        header('Location: index.php?controller=reservas&action=reservar');
                                    }
                                    else{
                                        $idPista = $pistaMapper->findPistaLibre($reserva);
                                        $reserva->setIdPista($idPista);
                                        $reservaMapper->ADD($reserva);
                                        $reservaHecha = "La reserva para el partido ha sido registrada en la pista: " . $idPista;
                                        SessionMessage::setMessage($reservaHecha);
                                        header('Location: index.php?controller=reservas&action=reservar');
                                    }
									
								}
								else{
									SessionMessage::setMessage("Tienes otra reserva/partido en ese día y hora.");
									header('Location: index.php?controller=reservas&action=reservar');
                                }
							}
						break;
						
						case 'reservar':	
                            if(isset($_REQUEST["fecha"])){
                                require_once('Mappers/horaMapper.php');
                                $horaMapper = new HoraMapper();
                                $listaHoras = $horaMapper->mostrarTodos();
                                require_once('Views/pistaReservarView.php');
                                (new PistaReservarView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,$_REQUEST["fecha"]))->render();
                            }
                            else{
                                require_once('Mappers/horaMapper.php');
                                $horaMapper = new HoraMapper();
                                $listaHoras = $horaMapper->mostrarTodos();
                                require_once('Views/pistaReservarView.php');
                                (new PistaReservarView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,''))->render();
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
