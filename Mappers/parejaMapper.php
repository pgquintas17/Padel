<?php

require_once('Models/horaModel.php');

    class CampeonatoCategoriaMapper{
        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($pareja){

            $nombre_pareja = $pareja->getNombre();
            $nombre_pareja = $pareja->getCapitan();
            $nombre_pareja = $pareja->getMiembro();
            $nombre_pareja = $pareja->getIdCatCamp();
				
            $sql = "INSERT INTO PAREJA (nombre_pareja,capitan,miembro,id_catcamp,puntos)
                    VALUES ('$nombre_pareja','$capitan','$miembro','$id_catcamp',0)";
    
            if (!$this->mysqli->query($sql))
                return 'Error en la inserción';
            else
                return 'Inserción realizada con éxito'; 
    
        }
            
            
        function DELETE($pareja) {	

            $id_pareja = $pareja->getId();
            
            $sql = "SELECT * FROM PAREJA  WHERE (id_pareja = '$id_pareja') ";
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
                
            if ($result->num_rows == 1) {
                    
                $sql = "DELETE FROM PAREJA WHERE (id_pareja = '$id_pareja')";
                $this->mysqli->query($sql);
                    
                return "Borrado correctamente";
            } 
            else
                return "No existe";
        } 
        
        
        function mostrarTodos() {
            
            $sql = "SELECT id_pareja, nombre_pareja, capitan, miembro, id_grupo, id_catcamp, puntos 
                    FROM PAREJA";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }
    
    
        function consultarDatos($pareja) {

            $id_pareja = $pareja->getId();
                
            $sql = "SELECT * FROM PAREJA WHERE (id_pareja = '$id_pareja')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }


        function getParejasPorGrupo($grupo){

            $id_grupo = $grupo->getId();

            $sql = "SELECT * FROM PAREJA WHERE id_grupo = $id_grupo";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;

        }


        function addPuntosGanador($pareja){

            $id_pareja = $pareja->getId();
            
            $sql = "SELECT * FROM PAREJA WHERE (id_pareja = '$id_pareja')";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                return 'La categoría no existe';
            else{
                $sql = "UPDATE PAREJA 
                        SET puntos = puntos + 3  
                        WHERE (id_pareja = '$id_pareja')";

                return 'Puntos sumados';
            }
        }


        function addPuntosPerdedor($pareja){

            $id_pareja = $pareja->getId();
            
            $sql = "SELECT * FROM PAREJA WHERE (id_pareja = '$id_pareja')";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                return 'La categoría no existe';
            else{
                $sql = "UPDATE PAREJA 
                        SET puntos = puntos + 1  
                        WHERE (id_pareja = '$id_pareja')";

                return 'Puntos sumados';
            }
        }


    }

?>






}