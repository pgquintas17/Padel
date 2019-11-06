<?php

require_once('Models/partidoModel.php');

    class PartidoMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($partido){

            $hora = $partido->getHora();
            $fecha = $partido->getFecha(); 
    
                $sql = "SELECT * FROM PARTIDO";
    
                if (!$result = $this->mysqli->query($sql)) 
                    return 'No se ha podido conectar con la base de datos'; 
                else { 
                    
                    $sql = "INSERT INTO PARTIDO (
                            hora,
                            fecha
                        )
                        VALUES (
                            '$hora',
                            '$fecha'
                        )";

                    if (!$this->mysqli->query($sql)){
                        return 'Error en la inserción';
                    } 
                    else {
                        return 'Registro completado con éxito. Recuerda promocionar el partido para darle difusión.';
                    } 
                }

        }


        function DELETE($partido) {	

            $id_partido = $partido->getId();
		
            $sql = "SELECT * FROM USUARIO  WHERE (id_partido = '$id_partido') ";    
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
                
            if ($result->num_rows == 1) {
                    
                $sql = "DELETE FROM  USUARIO WHERE (id_partido = '$id_partido')";   
                $this->mysqli->query($sql);
                
                return "Borrado correctamente";
            } 
            else
                return "No existe";
        }


        function mostrarTodos() {
		
            $sql = "SELECT 
                        id_partido,
                        resultado,
                        hora,
                        fecha,
                        promocion,
                        login1,
                        login2,
                        login3,
                        login4,
                        id_reserva

                    FROM PARTIDO
                    ORDER BY fecha DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }


        function consultarDatos($partido) {	

            $id_partido = $partido->getId();

            $sql = "SELECT * FROM PARTIDO WHERE (id_partido = '$id_partido')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }


        function crearFiltros($partido,$filtros) {
            $toret = "( ";

            $hora = $partido->getHora();
            $fecha = $partido->getFecha();

            foreach($filtros as $filtro) {
                switch($filtro) {
                    case "hora":
                        $toret .= "(hora = '$hora')";
                        break;
                    case "fecha":
                        $toret .= "(fecha = '$fecha')";
                        break;
                }
                $toret .= " && ";
            }
            $toret = chop($toret," && ");
            $toret .= " )";
    
            $sql = "SELECT * FROM PARTIDO WHERE " . $toret;
    
            if (!($resultado = $this->mysqli->query($sql))) {
                return 'Error en la consulta sobre la base de datos';
            }
            else {
                return $resultado;
            }   
        }


        function añadirReserva($partido,$reserva){

            $id_reserva = $reserva->getId();
            $id_partido = $partido->getId();

            $sql = "UPDATE PARTIDO  SET id_reserva = '$id_reserva' 
                    WHERE ( id_partido = '$id_partido' )";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la modificación';
            }      
            else{
                return true;
            }      
        }


        function añadirResultado($partido){

            $resultado = $partido->getResultado();
            $id_partido = $partido->getId();

            $sql = "UPDATE PARTIDO  SET resultado = '$resultado' 
                    WHERE ( id_partido = '$id_partido' )";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la modificación';
            }      
            else{
                return true;
            }      
        }


        function añadirParticipante($partido,$usuario){

            $login = $usuario->getLogin();
            $id_partido = $partido->getId();

            $sql = "SELECT * FROM PARTIDO WHERE id_partido = '$id_partido')";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);

                if($tupla['5'] == null & $tupla['5'] != $login){
                    $sql2 = "UPDATE PARTIDO SET login1 = '$login' 
                    WHERE ( id_partido = '$id_partido' )";
                } 
                else if($tupla['6'] == null & $tupla['6'] != $login){
                    $sql2 = "UPDATE PARTIDO SET login2 = '$login' 
                    WHERE ( id_partido = '$id_partido' )";
                } 
                else if($tupla['7'] == null & $tupla['7'] != $login){
                    $sql2 = "UPDATE PARTIDO SET login3 = '$login' 
                    WHERE ( id_partido = '$id_partido' )";
                }
                else{
                    $sql2 = "UPDATE PARTIDO SET login4 = '$login' 
                    WHERE ( id_partido = '$id_partido' )";
                }

                if (!($resultado = $this->mysqli->query($sql2)))
                    return 'Error en la modificación';
                else
                    return true;
            }
        }


        function cambiarPromocion($partido){

            $id_partido = $partido->getId();
            
            $sql = "SELECT * FROM PARTIDO  WHERE (id_partido = '$id_partido') ";
    	    $result = $this->mysqli->query($sql);
                
            $tupla = $result->fetch_array(MYSQLI_NUM);
            
            if($tupla['4'] == 0){
                $sql2 = "UPDATE PARTIDO  SET promocion = 1 WHERE ( id_partido = '$id_partido')";
            }
            else{
                $sql2 = "UPDATE PARTIDO  SET promocion = 0 WHERE ( id_partido = '$id_partido')";
            }

            if (!($resultado = $this->mysqli->query($sql2))){
                return 'Error en la modificación';
            }   
            else{
                return true;
            }
        }



        function getNumPlazasLibres($id_partido){

            $numPlazas = 0;

            $sql = "SELECT * FROM PARTIDO WHERE id_partido = '$id_partido'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);

                if($tupla['5'] == null){
                    $numPlazas++;
                } 
                
                if($tupla['6'] == null){
                    $numPlazas++;;
                } 
                
                if($tupla['7'] == null){
                    $numPlazas++;;
                }

                if($tupla['8'] == null){
                    $numPlazas++;;
                }

                return $numPlazas;
            }
        }


        function getPartidosPromocionadosFromFecha($fecha) {

            $sql = "SELECT id_partido,
                            resultado,
                            hora,
                            fecha,
                            promocion,
                            login1,
                            login2,
                            login3,
                            login4,
                            id_reserva 
                    FROM PARTIDO 
                    WHERE promocion = 1 AND fecha >= '$fecha' 
                    ORDER BY fecha";
    
            if (!($resultado = $this->mysqli->query($sql))){
                return null;
            }else{
                return $resultado;
            }
        }



        // AÑADIR FUNCIÓN:
        // añadirReserva($partido,$reserva)
            /* ¿Qué se hace si no hay reserva disponible? ¿Cómo se cancela el partido? 
                1. Poner el resultado todo a 0 ??*/
        // añadirResultado($partido,$resultado)
            /* (buscar cómo son los resultados en pádel). */




        /* En el inicio usar la función de crearFiltros para mostrar los partidos que sean posteriores a la fecha
           y que aún tengas plazas disponibles. Se mostrará la fecha y hora, un mensaje genérico, número de plazas
           disponibles y botón para apuntarse*/
    }

?>