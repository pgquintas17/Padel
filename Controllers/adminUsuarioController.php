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

							$modelo = get_data_form();  
							$respuesta = $modelo->ADD(); 
							echo "Usuario añadido";
							header('Location: Controllers/adminUsuariosController.php');
						}
						break;


					case 'DELETE': 
						require_once('../Models/USUARIO_MODEL.php');
						$USUARIO = new USUARIO_MODEL($_REQUEST['login'], '', '', '', '', '', '', '', ''); 
						$respuesta = $USUARIO->DELETE(); 
						echo "Usuario Eliminado"; 
						header('Location: Controllers/adminUsuariosController.php');

						break;
						

					case 'DETAILS': 
						require_once('../Models/USUARIO_MODEL.php');
						$USUARIO = new USUARIO_MODEL($_REQUEST['login'], '', '', '', '', '', '', '', ''); 
						$valores = $USUARIO->consultarDatos();
						require_once('Views/usuarioDetailsView.php');
						(new UsuarioDetailsView('','','','',$valores))->render();
						break;


					default: 

						header('Location: index.php?controller=adminUsuario');
						break;

				}
			} else { //mostrar todos los elementos
				require_once('Models/USUARIO_MODEL.php');
				$usuarios = new USUARIO_MODEL('','', '', '', '', '', '', '', '');
				$listaUsuarios = $usuarios->mostrarTodos();
				$datos = array('login','nombre','apellidos','passwd','fecha_nac','telefono','email','genero','permiso'); 
				require_once('Views/adminUsuarioView.php');
				(new AdminUsuarioView('','','',$datos,$listaUsuarios))->render();
			}
		}
	}

 ?>
