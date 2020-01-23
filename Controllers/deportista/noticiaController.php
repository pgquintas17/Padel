<?php	

	require_once('Services/sessionMensajes.php');
	require_once("Services/validarExcepciones.php");
	require_once('Models/noticiaModel.php');
	require_once('Mappers/noticiaMapper.php');
	

	class NoticiaController {

		function __construct() {

			if(isset($_REQUEST['idnoticia'])) {

                $noticia = new NoticiaModel();
                $noticia->setId($_REQUEST['idnoticia']);
                $noticiaMapper = new NoticiaMapper();
                $datos = $noticiaMapper->consultarDatos($noticia);
                require_once('Views/noticia/noticiaDetailsView.php');
                (new NoticiaDetailsView('','','',$datos))->render();
				
            }
            else{
                header('Location: index.php');
            }
        }
			
		
	}

 ?>
