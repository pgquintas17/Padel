<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Mappers/reservaMapper.php');
	require_once('Models/reservaModel.php');
    require_once('Models/usuarioModel.php');
    require_once('Mappers/usuarioMapper.php');
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

                        $propuesta = date($_REQUEST['fecha'] . " " . $_REQUEST['hora']);
                        
                        if(isset($_REQUEST['propuesta1']) && $_REQUEST['propuesta1'] == $propuesta){
                            SessionMessage::setMessage("El valor nuevo de propuesta debe ser distinto del que quieres cambiar.");
                            $goto = 'Location: index.php?controller=enfrentamientos&idenfrentamiento=' . $_REQUEST['idenfrentamiento'];
                            header($goto);

                        }
                        else if(isset($_REQUEST['propuesta2']) && $_REQUEST['propuesta2'] == $propuesta){
                            SessionMessage::setMessage("El valor nuevo de propuesta debe ser distinto del que quieres cambiar.");
                            $goto = 'Location: index.php?controller=enfrentamientos&idenfrentamiento=' . $_REQUEST['idenfrentamiento'];
                            header($goto);
                        }
                        else{ // NO HAY NINGUNA PROPUESTA INICIAL O NO COINCIDE CON LA ACTUAL AL CAMBIAR
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
                                        $enfrentamientoMapper = new EnfrentamientoMapper();

                                        $pareja->setCapitan($capi);
                                        $parejas = $enfrentamientoMapper->getParejasById($enfrentamiento);

                                        if($enfrentamientoMapper->getNumParejaCapi($enfrentamiento,$pareja) == 1){
                                            $enfrentamiento->setPropuesta1($propuesta);
                                            $respuesta = $enfrentamientoMapper->addPropuesta1($enfrentamiento);
                                            $parejaR = new ParejaModel($parejas['1']);
                                            $emails = $parejaMapper->getEmailsPareja($parejaR);
                                        }
                                        else{
                                            $enfrentamiento->setPropuesta2($propuesta);
                                            $respuesta = $enfrentamientoMapper->addPropuesta2($enfrentamiento);
                                            $parejaR = new ParejaModel($parejas['0']);
                                            $emails = $parejaMapper->getEmailsPareja($parejaR);
                                        }

                                        $to_email_address = $emails . ', paulagonzalez1996@hotmail.com';
                                        $subject = 'Se ha propuesto una fecha para uno de tus partidos.';
                                        $partido = $parejaMapper->getNombreById(new ParejaModel($parejas['0'])). ' vs. ' . $parejaMapper->getNombreById(new ParejaModel($parejas['1']));
                                        $campeonato = $enfrentamientoMapper->getDatosEnfrentamiento($enfrentamiento);
                                        $message = '<html><head></head><body>Hola,<br>Te informamos de que se ha realizado una propuesta de fecha para tu partido ' . $partido .' en el Campeonato '. $campeonato['5'] .'. <br>La propuesta es: ' . date('d/m H:i',strtotime($propuesta)) . '. <br>Recuerda que el capitan de tu pareja debe conectarse para aceptar o rechazar la propuesta. <br><br>Un saludo,<br>Padelweb.</p></body></html>';
                                        $headers  = 'MIME-Version: 1.0' . "\r\n";
                                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                                        $headers .= 'From: noreply@padelweb.com';
                                        mail($to_email_address,$subject,$message,$headers);
                                        
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
                        }
						break;
						

                    case 'rechazar':
                        var_dump($_REQUEST);
                        //comprobar que no se haga una igual a la anterior
                        //comprobar disponibilidad pareja
                        //comprobar existencia de pista
                        //borar propuesta original
                        //guardar propuesta
                        //mandar mail a los cuatros jugadores
                        break;
                        

                    case 'aceptar':
                        
                        $pareja = new ParejaModel($_REQUEST['pareja']);
                        $capi = $_SESSION['Usuario']->getLogin();
                        $parejaMapper = new ParejaMapper();
                        $miembro = $parejaMapper->getMiembroById($pareja);

                        $fecha = substr($_REQUEST['propuesta'], 0,10);
                        $hora = substr($_REQUEST['propuesta'], -8);

                        $validacionCapitan = Utils::validarDisponibilidad($capi,$fecha,$hora);
                        $validacionMiembro = Utils::validarDisponibilidad($capi,$fecha,$hora);
                        
                        if($validacionCapitan && $validacionMiembro){
                            $reserva = new ReservaModel();
                            $reserva->setHora($hora);
                            $reserva->setFecha($fecha);
                            $reservaMapper = new ReservaMapper();
                            $reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
                            
                            $pistaMapper = new PistaMapper();
                            $pistasActivas = $pistaMapper->getNumPistasActivas();

                            $enfrentamiento = new EnfrentamientoModel();
                            $enfrentamiento->setId($_REQUEST['idenfrentamiento']);
                            $enfrentamiento->setPropuesta1($_REQUEST['propuesta']);
                            $enfrentamiento->setPropuesta2($_REQUEST['propuesta']);
                            $enfrentamiento->setFecha($fecha);
                            $enfrentamiento->setHora($hora);
                            $enfrentamientoMapper = new EnfrentamientoMapper();

                            if($reservasEnFecha == $pistasActivas){
                                
                                $enfrentamientoMapper->borrarPropuesta($enfrentamiento);
                                SessionMessage::setMessage("No hay pistas disponibles para ese día y hora. La propuesta de fecha se ha cancelado.");
                                $goto = 'Location: index.php?controller=enfrentamientos&idenfrentamiento=' . $_REQUEST['idenfrentamiento'];
                                header($goto);
                            }
                            else{
                                $enfrentamientoMapper->addPropuesta1($enfrentamiento);
                                $enfrentamientoMapper->addPropuesta2($enfrentamiento);

                                $idPista = $pistaMapper->findPistaLibre($reserva);
                                $reserva->setIdPista($idPista);
                                $admin = (new UsuarioMapper())->getAdmin();
                                $reserva->setLogin($admin->getLogin());
                                $reservaMapper->ADD($reserva);
                                $enfrentamiento->setIdReserva($reservaMapper->getIdReserva($reserva));
                                $enfrentamientoMapper->añadirReserva($enfrentamiento);
                                $enfrentamientoMapper->añadirFechaHora($enfrentamiento);
                                
                                $reservaHecha = "La reserva para el partido ha sido registrada en la pista: " . $idPista;
                                SessionMessage::setMessage($reservaHecha);
                                header('Location: index.php');
                            }
                        }
                        else{
                            SessionMessage::setMessage("Un miembro de tu pareja tiene otra reserva/partido en ese día y hora.");
                            $goto = 'Location: index.php?controller=enfrentamientos&idenfrentamiento=' . $_REQUEST['idenfrentamiento'];
                            header($goto);
                        }
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
                    $pareja = new ParejaModel();
                    $pareja->setCapitan($_SESSION['Usuario']->getLogin());

                    if($datos['1'] != null && $enfrentamientoMapper->getNumPareja($enfrentamiento,$pareja) == 1){

                        require_once('Views/campeonato/enfrentamientoPropuestaView.php');
                        (new EnfrentamientoPropuestaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,'',$datos))->render();

                    }else if($datos['1'] != null && $enfrentamientoMapper->getNumPareja($enfrentamiento,$pareja) == 2){

                        require_once('Views/campeonato/enfPropuestaView.php');
                        (new EnfPropuestaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'',$datos))->render();

                    }else if($datos['2'] != null && $enfrentamientoMapper->getNumPareja($enfrentamiento,$pareja) == 1){

                        require_once('Views/campeonato/enfPropuestaView.php');
                        (new EnfPropuestaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'',$datos))->render();

                    }else{
                        require_once('Views/campeonato/enfrentamientoPropuestaView.php');
                        (new EnfrentamientoPropuestaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,'',$datos))->render();

                    }
                }
			}
		}
	}

 ?>
