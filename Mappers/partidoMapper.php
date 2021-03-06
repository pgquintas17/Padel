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
            $promocion = $partido->getpromocion();
            $creador = $partido->getCreador();
    
                $sql = "SELECT * FROM PARTIDO";
    
                if (!$result = $this->mysqli->query($sql)) 
                    return 'No se ha podido conectar con la base de datos'; 
                else { 
                    
                    $sql = "INSERT INTO PARTIDO (
                            hora,
                            fecha,
                            promocion,
                            creador
                        )
                        VALUES (
                            '$hora',
                            '$fecha',
                            '$promocion',
                            '$creador'
                        )";

                    if (!$this->mysqli->query($sql)){
                        return $sql;
                    } 
                    else {
                        return 'Partido añadido con éxito. Recuerda promocionar el partido para darle difusión.';
                    } 
                }

        }


        function ADDDeportista($partido){

            $hora = $partido->getHora();
            $fecha = $partido->getFecha();
            $promocion = $partido->getpromocion();
            $creador = $partido->getCreador();
            $login1 = $partido->getLogin1();
    
                $sql = "SELECT * FROM PARTIDO";
    
                if (!$result = $this->mysqli->query($sql)) 
                    return 'No se ha podido conectar con la base de datos'; 
                else { 
                    
                    $sql = "INSERT INTO PARTIDO (
                            hora,
                            fecha,
                            promocion,
                            creador,
                            login1
                        )
                        VALUES (
                            '$hora',
                            '$fecha',
                            '$promocion',
                            '$creador',
                            '$login1'
                        )";

                    if (!$this->mysqli->query($sql)){
                        return $sql;
                    } 
                    else {
                        return 'Partido añadido con éxito.';
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
                        id_reserva,
                        creador

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


        function borrarReserva($partido){

            $id_partido = $partido->getId();

            $sql = "SELECT * FROM PARTIDO  WHERE (id_partido = '$id_partido') ";
    	    $result = $this->mysqli->query($sql);
                
            $tupla = $result->fetch_array(MYSQLI_NUM);

            $id_reserva = $tupla['8'];

            $sql = "UPDATE PARTIDO  SET id_reserva = NULL 
                    WHERE ( id_partido = '$id_partido' )";

            $this->mysqli->query($sql);

            $sql2 = "DELETE FROM RESERVA WHERE (id_reserva = '$id_reserva')";

            if (!($resultado = $this->mysqli->query($sql2))){
                return 'Error en la modificación';
            }      
            else{

                return "Reserva eliminada";
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


        function getCreadorById($partido){

            $id_partido = $partido->getId();

            $sql = "SELECT * FROM PARTIDO WHERE id_partido = '$id_partido'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
            }

            return $tupla['9'];
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
                            id_reserva,
                            creador
                             
                    FROM PARTIDO 
                    WHERE promocion = 1 AND fecha >= '$fecha' 
                    ORDER BY fecha";
    
            if (!($resultado = $this->mysqli->query($sql))){
                return null;
            }else{
                if($resultado->num_rows == 0){
                    return null;
                }
                else{
                    return $resultado;
                }
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
                            id_reserva,
                            creador

                    FROM PARTIDO 
                    WHERE   (login1 = '$login' OR login2 = '$login' 
                            OR login3 = '$login' OR login4 = '$login') 
                    ORDER BY fecha DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else{
                if($resultado->num_rows == 0){
                    return null;
                }
                else{
                    return $resultado;
                }
            }
        }

        function getEmailParticipantes($partido){

            $id = $partido->getId();

            $sql = "SELECT usuario1.email as email1, usuario2.email as email2, usuario3.email as email3, usuario4.email as email4
                    FROM partido 
                        INNER JOIN usuario as usuario1 ON usuario1.LOGIN = partido.LOGIN1
                        INNER JOIN usuario as usuario2 ON usuario2.LOGIN = partido.LOGIN2
                        INNER JOIN usuario as usuario3 ON usuario3.LOGIN = partido.LOGIN3
                        INNER JOIN usuario as usuario4 ON usuario4.LOGIN = partido.LOGIN4
                    WHERE partido.ID_PARTIDO = '$id'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{

                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                $emails = array();
                $emails[] = $tupla['0'];
                $emails[] = $tupla['1'];
                $emails[] = $tupla['2'];
                $emails[] = $tupla['3'];

                return $emails;
            }
        }


        function getNumPartidosByCreador($login){

            $sql = "SELECT COUNT(*) FROM PARTIDO WHERE creador = '$login'";

            if (!($resultado = $this->mysqli->query($sql))) {
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result['0'];
            }
        }


        function getPartidoByPista($pista){

            $hoy = date('Y-m-d');

            $sql = "SELECT id_partido, partido.hora, partido.fecha, partido.id_reserva 
                    FROM partido 
                        INNER JOIN RESERVA ON partido.ID_RESERVA=reserva.ID_RESERVA 
                    WHERE reserva.ID_PISTA = '$pista' AND partido.fecha >= '$hoy' ";

            if (!($resultado = $this->mysqli->query($sql))){
                return "Error en la base de datos";
            } else{
                $partidos = array();
                $fila = array('id_partido', 'hora', 'fecha', 'id_reserva');

                while($fila = ($resultado)->fetch_assoc()){

                        $partido = new PartidoModel();
                        $partido->setId($fila['id_partido']);
                        $partido->setHora($fila['hora']);
                        $partido->setFecha($fila['fecha']);
                        $partido->setIdReserva($fila['id_reserva']);
                        $partidos[] = $partido;
                }

                    return $partidos;

            }
        }

    }

?>