<?php

    class GrupoMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($grupo){

            $id_catcamp = $grupo->getIdCatCamp();
            $n_parejas = $grupo->getNumParejas();
            $numero = $grupo->getNumero();

            $sql = "INSERT INTO GRUPO (
                        id_catcamp,
                        numero,
                        n_parejas
                    )
                    VALUES (
                        '$id_catcamp',
                        '$numero',
                        '$n_parejas'
                    )";
            if (!$this->mysqli->query($sql))
                return 'Error en la inserción';
            else 
                return 'Inserción realizada con éxito'; 
        }
    
            
        function DELETE($grupo) {
            
            $id_grupo = $grupo->getId();
            
            $sql = "SELECT * FROM GRUPO  WHERE id_grupo = '$id_grupo' ";
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
                
            if ($result->num_rows == 1) {
                    
                $sql = "DELETE FROM GRUPO WHERE (id_grupo = '$id_grupo')";
                $this->mysqli->query($sql);
                    
                return "Borrado correctamente";
            } 
            else
                return "No existe";
        } 
    
    
        function mostrarTodos() {
            
            $sql = "SELECT id_grupo, id_catcamp, numero, n_parejas FROM GRUPO";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }
    
    
        function consultarDatos($grupo) {

            $id_grupo = $grupo->getId();
    
            $sql = "SELECT * FROM GRUPO WHERE id_grupo = '$id_grupo'";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }


        function getParejasByGrupo($grupo){

            $id = $grupo->getId();

            $sql = "SELECT id_pareja, nombre_pareja, capitan, miembro, fecha_inscrip, id_grupo, id_catcamp, puntos 
                    FROM PAREJA
                    WHERE id_grupo = '$id'
                    ORDER BY puntos DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;

        }


        function getEnfrentamientosByGrupo($grupo){

            $id = $grupo->getId();

            $sql = "SELECT id_enfrentamiento, resultado, fecha, hora, set1, set2, set3, pareja1, pareja2, id_reserva, id_grupo 
                    FROM ENFRENTAMIENTO
                    WHERE id_grupo = '$id'
                    ORDER BY fecha DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;

        }


        function getDatosGrupo($grupo){

            $id_grupo = $grupo->getId();
    
            $sql = "SELECT numero, id_campeonato, sexonivel 
                    FROM GRUPO INNER JOIN (campeonato_categoria 
                                        INNER JOIN categoria 
                                                ON categoria.id_categoria = campeonato_categoria.id_categoria)
                                ON grupo.id_catcamp = campeonato_categoria.id_catcamp
                    WHERE id_grupo = '$id_grupo'";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }


        function comprobarGrupos($id){

            $sql = "SELECT id_grupo 
                    FROM grupo INNER JOIN 
                            (campeonato_categoria INNER JOIN campeonato 
                            ON campeonato_categoria.ID_CAMPEONATO = campeonato.ID_CAMPEONATO) 
                    ON grupo.ID_CATCAMP = campeonato_categoria.ID_CATCAMP 
                    WHERE campeonato.ID_CAMPEONATO = '$id'";
    
            if (!$result = $this->mysqli->query($sql))
            return 'No se ha podido conectar con la base de datos'; 
    
            if ($result->num_rows == 0){
                return false;
            } 
            else{
                return true;
            }
        }
        

    }

?>