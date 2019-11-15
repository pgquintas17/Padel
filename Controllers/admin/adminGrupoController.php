<?php	

	require_once('Services/sessionMensajes.php');
    require_once("Services/validarExcepciones.php");

	class AdminGrupoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'addResultado': 
						if ($_POST){
							try {
								require_once('Models/setModel.php');

								$set1 = new SetModel();
								$set2 = new SetModel();
								$set3 = new SetModel();

								$set1->setPareja1($_POST["S1P1"]);
								$set1->setPareja2($_POST["S1P2"]);

								$set2->setPareja1($_POST["S2P1"]);
								$set2->setPareja2($_POST["S2P2"]);

								$set3->setPareja1($_POST["S3P1"]);
								$set3->setPareja2($_POST["S3P2"]);

								$set1->validarSet();
								$set2->validarSet();
								$set3->validarSet();

								$resultado = Utils::calcularResultado($set1, $set2, $set3);
								require_once('Models/enfrentamientoModel.php');
								$enfrentamiento = new EnfrentamientoModel($_REQUEST["idenfrentamiento"]);
								require_once('Mappers/enfrentamientoMapper.php');
								$enfrentamientoMapper = new EnfrentamientoMapper();

								$result = $resultado['puntos1'] . "-" . $resultado['puntos2'];
								$enfrentamiento->setResultado($result);

								$set1enf = $_POST["S1P1"] . "-" . $_POST["S1P2"];
								$enfrentamiento->setSet1($set1enf);
								
								$set2enf = $_POST["S2P1"] . "-" . $_POST["S2P2"];
								$enfrentamiento->setSet2($set2enf);
								
								if( $_POST["S3P1"] != null){
									$set3enf = $_POST["S3P1"] . "-" . $_POST["S3P2"];
									$enfrentamiento->setSet3($set3enf);
								}

								$respuesta = $enfrentamientoMapper->addResultado($enfrentamiento);

								$enf = $enfrentamientoMapper->consultarDatos($enfrentamiento);

								require_once('Models/parejaModel.php');
								$pareja1 = new ParejaModel();
								$pareja2 = new ParejaModel();
								$pareja1->setId($enf['7']);
								$pareja2->setId($enf['8']);

								require_once('Mappers/parejaMapper.php');
								$parejaMapper = new ParejaMapper();

								if($resultado['ganador'] == 1){
									$parejaMapper->addPuntosGanador($pareja1);
									$parejaMapper->addPuntosPerdedor($pareja2);
								}
								else{
									$parejaMapper->addPuntosGanador($pareja2);
									$parejaMapper->addPuntosPerdedor($pareja1);
								}

								SessionMessage::setMessage($respuesta);
								$goto = 'Location:index.php?controller=adminGrupos&idgrupo='. $enf['10'];
								header($goto);

							}
							catch (ValidationException $e){
									SessionMessage::setErrores($e->getErrores());
									SessionMessage::setMessage($e->getMessage());
									$goto = 'Location: index.php?controller=adminGrupos&action=addResultado&idenfrentamiento='. $_REQUEST["idenfrentamiento"];
									header($goto);
							}
						}else{
							require_once('Models/enfrentamientoModel.php');
							$enf = new EnfrentamientoModel();
							$enf->setId($_REQUEST["idenfrentamiento"]);
							require_once('Mappers/enfrentamientoMapper.php');
							$enfMapper = new EnfrentamientoMapper();
							$datos = $enfMapper->consultarDatos($enf);
							require_once('Views/campeonato/gestionResultadoView.php');
							(new GestionResultadoView(SessionMessage::getMessage(),'','',$datos))->render();
						}
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
				require_once('Views/campeonato/grupoDetailsView.php');
				(new GrupoDetailsView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$enfrentamientos,'',$parejas))->render();
			}
		}
	}

 ?>
