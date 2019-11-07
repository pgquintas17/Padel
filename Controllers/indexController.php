<?php

	require_once('Services/Utils.php');
	require_once('Views/indexView.php');
	require_once('Mappers/partidoMapper.php');
	require_once('Services/sessionMensajes.php');

class IndexController {

	function __construct(){
		$usuario = null;

		$fecha = date('Y-m-d');
		$partidos = (new PartidoMapper())->getPartidosPromocionadosFromFecha($fecha);

		if (Utils::conectado()) {
			$usuario = $_SESSION['Usuario'];
		}
		
		(new IndexView(SessionMessage::getMessage(),SessionMessage::getErrores(),$usuario,'',$partidos))->render();
	}
}

?>