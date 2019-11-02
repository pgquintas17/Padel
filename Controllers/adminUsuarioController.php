<?php
	
	// include '../Views/Users_Views/USUARIO_ADD.php';
	// include '../Views/Users_Views/USUARIO_EDIT.php';

	class AdminUsuarioController {

		function __construct() {

			if(isset($_REQUES["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if (!$_POST) 
							//new UsuariosADDView(); 
							echo "hola";
						else{
							require_once('Mappers/usuarioMapper.php');
							$usuarioMapper = new UsuarioMapper();
							$usuario = get_data_form();  
							$usuarioMapper->ADD($usuario); 
							echo "Usuario añadido";
							header('Location: Controllers/adminUsuariosController.php');
						}
						break;


					case 'DELETE': 
						require_once('../Models/usuarioModel.php');
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['login']);
						require_once('Mappers/usuarioMapper.php');
						$usuarioMapper = new UsuarioMapper();
						$respuesta = $usuarioMapper->DELETE($usuario); 
						echo "Usuario Eliminado"; 
						header('Location: Controllers/adminUsuariosController.php');

						break;
						

					case 'DETAILS': 
						require_once('../Models/usuarioModel.php');
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['login']);
						require_once('Mappers/usuarioMapper.php');
						$usuarioMapper = new UsuarioMapper();
						$valores = $usuarioMapper->consultarDatos($usuario);
						require_once('Views/usuarioDetailsView.php');
						(new UsuarioDetailsView('','','','',$valores))->render();
						break;


					default: 

						header('Location: index.php?controller=adminUsuario');
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


		function getDataForm(){
			require_once('../Models/usuarioModel.php');
			$usuario = new UsuarioModel;
			$usuario->setLogin($_REQUEST["login"]);
			$usuario->setNombre($_REQUEST["nombre"]);
			$usuario->setPassword($_REQUEST["password"]);
			$usuario->setFechaNac($_REQUEST["fechaNac"]);
			$usuario->setTelefono($_REQUEST["telefono"]);
			$usuario->setEmail($_REQUEST["email"]);
			$usuario->setGenero($_REQUEST["genero"]);
			$usuario->setPermiso($_REQUEST["permiso"]);

			return $usuario;
		}
	}

 ?>
