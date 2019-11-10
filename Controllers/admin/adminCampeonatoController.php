<?php	

	require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

	class AdminCampeonatoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

                    case 'ADD': 
                        echo "add";
						/* if ($_POST){
							try {
								require_once('Models/usuarioModel.php');
								$usuario = new UsuarioModel($_POST["inputLogin"],$_POST["inputNombre"],$_POST["inputLogin"],$_POST["inputFechaNac"],$_POST["inputTelefono"],$_POST["inputEmail"],$_POST["inputGenero"],$_REQUEST["inputPermiso"]);
								$errores =  $usuario->validarRegistro();
								require_once('Mappers/usuarioMapper.php');
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
							require_once('Views/usuarioADDView.php');
							(new UsuarioADDView(SessionMessage::getMessage(),SessionMessage::getErrores()))->render();
						} */
						break;
						

                    case 'DELETE': 
                        echo "delete";
						/* require_once('Models/usuarioModel.php');
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['username']);
						require_once('Mappers/usuarioMapper.php');
						$usuarioMapper = new UsuarioMapper();
						$respuesta = $usuarioMapper->DELETE($usuario); 
						echo "Usuario Eliminado"; 
						header('Location: index.php?controller=adminUsuarios'); */
						break;
						

                    case 'DETAILS': 
                        echo "details";
						/* require_once('Models/usuarioModel.php');
						$usuario = new UsuarioModel();
						$usuario->setLogin($_REQUEST['username']);
						require_once('Mappers/usuarioMapper.php');
						$usuarioMapper = new UsuarioMapper();
						$datos = $usuarioMapper->consultarDatos($usuario);
						require_once('Views/usuarioDetailsView.php');
						(new UsuarioDetailsView('','','',$datos))->render(); */
						break;


					default: 
						echo "hey, estoy viniendo aquí";
						header('Location: index.php?controller=adminUsuarios');
						break;

				}
			} else { //mostrar todos los elementos
				require_once('Mappers/campeonatoMapper.php');
				$campeonatoMapper = new CampeonatoMapper();
				$listaCampeonatos = $campeonatoMapper->mostrarTodos(); 
				require_once('Views/campeonatoView.php');
				(new CampeonatoView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaCampeonatos))->render();
			}
		}
	}

 ?>
