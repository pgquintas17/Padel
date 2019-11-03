<?php	

	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';
	require_once('Models/usuarioModel.php');
	echo "NO YAYYYYY"; echo "     ";
	echo "REQUEST: "; var_dump($_REQUEST); echo "     ";
	//echo "POST: "; var_dump($_POST); echo "     ";

	class AdminUsuarioController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
					//echo "CASI YAAAY.    ";
						if ($_POST){
							//echo "YAYYYYY";
							//echo "REQUEST: "; var_dump($_REQUEST); echo "     ";
							require_once('Models/usuarioModel.php');
							$usuario = new UsuarioModel($_POST["inputLogin"],$_POST["inputNombre"],$_POST["inputPassword"],$_POST["inputFechaNac"],$_POST["inputTelefono"],$_POST["inputEmail"],$_POST["inputGenero"],$_REQUEST["inputPermiso"]);
							echo "USUARIO: "; var_dump($usuario);
							$errores =  $usuario->validarRegistro();
							if(sizeof($errores) == 0){
								echo "no hay errores";
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
							//echo "NOS PASAMOS DE YAAAY.    ";
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
				$datos = array('login','nombre','passwd','fecha_nac','telefono','email','genero','permiso'); 
				require_once('Views/adminUsuarioView.php');
				(new AdminUsuarioView('','','',$datos,$listaUsuarios))->render();
			}
		}
	}

 ?>
