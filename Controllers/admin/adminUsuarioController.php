<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/usuarioModel.php');
	require_once('Mappers/usuarioMapper.php');
	

	class AdminUsuarioController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if ($_POST){
							try {
								$usuario = new UsuarioModel($_POST["inputLogin"],$_POST["inputNombre"],$_POST["inputLogin"],$_POST["inputFechaNac"],$_POST["inputTelefono"],$_POST["inputEmail"],$_POST["inputGenero"],$_REQUEST["inputPermiso"]);
								$errores =  $usuario->validarRegistro();
                            	$usuarioMapper = new UsuarioMapper();
								$respuesta = $usuarioMapper->ADD($usuario);

								SessionMessage::setMessage($respuesta);
								header('Location: index.php?controller=adminUsuarios');
							}
							catch (ValidationException $e){
								SessionMessage::setErrores($e->getErrores());
								SessionMessage::setMessage($e->getMessage());
								header('Location: index.php?controller=adminUsuarios&action=ADD');
							}
						}else{
							require_once('Views/usuario/usuarioADDView.php');
							(new UsuarioADDView(SessionMessage::getMessage(),SessionMessage::getErrores()))->render();
						}
						break;
						

					case 'DELETE': 
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['username']);
						$usuarioMapper = new UsuarioMapper();
						$respuesta = $usuarioMapper->DELETE($usuario); 
						SessionMessage::setMessage($respuesta);
						header('Location: index.php?controller=adminUsuarios');
						break;
						

					case 'DETAILS': 
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['username']);
						$usuarioMapper = new UsuarioMapper();
						$datos = $usuarioMapper->consultarDatos($usuario);
						require_once('Views/usuario/usuarioDetailsView.php');
						(new UsuarioDetailsView('','','',$datos))->render();
						break;


					default: 
						header('Location: index.php?controller=adminUsuarios');
						break;

				}
			} else { //mostrar todos los elementos
				$usuarioMapper = new UsuarioMapper();
				$listaUsuarios = $usuarioMapper->mostrarTodos(); 
				require_once('Views/usuario/adminUsuarioView.php');
				(new AdminUsuarioView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaUsuarios))->render();
			}
		}
	}

 ?>
