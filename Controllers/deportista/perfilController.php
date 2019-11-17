<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/usuarioModel.php');
	require_once('Mappers/usuarioMapper.php');
	require_once('Mappers/reservaMapper.php');
	require_once('Mappers/partidoMapper.php');
	require_once('Mappers/campeonatoMapper.php');
	

	class PerfilController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'EDIT': 
						if ($_POST){
							try {
								$usuario = new UsuarioModel($_SESSION["Usuario"]->getLogin(),$_POST["inputNombre"],$_POST["inputPassword"],$_POST["inputFechaNac"],$_POST["inputTelefono"],$_POST["inputEmail"],$_POST["inputGenero"],$_SESSION["Usuario"]->getPermiso());
								$errores =  $usuario->validarRegistro();
                            	$usuarioMapper = new UsuarioMapper();
								$respuesta = $usuarioMapper->EDIT($usuario);

								SessionMessage::setMessage($respuesta);
								header('Location: index.php?controller=perfil');
							}
							catch (ValidationException $e){
								SessionMessage::setErrores($e->getErrores());
								SessionMessage::setMessage($e->getMessage());
								header('Location: index.php?controller=perfil&action=EDIT');
							}
						}else{
                            $usuarioMapper = new UsuarioMapper();
                            $datos = $usuarioMapper->consultarDatos($_SESSION['Usuario']);
							require_once('Views/usuario/usuarioEDITView.php');
							(new UsuarioEDITView(SessionMessage::getMessage(),SessionMessage::getErrores(),'',$datos))->render();
						}
						break;

					default: 
						header('Location: index.php?controller=perfil');
						break;

				}
			} else { //mostrar todos los elementos
				$reservaMapper = new ReservaMapper();
                $listaReservas = $reservaMapper->getReservasByLogin($_SESSION['Usuario']);
                $partidoMapper = new PartidoMapper();
				$listaPartidos = $partidoMapper->getPartidosByLogin($_SESSION['Usuario']);
                $campeonatoMapper = new CampeonatoMapper();
				$listaCampeonatos = $campeonatoMapper->getCampeonatosByLogin($_SESSION['Usuario']);  
				require_once('Views/usuario/perfilView.php');
				(new PerfilView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaReservas,'',$listaPartidos,'',$listaCampeonatos))->render();
			}
		}
	}

 ?>
