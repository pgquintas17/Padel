<?php

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
		require_once('Models/usuarioModel.php');
		$login = $_SESSION['Usuario']->getLogin();
		$control = new UsuarioModel();
		$control->setLogin($login);
		require_once('Mappers/usuarioMapper.php');
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

		if(($puntosPareja1 == 2 || $puntosPareja2 == 2) && $set3 !=null){
			return false;
		}
		else{
			if($puntosPareja1 > $puntosPareja2){
				
				$resultado = array("puntos1"=>$puntosPareja1, "puntos2"=>$puntosPareja2, "ganador"=>1);
				return $resultado;
			}
			else{
				
				$resultado = array("puntos1"=>$puntosPareja1, "puntos2"=>$puntosPareja2, "ganador"=>2);
				return $resultado;
			}
		}

		if($set3->getPareja1() > $set3->getPareja2()){
			$puntosPareja1++;

			$resultado = array("puntos1"=>$puntosPareja1, "puntos2"=>$puntosPareja2, "ganador"=>1);
			return $resultado;
		}
		else{
			$puntosPareja2++;

			$resultado = array("puntos1"=>$puntosPareja1, "puntos2"=>$puntosPareja2, "ganador"=>2);
			return $resultado;
		}

	}
    
}
?>

