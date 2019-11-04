<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';

	class AdminUsuarioController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if ($_POST){
							require_once('Models/usuarioModel.php');
							$usuario = new UsuarioModel();
							$usuario->setLogin($_POST["inputLogin"]);
							$usuario->setNombre($_POST["inputNombre"]);
							$usuario->setPassword($_POST["inputPassword"]);
							$usuario->setFechaNac($_POST["inputFechaNac"]);
							$usuario->setTelefono($_POST["inputTelefono"]);
							$usuario->setEmail($_POST["inputEmail"]);
							$usuario->setGenero($_POST["inputGenero"]);
							$usuario->setPermiso($_REQUEST["inputPermiso"]);
							$errores =  $usuario->validarRegistro();
							if(sizeof($errores) == null){
								require_once('Mappers/usuarioMapper.php');
								$usuarioMapper = new UsuarioMapper();
								$usuarioMapper->ADD($usuario); 
								echo "Usuario añadido";
							}
							else{
								echo "la has liado";
								echo $errores;
							}
							header('Location: index.php?controller=adminUsuarios');
						}else{
							require_once('Views/usuarioADDView.php');
							(new UsuarioADDView())->render();
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
				(new AdminUsuarioView('','','','',$listaUsuarios))->render();
			}
		}
	}

 ?>
