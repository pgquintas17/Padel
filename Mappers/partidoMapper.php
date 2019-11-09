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
		
            $sql = "SELECT * FROM PARTIDO  WHERE (id_partido = '$id_partido') ";    
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
                
            if ($result->num_rows == 1) {
                    
                $sql = "DELETE FROM  PARTIDO WHERE (id_partido = '$id_partido')";   
                $this->mysqli->query($sql);
                
                return "Partido eliminado";
            } 
            else
                return "No existe";
        }


        function mostrarTodos() {
		
            $sql = "SELECT 
                        id_partido,
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


        function añadirReserva($partido){

            $id_reserva = $partido->getIdReserva();
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


        function comprobarDisponibilidadUsuario($reserva){

            $hora = $reserva->getHora();
            $fecha = $reserva->getFecha();
            $login = $reserva->getLogin();   

            $sql2 = "SELECT * FROM PARTIDO 
                        WHERE (hora = '$hora' AND fecha = '$fecha' AND
                        (login1 = '$login' OR login2 = '$login' 
                        OR login3 = '$login' OR login4 = '$login'))";

            if (!($resultado = $this->mysqli->query($sql2))){
                return false;
            }
            else{
                if ($resultado->num_rows == 0) {
                    return true;
                }
                else{
                    return false;
                }
            }

        }


        function cancelarInscripcion($partido,$usuario){

            $id_partido = $partido->getId();
            $login = $usuario->getLogin();   

            $sql = "SELECT * FROM PARTIDO 
                        WHERE (id_partido = '$id_partido' AND
                        (login1 = '$login' OR login2 = '$login' 
                        OR login3 = '$login' OR login4 = '$login'))";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);

                if($tupla['4'] == $login){
                    $sql2 = "UPDATE PARTIDO SET login1 = NULL 
                    WHERE ( id_partido = '$id_partido' )";
                } 
                else if($tupla['5'] == $login){
                    $sql2 = "UPDATE PARTIDO SET login2 = NULL 
                    WHERE ( id_partido = '$id_partido' )";
                } 
                else if($tupla['6'] == $login){
                    $sql2 = "UPDATE PARTIDO SET login3 = NULL 
                    WHERE ( id_partido = '$id_partido' )";
                }
                else{
                    $sql2 = "UPDATE PARTIDO SET login4 = NULL 
                    WHERE ( id_partido = '$id_partido' )";
                }

                if (!($resultado = $this->mysqli->query($sql2)))
                    return 'Error en la modificación';
                else
                    return 'Tu inscripción en el partido ha sido cancelada.';
            }

        }


        function getHoraById($partido){
            
            $id_partido = $partido->getId();

            $sql = "SELECT * FROM PARTIDO WHERE id_partido = '$id_partido'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
            }

            return $tupla['1'];
        }


        function getFechaById($partido){

            $id_partido = $partido->getId();

            $sql = "SELECT * FROM PARTIDO WHERE id_partido = '$id_partido'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
            }

            return $tupla['2'];
        }


        function añadirParticipante($partido,$usuario){

            $login = $usuario->getLogin();
            $id_partido = $partido->getId();

            $sql = "SELECT * FROM PARTIDO WHERE id_partido = '$id_partido'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);

                if($tupla['4'] == null){
                    $sql2 = "UPDATE PARTIDO SET login1 = '$login' 
                    WHERE ( id_partido = '$id_partido' )";
                } 
                else if($tupla['5'] == null){
                    $sql2 = "UPDATE PARTIDO SET login2 = '$login' 
                    WHERE ( id_partido = '$id_partido' )";
                } 
                else if($tupla['6'] == null){
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
                    return 'Te has apuntado correctamente al partido.';
            }
        }


        function cambiarPromocion($partido){

            $id_partido = $partido->getId();
            
            $sql = "SELECT * FROM PARTIDO  WHERE (id_partido = '$id_partido') ";
    	    $result = $this->mysqli->query($sql);
                
            $tupla = $result->fetch_array(MYSQLI_NUM);
            
            if($tupla['3'] == 0){
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

                if($tupla['4'] == null){
                    $numPlazas++;
                } 
                
                if($tupla['5'] == null){
                    $numPlazas++;;
                } 
                
                if($tupla['6'] == null){
                    $numPlazas++;;
                }

                if($tupla['7'] == null){
                    $numPlazas++;;
                }

                return $numPlazas;
            }
        }


        function getReservaById($id_partido){

            $sql = "SELECT * FROM PARTIDO  WHERE (id_partido = '$id_partido') ";
    	    $result = $this->mysqli->query($sql);
                
            $tupla = $result->fetch_array(MYSQLI_NUM);
            
            return $tupla['8'];

        }


        function getPartidosPromocionadosFromFecha($fecha) {

            $sql = "SELECT id_partido,
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


        function getPartidosByLogin($usuario){

            $login = $usuario->getLogin();

            $sql = "SELECT id_partido,
                            hora,
                            fecha,
                            promocion,
                            login1,
                            login2,
                            login3,
                            login4,
                            id_reserva 
                    FROM PARTIDO 
                    WHERE   (login1 = '$login' OR login2 = '$login' 
                            OR login3 = '$login' OR login4 = '$login') 
                    ORDER BY fecha DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;


        }
    }

?>