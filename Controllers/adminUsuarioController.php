<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';
	require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

	class AdminUsuarioController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if ($_POST){
							try {
								require_once('Models/usuarioModel.php');
								$usuario = new UsuarioModel($_POST["inputLogin"],$_POST["inputNombre"],$_POST["inputPassword"],$_POST["inputFechaNac"],$_POST["inputTelefono"],$_POST["inputEmail"],$_POST["inputGenero"],$_REQUEST["inputPermiso"]);
								$errores =  $usuario->validarRegistro();

								SessionMessage::setMessage("Registro completado con éxito");
								header('Location: index.php?controller=adminUsuarios');
							}
							catch (ValidationException $e){
								SessionMessage::setErrores($e->getErrores());
								SessionMessage::setMessage($e->getMessage());
								header('Location: index.php?controller=adminUsuarios&action=ADD');
							}
						}else{
							require_once('Views/usuarioADDView.php');
							(new UsuarioADDView(SessionMessage::getMessage(),SessionMessage::getErrores()))->render();
						}
						break;
						

					case 'DELETE': 
						require_once('Models/usuarioModel.php');
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['username']);
						require_once('Mappers/usuarioMapper.php');
						$usuarioMapper = new UsuarioMapper();
						$respuesta = $usuarioMapper->DELETE($usuario); 
						echo "Usuario Eliminado"; 
						header('Location: index.php?controller=adminUsuarios');
						break;
						

					case 'DETAILS': 
						require_once('Models/usuarioModel.php');
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['username']);
						require_once('Mappers/usuarioMapper.php');
						$usuarioMapper = new UsuarioMapper();
						$datos = $usuarioMapper->consultarDatos($usuario);
						require_once('Views/usuarioDetailsView.php');
						(new UsuarioDetailsView('','','',$datos))->render();
						break;


					default: 
						echo "hey, estoy viniendo aquí";
						header('Location: index.php?controller=adminUsuarios');
						break;

				}
			} else { //mostrar todos los elementos
				require_once('Mappers/usuarioMapper.php');
				$usuarioMapper = new UsuarioMapper();
				$listaUsuarios = $usuarioMapper->mostrarTodos(); 
				require_once('Views/adminUsuarioView.php');
				(new AdminUsuarioView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaUsuarios))->render();
			}
		}
	}

 ?>
