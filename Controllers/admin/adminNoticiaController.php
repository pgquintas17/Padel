<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/noticiaModel.php');
	require_once('Mappers/noticiaMapper.php');
	

	class AdminNoticiaController {

		function __construct() {

			if(isset($_REQUEST["action"])) {
				switch($_REQUEST["action"]) {

					case 'ADD': 
						if($_POST){
							try {
								$fecha = date('Y-m-d');
								$noticia = new NoticiaModel();
								$noticia->setTitulo($_REQUEST['titulo']);
								$noticia->setCuerpo($_REQUEST['cuerpo']);
								$noticia->setFechaCreacion($fecha);
								$errores =  $noticia->validarRegistro();
                            	$noticiaMapper = new NoticiaMapper();
								$respuesta = $noticiaMapper->ADD($noticia);

								$emails = (new UsuarioMapper())->getEmailsSuscripcion();
								
								foreach($emails as $email){
									$to_email_address = $email;
									$subject = 'Se ha añadido una noticia.';
									$message = '<html><head></head><body>Hola,<br>Te informamos de que ha sido a&#241;adida una noticia al sistema: <strong>'. $_REQUEST['titulo'] .'</strong><br><br>Un saludo,<br>Padelweb.</p><br><br><p style="font-size:10px";>Si no deseas seguir recibiendo noticias puedes cancelar la suscripci&#243;n desde tu perfil.</p></body></html>';
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									$headers .= 'From: noreply@padelweb.com';
									mail($to_email_address,$subject,$message,$headers);
								}

								SessionMessage::setMessage($respuesta);
								header('Location: index.php?controller=adminNoticias');
							}
							catch (ValidationException $e){
								SessionMessage::setErrores($e->getErrores());
								SessionMessage::setMessage($e->getMessage());
								header('Location: index.php?controller=adminNoticias&action=ADD');
							}
						}else{
							require_once('Views/noticia/noticiaADDView.php');
							(new NoticiaADDView(SessionMessage::getMessage(), SessionMessage::getErrores(),'',''))->render();
						}
						break;
						

					case 'DELETE': 
						echo "delete";
						break;

					case 'EDIT': 
						echo "edit";
						break;
						

					case 'mostrar': 
						echo "mostrar";
						break;


					default: 
						header('Location: index.php?controller=adminNoticias');
						break;

				}
			} else { //mostrar todos los elementos
				$noticiaMapper = new NoticiaMapper();
				$listaNoticias = $noticiaMapper->mostrarTodos(); 
				require_once('Views/noticia/adminNoticiaView.php');
                (new AdminNoticiaView(SessionMessage::getMessage(), SessionMessage::getErrores(),'','',$listaNoticias))->render();
               
			}
		}
	}

 ?>
