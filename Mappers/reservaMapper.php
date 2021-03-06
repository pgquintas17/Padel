<?php

require_once('Models/reservaModel.php');

    class ReservaMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($reserva){

            $id_reserva = $reserva->getId();
            $id_pista = $reserva->getIdPista();
            $hora = $reserva->getHora();
            $fecha = $reserva->getFecha();
            $login = $reserva->getLogin();
    
            $sql = "SELECT * FROM RESERVA";

            if (!$result = $this->mysqli->query($sql)) 
                return 'No se ha podido conectar con la base de datos'; 
            else {
                
                $sql = "INSERT INTO RESERVA (
                        id_reserva,
                        id_pista,
                        hora,
                        fecha,
                        login
                    )
                    VALUES (
                        '$id_reserva',
                        '$id_pista',
                        '$hora',
                        '$fecha',
                        '$login'
                    )";

                if (!$this->mysqli->query($sql)){
                    return 'Error en la inserción';
                } 
                else{
                    return 'Inserción realizada con éxito';  
                } 
            } 
        }


        function DELETE($reserva) {	

            $id_reserva = $reserva->getId();
		
            $sql = "SELECT * FROM RESERVA WHERE (id_reserva = '$id_reserva') ";    
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
                
            if ($result->num_rows == 1) {
                    
                $sql = "DELETE FROM  RESERVA WHERE (id_reserva = '$id_reserva')";   
                $this->mysqli->query($sql);
                
                return "Borrado correctamente";
            } 
            else
                return "No existe";
        }


        function mostrarTodos() {
		
            $sql = "SELECT 
                        id_reserva,
                        id_pista,
                        hora
                        fecha,
                        login 
                    FROM RESERVA";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }


        function consultarDatos($reserva) {	

            $id_reserva = $reserva->getId();

            $sql = "SELECT * FROM RESERVA WHERE (id_reserva = '$id_reserva')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }


        function getPistaById($reserva){

            $id_reserva = $reserva->getId();

            $sql = "SELECT id_pista FROM RESERVA WHERE (id_reserva = '$id_reserva')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }

        }


        function getIdReserva($reserva){

            $id_pista = $reserva->getIdPista();
            $fecha = $reserva->getFecha();
            $hora = $reserva->getHora();

            $sql = "SELECT id_reserva FROM RESERVA WHERE hora = '$hora' AND fecha = '$fecha' AND id_pista = '$id_pista'";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result['0'];
            }

        }


        function comprobarDisponibilidadUsuario($reserva){

            $hora = $reserva->getHora();
            $fecha = $reserva->getFecha();
            $login = $reserva->getLogin();   

            $sql2 = "SELECT * FROM RESERVA 
                    WHERE (hora = '$hora' AND fecha = '$fecha' AND login = '$login')";

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


        function getNumReservasByDiaYHora($reserva){

            $hora = $reserva->getHora();
            $fecha = $reserva->getFecha();

            $sql = "SELECT COUNT(*) FROM RESERVA WHERE fecha = '$fecha' AND hora = '$hora'";

            if (!($resultado = $this->mysqli->query($sql))) {
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result['0'];
            }
        }


        function getReservasByPista($pista){

            $id_pista = $pista->getId();

            $sql = "SELECT id_reserva, id_pista, hora, fecha, login 
                    FROM RESERVA WHERE id_pista = '$id_pista' ORDER BY fecha DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;


        }


        function getReservasByLogin($usuario){

            $login = $usuario->getLogin();

            $sql = "SELECT id_reserva, id_pista, hora, fecha, login 
                    FROM RESERVA WHERE login = '$login' ORDER BY fecha DESC";
    
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


        function getNumReservasActivasByLogin($usuario){

            $login = $usuario->getLogin();
            $hoy = date('Y-m-d');

            $sql = "SELECT COUNT(*) 
                    FROM RESERVA WHERE login = '$login' AND fecha > '$hoy'";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else{
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result['0'];
            }
        }


        function cancelarReserva($reserva){

            $id_reserva = $reserva->getId();
            $login = $reserva->getLogin();
		
            $sql = "SELECT * FROM RESERVA WHERE (id_reserva = '$id_reserva' AND login = '$login') ";    
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
                
            if ($result->num_rows == 1) {
                    
                $sql = "DELETE FROM  RESERVA WHERE (id_reserva = '$id_reserva' AND login = '$login')";   
                $this->mysqli->query($sql);
                
                return "Reserva cancelada";
            } 
            else
                return "No existe";

        }


        function getFechaById($reserva){

            $id_reserva = $reserva->getId();

            $sql = "SELECT * FROM RESERVA WHERE id_reserva = '$id_reserva'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                return $tupla['3'];
            }
        }


        function getReservaCanceladaByPista($pista){

            $hoy = date('Y-m-d');

            $sql = "SELECT id_reserva, hora, fecha, login 
                    FROM RESERVA
                    WHERE ID_PISTA = '$pista' AND fecha >= '$hoy'";

            if (!($resultado = $this->mysqli->query($sql))){
                return "Error en la base de datos";
            } else{
                $reservas = array();
                $fila = array('id_reserva', 'hora', 'fecha', 'login');

                while($fila = ($resultado)->fetch_assoc()){

                        $reserva = new ReservaModel();
                        $reserva->setId($fila['id_reserva']);
                        $reserva->setHora($fila['hora']);
                        $reserva->setFecha($fila['fecha']);
                        $reserva->setLogin($fila['login']);
                        $reservas[] = $reserva;
                }

                    return $reservas;

            }

            
        }


    }

?>