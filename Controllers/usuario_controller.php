
<?php

    session_start();

    if (!isset($_REQUEST['action']))
	    $_REQUEST['action'] = '';

    include '../Views/Users_Views/USUARIO_SHOWALL.php';
    include '../Views/Users_Views/USUARIO_ADD.php';
    include '../Views/Users_Views/USUARIO_SEARCH.php';
    include '../Views/Users_Views/USUARIO_SHOWCURRENT.php';
    include '../Views/Users_Views/USUARIO_DELETE.php';
    include '../Views/Users_Views/USUARIO_EDIT.php';
    include_once '../Models/USUARIO_MODEL.php';


	function get_data_form(){

		$login = $_REQUEST['login']; 
		$nombre = $_REQUEST['nombre'];
        $apellidos = $_REQUEST['apellidos'];
        $password = $_REQUEST['password'];
		$fecha_nac = $_REQUEST['fecha nacimiento'];
		$telefono = $_REQUEST['telefono'];
		$email = $_REQUEST['email'];
		$genero = $_REQUEST['genero'];
		$permiso = $_REQUEST['permiso'];
		$action = $_REQUEST['action'];

		$USERS = new USERS_MODEL($login,$nombre$apellidos,$password$fecha_nac;$telefono,$email,$genero,$permiso);

		return $USERS;
	}


    Switch ($_REQUEST['action']){

	    case 'ADD': 
			if (!$_POST) 
				new USERS_ADD(); 
			else{

				$modelo = get_data_form();  

				$respuesta = $modelo->ADD(); 
				new MESSAGE($respuesta, './usuario_controller.php');
			}
			break;


		case 'DELETE': 

			if (!$_POST){

				$USUARIO = new USUARIO_MODEL($_REQUEST['login'], '', '', '', '', '', '', '', ''); 
				$valores = $USUARIO->consultarDatos(); 
				new USUARIO_DELETE($valores);
			}
			else{ 

				$USUARIO = new USUARIO_MODEL($_REQUEST['login'], '', '', '', '', '', '', '', ''); 
                $respuesta = $USUARIO->DELETE(); 
                
				if($respuesta == true){ 
					$PAREJA_CAPI = new USERSGROUP_MODEL('', '', $_REQUEST['login'], '', '', ''); 
                    $respuesta2 = $PAREJA_CAPI->DELETEUSUARIO();
                }
                
				new MESSAGE($respuesta, './usuario_controller.php'); 
			}
			break;


		case 'EDIT': 

			if (!$_POST){ 

				$USUARIO = new USUARIO_MODEL($_REQUEST['login'], '', '', '', '', '', '', '', ''); 
				$valores = $USUARIO->consultarDatos(); 
				new USUARIO_EDIT($valores); 
			}
			else{ 

				$USUARIO = get_data_form(); 

				$respuesta = $USUARIO->EDIT(); 
				new MESSAGE($respuesta, './usuario_controller.php');
			}
            break;
            

		case 'DETAILS': 

			$USUARIO = new USUARIO_MODEL($_REQUEST['login'], '', '', '', '', '', '', '', ''); 
			$valores = $USUARIO->consultarDatos(); 
			new USERS_DETAILS($valores); 
            break;


        default: //mostrar todos los elementos

			$USUARIO = new USUARIO_MODEL('','', '', '', '', '', '', '', ''); 

			$datos = $USUARIO->mostrarTodos(); 
			$lista = array('Login','Password','DNI','Nombre','Apellidos','Correo','Direccion','Telefono');
			new USERS_SHOWALL($lista, $datos); 

    }






 ?>
