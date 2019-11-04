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
            $estado = $pista->getEstado();
            echo "id_pista: ", $id_pista;
            echo "    estado: ", $estado;
    
            $sql = "SELECT * FROM PISTA";

            if (!$result = $this->mysqli->query($sql)){ 
                return false; 
            }
            else { 
                $sql2 = "INSERT INTO PISTA (id_pista, estado)
                        VALUES ('$id_pista', '$estado')";

                if (!$this->mysqli->query($sql2)){ 
                    return false;
                }else{ 
                    return true;
                } 
            } 
        }


        function mostrarTodos() {
		
            $sql = "SELECT id_pista, estado FROM PISTA";
    
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
                
                if($tupla['1'] == 0){
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

            $sql = "SELECT COUNT (*) FROM PISTA WHERE estado = 1";

    	if (!($resultado = $this->mysqli->query($sql))) {
			return 'Error en la consulta sobre la base de datos';
		}
    	else 
			return $resultado;
        }


        function crearFiltros($pista,$filtros) {
            
            $estado = $pista->getEstado();
            $toret = "( ";
             
            foreach($filtros as $filtro) {
                switch($filtro) {
                    case "estado":
                        $toret .= "(estado = '$estado')";
                        break;
                }
                $toret .= " && ";
            }
            $toret = chop($toret," && ");
            $toret .= " )";
    
            $sql = "SELECT * FROM PISTA WHERE " . $toret;
    
            if (!($resultado = $this->mysqli->query($sql))) {
                return 'Error en la consulta sobre la base de datos';
            }
            else 
                return $resultado;
        }


    }

?>