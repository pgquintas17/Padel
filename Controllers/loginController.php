<?php
    require_once('Views/usuario/loginView.php');
    require_once('Models/usuarioModel.php');
    require_once('Mappers/usuarioMapper.php');
    require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

    class LoginController {
    
        function __construct() {
            //Si se recibe un POST
            if(isset($_REQUEST['action'])) {
                switch($_REQUEST['action']) {
                    //Si es un POST de login
                    case "login":
                        try {
                            $usuario = new UsuarioModel();
                            $usuario->setLogin($_REQUEST['username']);
                            $usuario->setPassword($_REQUEST['passwd']);
                            $usuarioMapper = new UsuarioMapper();
                            $respuesta = $usuarioMapper->Login($usuario);

                            if ($respuesta != null){
                                $_SESSION['Usuario'] = $respuesta;
                                header('Location: index.php');
                            }
                            else {
                                throw new ValidationException(array("Error iniciando sesión"),"Error iniciando sesión");
                            }
                    } catch(ValidationException $e) {
						SessionMessage::setMessage($e->getErrores()); //Esto es para los errores de validacion
						header('Location: index.php?controller=login');
					}
                        break;
                }
            }
            else {
                    (new LoginView(SessionMessage::getMessage(), SessionMessage::getErrores()))->render();
            }
    
        }
    } 
    
    
    
?>