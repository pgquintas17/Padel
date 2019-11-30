<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Mappers/reservaMapper.php');
	require_once('Models/reservaModel.php');
	require_once('Models/usuarioModel.php');
    require_once('Mappers/partidoMapper.php');
    require_once('Models/enfrentamientoModel.php');
	require_once('Mappers/enfrentamientoMapper.php');
	require_once('Mappers/pistaMapper.php');
	require_once('Mappers/horaMapper.php');

	class EnfrentamientoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'addPropuesta':
                        //comprobar disponibilidad pareja
                        //comprobar existencia de pista
                        //guardar propuesta
                        //mandar mail a los cuatros jugadores
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
                require_once('Views/campeonato/enfrentamientoPropuestaView.php');
                (new EnfrentamientoPropuestaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaHoras,'',$datos))->render();
                //si ya hay una propuesta:
                    //de la otra pareja: botón de aceptar/rechazar
                    //propia: cambiar
				header('Location: index.php');
			}
		}
	}

 ?>
