<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';
	require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

	class PerfilController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'EDIT': 
						if ($_POST){
							try {
								require_once('Models/usuarioModel.php');
								$usuario = new UsuarioModel($_SESSION["Usuario"]->getLogin(),$_POST["inputNombre"],$_POST["inputPassword"],$_POST["inputFechaNac"],$_POST["inputTelefono"],$_POST["inputEmail"],$_POST["inputGenero"],$_SESSION["Usuario"]->getPermiso());
								$errores =  $usuario->validarRegistro();
								require_once('Mappers/usuarioMapper.php');
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
                            require_once('Models/usuarioModel.php');
                            require_once('Mappers/usuarioMapper.php');
                            $usuarioMapper = new UsuarioMapper();
                            $datos = $usuarioMapper->consultarDatos($_SESSION['Usuario']);
							require_once('Views/usuarioEDITView.php');
							(new UsuarioEDITView(SessionMessage::getMessage(),SessionMessage::getErrores(),'',$datos))->render();
						}
						break;

					default: 
						echo "hey, estoy viniendo aquí";
						header('Location: index.php?controller=perfil');
						break;

				}
			} else { //mostrar todos los elementos
				require_once('Mappers/reservaMapper.php');
				$reservaMapper = new ReservaMapper();
                $listaReservas = $reservaMapper->getReservasByLogin($_SESSION['Usuario']);
                require_once('Mappers/partidoMapper.php');
                $partidoMapper = new PartidoMapper();
				$listaPartidos = $partidoMapper->getPartidosByLogin($_SESSION['Usuario']); 
				require_once('Views/perfilView.php');
				(new PerfilView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaReservas,'',$listaPartidos))->render();
			}
		}
	}

 ?>
