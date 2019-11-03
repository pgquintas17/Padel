<?php
    require_once('Views/loginView.php');
    require_once('Models/usuarioModel.php');
    require_once('Mappers/usuarioMapper.php');


    class LoginController {
    
        function __construct() {
            //Si se recibe un POST
            if(isset($_REQUEST['action'])) {
                switch($_REQUEST['action']) {
                    //Si es un POST de login
                    case "login":
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
                            echo "Error iniciando sesión";
                        }
                        break;
                }
            }
            else {
                    (new LoginView())->render();
            }
    
        }
    } 
    
    
    
?>