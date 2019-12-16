<?php

require_once('Models/usuarioModel.php');
require_once('Mappers/usuarioMapper.php');
require_once('Models/reservaModel.php');
require_once('Mappers/reservaMapper.php');
require_once('Mappers/partidoMapper.php');
require_once('Mappers/enfrentamientoMapper.php');

class Utils {

    static function conectado(){
	    if (!isset($_SESSION['Usuario']))
		    return false;
	    else
		    return true;
	}

	static function desconectar() {
		session_start();
		session_destroy();
		header('Location: index.php');
	}
	
	static function nivelPermiso($nivelRequerido){
		
		$login = $_SESSION['Usuario']->getLogin();
		$control = new UsuarioModel();
		$control->setLogin($login);
		$controlMapper = new UsuarioMapper();
		$resultado = $controlMapper->comprobarNivelAcceso($control,$nivelRequerido);
		if($resultado == true)
			return true;
		else
			return false;
	}


	static function calcularResultado($set1, $set2, $set3){

		require_once('Models/setModel.php');

		$puntosPareja1 = 0;
		$puntosPareja2 = 0;

		if($set1->getPareja1() > $set1->getPareja2()){
			$puntosPareja1++;
		}
		else{
			$puntosPareja2++;
		}

		if($set2->getPareja1() > $set2->getPareja2()){
			$puntosPareja1++;
		}
		else{
			$puntosPareja2++;
		}

		if(($puntosPareja1 == 2 || $puntosPareja2 == 2) && $set3->getPareja1() == null){

			if($puntosPareja1 > $puntosPareja2){
				
				return array("puntos1"=>$puntosPareja1, "puntos2"=>$puntosPareja2, "ganador"=>1);
			}
			
			if($puntosPareja1 > $puntosPareja2){
				
				return array("puntos1"=>$puntosPareja1, "puntos2"=>$puntosPareja2, "ganador"=>2);
			}
		} 
		else if (($puntosPareja1 == 2 || $puntosPareja2 == 2) && $set3->getPareja1() != null){
			$errores = array();
			$errores['puntuación1'] = "Puntuación de set no válida.";
			throw new ValidationException($errores, "Datos no válidos");
		}
		else if (($puntosPareja1 < 2 && $puntosPareja2 < 2) && $set3->getPareja1() == null){
			$errores = array();
			$errores['puntuación2'] = "Puntuación de set no válida.";
			throw new ValidationException($errores, "Datos no válidos");
		}
		else{

			if($set3->getPareja1() > $set3->getPareja2()){
				$puntosPareja1++;
	
				return array("puntos1"=>$puntosPareja1, "puntos2"=>$puntosPareja2, "ganador"=>1);
			}

			if($set3->getPareja1() < $set3->getPareja2()){
				$puntosPareja2++;
	
				return array("puntos1"=>$puntosPareja1, "puntos2"=>$puntosPareja2, "ganador"=>2);
			}
		}
	}


	static function validarDisponibilidad($login,$fecha,$hora){

		$reserva = new ReservaModel();
		$reserva->setLogin($login);
		$reserva->setFecha($fecha);
		$reserva->setHora($hora);
		$reservaMapper = new ReservaMapper();
		$validacion1 = $reservaMapper->comprobarDisponibilidadUsuario($reserva);
		$partidoMapper = new PartidoMapper();
		$validacion2 = $partidoMapper->comprobarDisponibilidadUsuario($reserva);
		$enfrentamientoMapper = new EnfrentamientoMapper();
		$validacion3 = $enfrentamientoMapper->comprobarDisponibilidadUsuario($reserva);
		$validacion4 = $enfrentamientoMapper->comprobarDisponibilidadPropuestaUsuario($reserva);

		if($validacion1 && $validacion2 && $validacion3 && $validacion4){
			return true;
		}
		else{
			return false;
		}
	}
    
}
?>

