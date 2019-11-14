<?php

require_once('Models/horaModel.php');

    class ParejaMapper{
        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($pareja){

            $nombre_pareja = $pareja->getNombre();
            $capitan = $pareja->getCapitan();
            $miembro = $pareja->getMiembro();
            $fecha_inscrip = $pareja->getFechaInscrip();
            $id_catcamp = $pareja->getCatCamp();
				
            $sql = "INSERT INTO PAREJA (nombre_pareja,capitan,miembro,fecha_inscrip,id_catcamp,puntos)
                    VALUES ('$nombre_pareja','$capitan','$miembro','$fecha_inscrip','$id_catcamp',0)";
    
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
                    
                return "Inscripción cancelada.";
            } 
            else
                return "No existe";
        } 
        
        
        function mostrarTodos() {
            
            $sql = "SELECT id_pareja, nombre_pareja, capitan, miembro, fecha_inscrip, id_grupo, id_catcamp, puntos 
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


        function getUsuarioRepetidoEnCategoria($pareja){

            $capitan = $pareja->getCapitan();
            $miembro = $pareja->getMiembro();
            $id_catcamp = $pareja->getCatCamp();

            $sql = "SELECT * FROM PAREJA 
                    WHERE id_catcamp = '$id_catcamp' AND 
                    (capitan = '$capitan' OR miembro = '$capitan' OR capitan = '$miembro' OR miembro = '$miembro')";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows != 0){
                return true;
            }
            else{
                return false;
            }

        }


        function getNombreById($pareja){

            $id = $pareja->getId();

            $sql = "SELECT * FROM PAREJA WHERE id_pareja = '$id'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
            }

            return $tupla['1'];
        }


        function validarNombrePorCampeonato($pareja,$campeonato){
            
            $nombre = $pareja->getNombre();
            $id = $campeonato->getId();

            $sql = "SELECT nombre_pareja 
            FROM PAREJA INNER JOIN (campeonato_categoria 
                                    INNER JOIN campeonato 
                                    ON campeonato_categoria.id_campeonato = campeonato.id_campeonato
                                    INNER JOIN categoria 
                                    ON campeonato_categoria.id_categoria = categoria.id_categoria) 
            ON pareja.id_catcamp = campeonato_categoria.id_catcamp
            WHERE campeonato.id_campeonato = '$id' AND nombre_pareja = '$nombre'";

            $resultado = $this->mysqli->query($sql);

            if ($resultado->num_rows != 0){
                return true;
            }
            else{
                return false;
            }
        }


    }

?>