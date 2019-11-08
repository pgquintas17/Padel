<?php
    require_once('Models/usuarioModel.php');
    require_once('Services/Utils.php');
    session_start();
	//echo "REQUEST EN INDEX: "; var_dump($_REQUEST); echo "     ";
	//echo "POST EN INDEX: "; var_dump($_POST); echo "     ";

    if(isset($_REQUEST['controller'])) {
        if(Utils::conectado()) { 

            if($_SESSION['Usuario']->getPermiso() == 2){ //Si tiene permisos de administrador
                
                switch($_REQUEST["controller"]){
                    case "adminUsuarios":
                        require_once('Controllers/admin/adminUsuarioController.php');
                        new AdminUsuarioController();
                        exit;
                        break;
                    case "adminPistas":
                        require_once('Controllers/admin/adminPistaController.php');
                        new AdminPistaController();
                        exit;
                        break;
                    case "adminPartidos":
                        require_once('Controllers/admin/adminPartidoController.php');
                        new AdminPartidoController();
                        exit;
                        break;
                    case "adminCampeonatos":
                        //require_once('Controllers/admin/adminCampeonatoController.php');
                        new AdminCampeonatoController();
                        exit;
                        break;
                }
            }else if($_SESSION['Usuario']->getPermiso() == 0){ //SI ES DEPORTISTA

                switch($_REQUEST["controller"]) {
                case "perfil":
                    require_once('Controllers/deportista/perfilController.php');
                    new PerfilController();
                    exit;
                    break;
                case "reservas":
                    require_once('Controllers/deportista/reservaPistaController.php');
                    new ReservaPistaController();
                    exit;
                    break;
                case "campeonatos":
                    //require_once('Controllers/deportista/campeonatosController.php');
                    new CampeonatoController();
                    exit;
                    break;
                case "partidos":
                    require_once('Controllers/deportista/partidoController.php');
                    new PartidoController();
                    exit;
                    break;
                }

            }else{ //SI ES ENTRENADOR

                switch($_REQUEST["controller"]) {
                    case "clases":
                        //require_once('Controllers/clasesController.php');
                        new PerfilController();
                        exit;
                        break;  
                }  
            }
            
            // GENERALES

            switch($_REQUEST["controller"]) {
                case "logout":
                    require_once('Controllers/indexController.php');
                    Utils::desconectar();
                    new IndexController();
                    exit;
                    break;
                default:
                    require_once('Controllers/indexController.php');
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
                    new IndexController();
                    exit;
                    break;
            }
        }
    }else {
        require_once('Controllers/indexController.php');
        new IndexController();
        exit;
    }

?>