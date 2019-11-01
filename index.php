<?php
    require_once('Models/USUARIO_MODEL.php');
    require_once('Services/Utils.php');
    session_start();

    if(isset($_REQUEST['controller'])) {
        if(Utils::conectado()) {

            if(Utils::nivelPermiso(2)){ //Si tiene permisos de administrador
                switch($_REQUEST["controller"]){
                    case "adminUsuarios":
                        //require_once('Controllers/adminUsuariosController.php');
                        new AdminUsuariosController();
                        exit;
                        break;
                    case "adminPista":
                        //require_once('Controllers/adminPistaController.php');
                        new AdminPistaController();
                        exit;
                        break;
                    case "adminPartido":
                        //require_once('Controllers/adminPartidoController.php');
                        new AdminPartidoController();
                        exit;
                        break;
                    case "adminCampeonato":
                        //require_once('Controllers/adminCampeonatoController.php');
                        new AdminCampeonatoController();
                        exit;
                        break;
                }
            }
            
            switch($_REQUEST["controller"]) {
                case "perfil":
                    //require_once('Controllers/perfilController.php');
                    new PerfilController();
                    exit;
                    break;
                case "reserva":
                    //require_once('Controllers/reservaPistaController.php');
                    new ReservaPistaController();
                    exit;
                    break;
                case "promocion":
                    //require_once('Controllers/partidoPromocionadoController.php');
                    new PartidoPromocionadoController();
                    exit;
                    break;
                case "campeonatos":
                    //require_once('Controllers/deportistaCampeonatosController.php');
                    new DeportistaCampeonatosController();
                    exit;
                    break;
                case "logout":
                    require_once('Controllers/indexController.php');
                    Utils::desconectar();
                    new IndexController();
                    exit;
                    break;
                default:
                    require_once('Controllerss/indexController.php');
                    new IndexController();
                    exit;
                    break;  
            }  
            
        }else {
            switch($_REQUEST["controller"]) {
                case "login":
                    require_once('Controllers/loginController.php');
                    new LoginController();
                    exit;
                    break;
                default:
                    require_once('Controllers/indexController.php');
                    new indexController();
                    exit;
                    break;
            }
        }
    }else {
        require_once('Controllers/indexController.php');
        new indexController();
        exit;
    }

?>