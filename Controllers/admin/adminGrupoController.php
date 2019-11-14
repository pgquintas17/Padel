<?php	

	require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

	class AdminGrupoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

                    case 'addResultado': 
						echo "añadir resultados";
						break;

					
					case 'editResultado':
						echo "editar un resultado";
						break;

					default: 
						echo "hey, estoy viniendo aquí";
						header('Location: index.php?controller=adminUsuarios');
						break;

				}
            } else { //mostrar todos los elementos
                require_once('Models/grupoModel.php');
                $grupo = new GrupoModel();
                $grupo->setId($_REQUEST['idgrupo']);
				require_once('Mappers/grupoMapper.php');
				$grupoMapper = new GrupoMapper();
				$parejas = $grupoMapper->getParejasByGrupo($grupo); 
				$enfrentamientos = $grupoMapper->getEnfrentamientosByGrupo($grupo);
				require_once('Views/grupoDetailsView.php');
				(new GrupoDetailsView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$enfrentamientos,'',$parejas))->render();
			}
		}
	}

 ?>
