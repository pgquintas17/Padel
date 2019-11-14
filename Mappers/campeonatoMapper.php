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
            $fecha_inicio_inscripciones = $campeonato->getFechaInicioInscripciones();
            $fecha_fin_inscripciones = $campeonato->getFechaFinInscripciones();

            $sql = "SELECT * FROM CAMPEONATO  WHERE (nombre = '$nombre') ";
            $result = $this->mysqli->query($sql);
    
            if ($result->num_rows == 1) {
                return 'Ya existe un campeonato con ese nombre';
            }else{
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
                    return 'Campeonato creado';

            }

        }

    
        function mostrarTodos() {
            
            $sql = "SELECT  id_campeonato,
                            nombre,
                            fecha_inicio,
                            fecha_fin,
                            fecha_inicio_inscripciones,
                            fecha_fin_inscripciones 
                    FROM CAMPEONATO
                    ORDER BY fecha_fin DESC";
    
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
                
                return "Campeonato borrado correctamente.";
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


        function getCampeonatosEnInscripcion(){

            $hoy = date('Y-m-d H:i:s');

            $sql = "SELECT id_campeonato,
                            nombre,
                            fecha_inicio,
                            fecha_fin,
                            fecha_inicio_inscripciones,
                            fecha_fin_inscripciones 
                    FROM CAMPEONATO 
                    WHERE fecha_inicio_inscripciones <= '$hoy' AND fecha_fin_inscripciones >= '$hoy'
                    ORDER BY fecha_fin_inscripciones";
    
            if (!($resultado = $this->mysqli->query($sql))){
                return null;
            }
            else{
                if($resultado->num_rows == 0){
                    return null;
                }
                else{
                    return $resultado;
                }
            }
        }


        function getCampeonatosByLogin($usuario){

            $login = $usuario->getLogin();

            $sql = "SELECT campeonato.fecha_fin, campeonato.id_campeonato, campeonato.nombre, campeonato.fecha_fin_inscripciones, 
                           categoria.sexonivel, 
                           pareja.nombre_pareja, pareja.capitan, pareja.miembro, pareja.id_pareja 
                    FROM campeonato INNER JOIN 
                                    (categoria INNER JOIN 
                                                (campeonato_categoria INNER JOIN pareja 
                                                ON campeonato_categoria.ID_CATCAMP=pareja.ID_CATCAMP) 
                                    ON campeonato_categoria.ID_CATEGORIA = categoria.ID_CATEGORIA) 
                    ON campeonato.ID_CAMPEONATO = campeonato_categoria.ID_CAMPEONATO 
                    WHERE pareja.MIEMBRO = '$login' OR pareja.CAPITAN = '$login' 
                    ORDER BY campeonato.fecha_fin DESC";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                if($resultado->num_rows == 0){
                    return null;
                }
                else{
                    return $resultado;
                }
            }
        }



        function getIdByNombre($campeonato){

            $nombre = $campeonato->getNombre();

            $sql = "SELECT * FROM CAMPEONATO WHERE nombre = '$nombre'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
            }

            return $tupla['0'];
        }



        function getNombreById($campeonato){

            $id = $campeonato->getId();

            $sql = "SELECT * FROM CAMPEONATO WHERE id_campeonato = '$id'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
            }

            return $tupla['1'];
        }


        function getFechaFinInsById($campeonato){

            $id = $campeonato->getId();

            $sql = "SELECT * FROM CAMPEONATO WHERE id_campeonato = '$id'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
            }

            return $tupla['5'];

        }


        function getCategoriasByCampeonato($campeonato){

            $id = $campeonato->getId();

            $sql = "SELECT categoria.sexonivel, campeonato_categoria.id_catcamp 
                    FROM categoria INNER JOIN 
                                    (campeonato_categoria INNER JOIN campeonato 
                                    ON campeonato_categoria.id_campeonato=campeonato.id_campeonato) 
                    ON campeonato_categoria.ID_CATEGORIA = categoria.ID_CATEGORIA
                    WHERE campeonato.id_campeonato = '$id'
                    ORDER BY categoria.sexonivel";

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


        function getNumCategoriasByCampeonato($campeonato){

            $id = $campeonato->getId();

            $sql = "SELECT COUNT(*) 
                    FROM categoria INNER JOIN 
                                    (campeonato_categoria INNER JOIN campeonato 
                                    ON campeonato_categoria.id_campeonato=campeonato.id_campeonato) 
                    ON campeonato_categoria.ID_CATEGORIA = categoria.ID_CATEGORIA
                    WHERE campeonato.id_campeonato = '$id'";

            if (!($resultado = $this->mysqli->query($sql))) {
                return 'Error en la consulta sobre la base de datos';
            }
            else{
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result['0'];
            }
        }


        function getCategoriasNotInCampeonato($campeonato){

            $id = $campeonato->getId();

            $sql = "SELECT id_categoria, sexonivel 
                    FROM categoria 
                    WHERE NOT EXISTS(SELECT 1 
                                     FROM campeonato_categoria 
                                     WHERE campeonato_categoria.id_categoria=categoria.id_categoria 
                                     AND id_campeonato = '$id')
                    ORDER BY sexonivel";

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


        function getParejasByCampeonato($campeonato){

            $id = $campeonato->getId();

            $sql = "SELECT id_pareja, nombre_pareja, capitan, miembro, fecha_inscrip, id_grupo, pareja.id_catcamp, puntos, sexonivel 
                    FROM PAREJA INNER JOIN (campeonato_categoria 
                                            INNER JOIN campeonato 
                                            ON campeonato_categoria.id_campeonato = campeonato.id_campeonato
                                            INNER JOIN categoria 
                                            ON campeonato_categoria.id_categoria = categoria.id_categoria) 
                    ON pareja.id_catcamp = campeonato_categoria.id_catcamp
                    WHERE campeonato.id_campeonato = '$id'
                    ORDER BY puntos DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;

        }


    }

?>