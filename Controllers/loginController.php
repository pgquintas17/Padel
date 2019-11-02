<?php
    require_once('Views/loginView.php');
    require_once('Models/usuarioModel.php');
    require_once('Mappers/usuarioMapper.php');


    class LoginController {
    
        function __construct() {
            //Si se recibe un POST
            if(isset($_POST['action'])) {
                switch($_POST['action']) {
                    //Si es un POST de login
                    case "login":
                        $usuario = new UsuarioModel($_REQUEST['username'],'',$_REQUEST['passwd'],'','','','','');
                        $usuarioMapper = new UsuarioMapper();
                        $respuesta = $usuarioMapper->Login($usuario);

                        if ($respuesta){
                            $_SESSION['login'] = $_REQUEST['username'];
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