<?php

require_once('Models/campeonatoModel.php');

    class CampeonatoMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($campeonato){

            $nombre = $campeonato->getNombre();
            $fecha_inicio = $campeonato->getFechaInicio();
            $fecha_fin = $campeonato->getFechaFin();
            $fecha_inicio_inscripciones = $campeonato->getFechaInicioIncripciones();
            $fecha_fin_inscripciones = $campeonato->getFechaFinInscripciones();
			
            $sql = "INSERT INTO CAMPEONATO (
                        nombre,
                        fecha_inicio,
                        fecha_fin,
                        fecha_inicio_inscripciones,
                        fecha_fin_inscripciones
                    )
                    VALUES (
                        '$nombre',
                        '$fecha_inicio',
                        '$fecha_fin',
                        '$fecha_inicio_inscripciones',
                        '$fecha_fin_inscripciones'
                    )";
    
            if (!$this->mysqli->query($sql))
                return 'Error en la inserción';
            else
                return 'Inserción realizada con éxito';
        }
    
    
        function EDIT($campeonato) {

            $id_campeonato = $campeonato->getId();
            $nombre = $campeonato->getNombre();
            $fecha_inicio = $campeonato->getFechaInicio();
            $fecha_fin = $campeonato->getFechaFin();
            $fecha_inicio_inscripciones = $campeonato->getFechaInicioIncripciones();
            $fecha_fin_inscripciones = $campeonato->getFechaFinInscripciones();
    
            $sql = "SELECT * FROM CAMPEONATO  WHERE (id_campeonato = '$id_campeonato') ";
            $result = $this->mysqli->query($sql);
    
            if ($result->num_rows == 1) {
    
                $sql = "UPDATE CAMPEONATO  SET
                            nombre = '$nombre',
                            fecha_inicio = '$fecha_inicio',
                            fecha_fin = '$fecha_fin',
                            fecha_inicio_inscripciones = '$fecha_inicio_inscripciones',
                            fecha_fin_inscripciones = '$fecha_fin_inscripciones'
    
                    WHERE (id_campeonato = '$id_campeonato')";
    
                if (!($resultado = $this->mysqli->query($sql)))
                    return 'Error en la modificación';
                else
                    return 'Modificado correctamente';
            }
            else
                return 'No existe en la base de datos';
        }
    
    
        function mostrarTodos() {
            
            $sql = "SELECT  id_campeonato,
                            nombre,
                            fecha_inicio,
                            fecha_fin,
                            fecha_inicio_inscripciones,
                            fecha_fin_inscripciones 
                    FROM CAMPEONATO";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }
    
    
        function DELETE($campeonato) {

            $id_campeonato = $campeonato->getId();
            
            $sql = "SELECT * FROM CAMPEONATO WHERE (id_campeonato = '$id_campeonato') ";
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
            
            if ($result->num_rows == 1) {
                
                $sql = "DELETE FROM CAMPEONATO WHERE (id_campeonato = '$id_campeonato')";
                $this->mysqli->query($sql);
                
                return "Borrado correctamente";
            }
            else
                return "No existe";
        }
    
        
        function consultarDatos($campeonato) {

            $id_campeonato = $campeonato->getId();

            $sql = "SELECT * FROM CAMPEONATO WHERE (id_campeonato = '$id_campeonato')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array();
                return $result;
            }
        }


        function getCategoriasCampeonato($campeonato){

            $id_campeonato = $campeonato->getId();

            $sql = "SELECT campeonato.NOMBRE, categoria.SEXONIVEL 
                    FROM campeonato 
                    INNER JOIN (campeonato_categoria 
                                JOIN categoria 
                                ON campeonato_categoria.ID_CATEGORIA = categoria.ID_CATEGORIA) 
                    ON campeonato.ID_CAMPEONATO = campeonato_categoria.ID_CAMPEONATO 
                    WHERE campeonato.ID_CAMPEONATO = '$id_campeonato' 
                    ORDER BY categoria.SEXONIVEL";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;

        }


    }

?>