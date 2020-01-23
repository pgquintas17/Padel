<?php

require_once('Models/pistaModel.php');

    class PistaMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($pista){

            $id_pista = $pista->getId();
            $tipo = $pista->getTipo();
            $estado = $pista->getEstado();
    
            $sql = "SELECT * FROM PISTA  WHERE (id_pista = '$id_pista') ";
            $result = $this->mysqli->query($sql);
    
            if ($result->num_rows == 1) {
                return 'Ya existe una pista con ese número';
            }else{ 
                $sql2 = "INSERT INTO PISTA (id_pista, tipo, estado)
                        VALUES ('$id_pista', '$tipo', '$estado')";

                if (!$this->mysqli->query($sql2)){ 
                    return $sql2;
                }else{ 
                    return "La pista ha sido añadida. Recuerda activarla para su uso.";
                } 
            } 
        }


        function mostrarTodos() {
		
            $sql = "SELECT id_pista, tipo, estado FROM PISTA";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }
        
    
        function consultarEstado($pista) {
            
            $id_pista = $pista->getId();
    
            $sql = "SELECT estado FROM PISTA WHERE (id_pista = '$id_pista')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array();
                return $result;
            }
        }


        function cambiarEstado($pista){

            $id_pista = $pista->getId();
            
            $sql = "SELECT * FROM PISTA  WHERE (id_pista = '$id_pista') ";
    	    $result = $this->mysqli->query($sql);
    
            if ($result->num_rows == 1) {
                
                $tupla = $result->fetch_array(MYSQLI_NUM);
                
                if($tupla['2'] == 0){
                    $sql2 = "UPDATE PISTA  SET estado = 1 WHERE ( id_pista = '$id_pista')";
                }
                else{
                    $sql2 = "UPDATE PISTA  SET estado = 0 WHERE ( id_pista = '$id_pista')";
                }

                if (!($resultado = $this->mysqli->query($sql2)))
                    return 'Error en la modificación';
                else
                    return true;
            }
            else 
                return 'No existe en la base de datos';
        }


        function getNumPistasActivas(){

            $sql = "SELECT COUNT(*) FROM PISTA WHERE estado = '1'";

            if (!($resultado = $this->mysqli->query($sql))) {
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result['0'];
            } 
        }

        function getNumPistasActivasPorTipo($pista){

            $tipo = $pista->getTipo();

            $sql = "SELECT COUNT(*) FROM PISTA WHERE estado = '1' AND tipo = '$tipo'";

            if (!($resultado = $this->mysqli->query($sql))) {
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result['0'];
            } 
        }


        function findPistaLibre($reserva){

            $hora = $reserva->getHora();
            $fecha = $reserva->getFecha();

            $sql="SELECT PISTA.ID_PISTA FROM PISTA 
                  WHERE NOT EXISTS(SELECT 1 FROM RESERVA 
                                   WHERE RESERVA.ID_PISTA=PISTA.ID_PISTA 
                                   AND RESERVA.HORA= '$hora' 
                                   AND RESERVA.FECHA= '$fecha') AND estado = 1 LIMIT 1";

            $result = $this->mysqli->query($sql);
            $tupla = $result->fetch_array(MYSQLI_NUM);

            return $tupla['0'];
            
        }

        function findPistaLibrePorTipo($reserva,$pista){

            $hora = $reserva->getHora();
            $fecha = $reserva->getFecha();
            $tipo = $pista->getTipo();

            $sql="SELECT PISTA.ID_PISTA FROM PISTA 
                  WHERE NOT EXISTS(SELECT 1 FROM RESERVA 
                                   WHERE RESERVA.ID_PISTA=PISTA.ID_PISTA 
                                   AND RESERVA.HORA= '$hora' 
                                   AND RESERVA.FECHA= '$fecha') AND tipo = '$tipo' AND estado = 1 LIMIT 1";

            $result = $this->mysqli->query($sql);
            $tupla = $result->fetch_array(MYSQLI_NUM);

            return $tupla['0'];
            
        }


    }

?>