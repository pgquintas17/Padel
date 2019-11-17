<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/enfrentamientoModel.php');
	require_once('Mappers/enfrentamientoMapper.php');
	require_once('Models/parejaModel.php');
	require_once('Mappers/parejaMapper.php');
	require_once('Models/setModel.php');
	require_once('Models/grupoModel.php');
	require_once('Mappers/grupoMapper.php');

	class AdminGrupoController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'addResultado': 
						if ($_POST){
							try {

								if($_POST["S1P1"] == null || $_POST["S1P2"] == null || $_POST["S2P1"] == null|| $_POST["S2P2"] == null){
									SessionMessage::setMessage("Los primeros dos sets no pueden estar vacíos.");
									$goto = 'Location: index.php?controller=adminGrupos&action=addResultado&idenfrentamiento='. $_REQUEST["idenfrentamiento"];
									header($goto);
								}
								else{

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

									$enfrentamiento = new EnfrentamientoModel($_REQUEST["idenfrentamiento"]);
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

									$pareja1 = new ParejaModel();
									$pareja2 = new ParejaModel();
									$pareja1->setId($_REQUEST['pareja1']);
									$pareja2->setId($_REQUEST['pareja2']);

									$parejaMapper = new ParejaMapper();

									if($_REQUEST['resultado'] != null){
								
										$pj1 = substr($_REQUEST['resultado'], 0,1);
										$pj2 = substr($_REQUEST['resultado'], -1);

										if($pj1 > $pj2){
											$parejaMapper->deletePuntosGanador($pareja1);
											$parejaMapper->deletePuntosPerdedor($pareja2);
										}
										else{
											$parejaMapper->deletePuntosGanador($pareja2);
											$parejaMapper->deletePuntosPerdedor($pareja1);
										}
									}

									if($resultado['ganador'] == 1){
										$parejaMapper->addPuntosGanador($pareja1);
										$parejaMapper->addPuntosPerdedor($pareja2);
									}
									else{
										$parejaMapper->addPuntosGanador($pareja2);
										$parejaMapper->addPuntosPerdedor($pareja1);
									}

									

									SessionMessage::setMessage($respuesta);
									$goto = 'Location:index.php?controller=adminGrupos&idgrupo='. $_REQUEST['idgrupo'];
									header($goto);
								}

							}
							catch (ValidationException $e){
									SessionMessage::setErrores($e->getErrores());
									SessionMessage::setMessage($e->getMessage());
									$goto = 'Location: index.php?controller=adminGrupos&action=addResultado&idenfrentamiento='. $_REQUEST["idenfrentamiento"];
									header($goto);
							}
						}else{
							$enf = new EnfrentamientoModel();
							$enf->setId($_REQUEST["idenfrentamiento"]);
							$enfMapper = new EnfrentamientoMapper();
							$datos = $enfMapper->consultarDatos($enf);
							require_once('Views/campeonato/gestionResultadoView.php');
							(new GestionResultadoView(SessionMessage::getMessage(),'','',$datos))->render();
						}
						break;

					
					case 'DETAILS': 
						$enfrentamiento = new EnfrentamientoModel();
						$enfrentamiento->setId($_REQUEST['idenfrentamiento']);
						$enfrentamientoMapper = new EnfrentamientoMapper();
						$datos = $enfrentamientoMapper->consultarDatos($enfrentamiento);
						require_once('Views/campeonato/enfrentamientoDetailsView.php');
						(new EnfrentamientoDetailsView('','','',$datos))->render();
						break;


					default: 
						echo "hey, estoy viniendo aquí";
						header('Location: index.php?controller=adminUsuarios');
						break;

				}
            } else { //mostrar todos los elementos
                $grupo = new GrupoModel();
                $grupo->setId($_REQUEST['idgrupo']);
				$grupoMapper = new GrupoMapper();
				$parejas = $grupoMapper->getParejasByGrupo($grupo); 
				$enfrentamientos = $grupoMapper->getEnfrentamientosByGrupo($grupo);
				$datos = $grupoMapper->getDatosGrupo($grupo);
				require_once('Views/campeonato/grupoDetailsView.php');
				(new GrupoDetailsView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$enfrentamientos,'',$parejas, $datos))->render();
			}
		}
	}

 ?>
