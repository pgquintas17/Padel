<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Mappers/reservaMapper.php');
	require_once('Models/reservaModel.php');
	require_once('Models/usuarioModel.php');
    require_once('Mappers/partidoMapper.php');
    require_once('Models/enfrentamientoModel.php');
    require_once('Mappers/enfrentamientoMapper.php');
    require_once('Models/parejaModel.php');
    require_once('Mappers/parejaMapper.php');
	require_once('Mappers/pistaMapper.php');
	require_once('Mappers/horaMapper.php');

	class EnfrentamientoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

                    case 'addPropuesta':
                        $hoy = date('Y-m-d');
                        $fecha = date($_REQUEST['fecha']);
                        $limit = date_create($fecha);
                        date_sub($limit, date_interval_create_from_date_string('5 day'));
                        $limite = date_format($limit, 'Y-m-d');
                        if($limite <= $hoy){
                            SessionMessage::setMessage("No se puede jugar en fechas pasadas ni proponer fechas con menos de cinco días de antelación.");
                            $goto = 'Location: index.php?controller=enfrentamientos&idenfrentamiento=' . $_REQUEST['idenfrentamiento'];
                            header($goto);
                        }
                        else{
                            $pareja = new ParejaModel($_REQUEST['pareja']);
                            $capi = $_SESSION['Usuario']->getLogin();
                            $parejaMapper = new ParejaMapper();
                            $miembro = $parejaMapper->getMiembroById($pareja);

                            $validacionCapitan = Utils::validarDisponibilidad($capi,$_REQUEST['fecha'],$_REQUEST['hora']);
                            $validacionMiembro = Utils::validarDisponibilidad($capi,$_REQUEST['fecha'],$_REQUEST['hora']);
                            
                            if($validacionCapitan && $validacionMiembro){
                                $reserva = new ReservaModel();
                                $reserva->setHora($_REQUEST['hora']);
                                $reserva->setFecha($_REQUEST['fecha']);
                                $reservasEnFecha = (new ReservaMapper())->getNumReservasByDiaYHora($reserva);
                                $pistaMapper = new PistaMapper();
                                $pistasActivas = $pistaMapper->getNumPistasActivas();
                                if($reservasEnFecha == $pistasActivas){
                                    SessionMessage::setMessage("No hay pistas disponibles para ese día y hora.");
                                    $goto = 'Location: index.php?controller=enfrentamientos&idenfrentamiento=' . $_REQUEST['idenfrentamiento'];
                                    header($goto);
                                }
                                else{

                                    $enfrentamiento = new EnfrentamientoModel($_REQUEST['idenfrentamiento']);
                                    $propuesta = date($_REQUEST['fecha'] . " " . $_REQUEST['hora']);
                                    $enfrentamientoMapper = new EnfrentamientoMapper();

                                    $pareja->setCapitan($capi);

                                    if($enfrentamientoMapper->getNumParejaCapi($enfrentamiento,$pareja) == 1){
                                        $enfrentamiento->setPropuesta1($propuesta);
                                        $respuesta = $enfrentamientoMapper->addPropuesta1($enfrentamiento);
                                    }
                                    else{
                                        $enfrentamiento->setPropuesta2($propuesta);
                                        $respuesta = $enfrentamientoMapper->addPropuesta2($enfrentamiento);
                                    }

                                    //mandar mail a los cuatros jugadores
                                    
                                    SessionMessage::setMessage($respuesta);
                                    header('Location: index.php');
                                }

                            }
                            else{
                                SessionMessage::setMessage("Un miembro de tu pareja tiene otra reserva/partido en ese día y hora.");
                                $goto = 'Location: index.php?controller=enfrentamientos&idenfrentamiento=' . $_REQUEST['idenfrentamiento'];
								header($goto);
                            }
                            
                        }
						break;
						

                    case 'rechazarPropuesta':
                        //comprobar que no se haga una igual a la anterior
                        //comprobar disponibilidad pareja
                        //comprobar existencia de pista
                        //borar propuesta original
                        //guardar propuesta
                        //mandar mail a los cuatros jugadores
                        break;
                        

                    case 'aceptarPropuesta':
                        //comprobar disponibilidad de la pareja
                        //comprobar existencia de pista
                        //hacer reserva
                        //add fecha y hora al enfrentamiento
                        //mandar mail a los cuatros jugadores
                        break;


                    case 'cambiarFecha':
                        if(isset($_REQUEST["fecha"])){
                            $horaMapper = new HoraMapper();
                            $listaHoras = $horaMapper->mostrarTodos();
                            $enfrentamiento = new EnfrentamientoModel($_REQUEST['idenfrentamiento']);
                            $enfrentamientoMapper = new EnfrentamientoMapper();
                            $datos = $enfrentamientoMapper->getDatosEnfrentamiento($enfrentamiento);
                            require_once('Views/campeonato/enfrentamientoPropuestaView.php');
                            (new EnfrentamientoPropuestaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,$_REQUEST['fecha'],$datos))->render();
                        }
                        else{
                            header('Location: index.php?controller=enfrentamientos');
                        }
                        break;

					default: 
						echo "default";
						header('Location: index.php');
						break;

                }
                
			} else {
                $horaMapper = new HoraMapper();
                $listaHoras = $horaMapper->mostrarTodos();
                $enfrentamiento = new EnfrentamientoModel($_REQUEST['idenfrentamiento']);
                $enfrentamientoMapper = new EnfrentamientoMapper();
                $datos = $enfrentamientoMapper->getDatosEnfrentamiento($enfrentamiento);

                if($datos['1'] == null && $datos['2'] == null){
                    require_once('Views/campeonato/enfrentamientoPropuestaView.php');
                    (new EnfrentamientoPropuestaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,'',$datos))->render();
                }
                else{
                    //si ya hay una propuesta:
                    //de la otra pareja: botón de aceptar/rechazar
                    //propia: cambiar
                    echo "existe propuesta";
                }
			}
		}
	}

 ?>
