<?php

require_once('Models/horaModel.php');
require_once('Models/campeonatoCategoriaModel.php');

    class CampeonatoCategoriaMapper{
        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($campeonatoCategoria){

            $id_campeonato = $campeonatoCategoria->getIdCampeonato();
            $id_categoria = $campeonatoCategoria->getIdCategoria();

            $sql = "INSERT INTO CAMPEONATO_CATEGORIA (id_campeonato,id_categoria,n_plazas)
                    VALUES ('$id_campeonato', '$id_categoria', 0 )";
    
            if (!$this->mysqli->query($sql))  
                return 'Error en la inserción de' .$id_categoria .' y ' .$id_campeonato;
            else
                return 'Categoría añadida correctamente';  
    
        }
        
    
        function mostrarTodos() {
            
            $sql = "SELECT id_catcamp, id_campeonato, id_categoria, n_plazas 
                    FROM CAMPEONATO_CATEGORIA";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }
    
        
        function DELETE($campeonatoCategoria) {	

            $id_catcamp = $campeonatoCategoria->getId();
            
            $sql = "SELECT * FROM  CAMPEONATO_CATEGORIA  WHERE (id_catcamp = '$id_catcamp') ";
            
            if (!$result = $this->mysqli->query($sql))
                return 'No se ha podido conectar con la base de datos'; 
        
            if ($result->num_rows == 1){
                
                $sql = "DELETE FROM  CAMPEONATO_CATEGORIA  WHERE (id_catcamp = '$id_catcamp')";
                $this->mysqli->query($sql);
                
                return "Categoría borrada correctamente";
            } 
            else
                return "No existe";
        } 
        
        
        function consultarDatos($campeonatoCategoria) {	

            $id_catcamp = $campeonatoCategoria->getId();
    
            $sql = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE (id_catcamp = '$id_catcamp')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }

        
        function getNumParejas($campeonatoCategoria){

            $id_catcamp = $campeonatoCategoria->getId();
            
            $sql = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE ((id_catcamp = '$id_catcamp'))";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                return 'La categoría no existe';
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                return $tupla['3'];
            }
        }


        function addParejas($campeonatoCategoria){

            $id_catcamp = $campeonatoCategoria->getId();
            
            $sql = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE (id_catcamp = '$id_catcamp')";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                return 'La categoría no existe';
            else{
                $sql = "UPDATE CAMPEONATO_CATEGORIA 
                        SET n_plazas = n_plazas + 1  
                        WHERE (id_catcamp = '$id_catcamp')";

                if (!($resultado = $this->mysqli->query($sql)))
                    return 'No existe en la base de datos'; 
                else{
                return 'Pareja añadida';
                }
            }
        }


        function getSexonivelById($catcamp){

            $id = $catcamp->getId();

            $sql = "SELECT * FROM CAMPEONATO_CATEGORIA WHERE id_catcamp = '$id'";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                return 'La categoría no existe';
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                $id_cat = $tupla['2'];

                $sql = "SELECT sexonivel FROM CATEGORIA WHERE id_categoria = '$id_cat'";
            
                $resultado = $this->mysqli->query($sql);
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                
                return $tupla['0'];
            }
        }


        function getGruposByCatCamp($catcamp){

            $id = $catcamp->getId();

            $sql = "SELECT id_grupo, id_catcamp, numero, n_parejas 
                    FROM GRUPO 
                    WHERE id_catcamp = '$id'";

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

        
        function getParejasByCategoria($catcamp){

            $id = $catcamp->getId();

            $sql = "SELECT id_pareja, nombre_pareja, capitan, miembro, fecha_inscrip, id_grupo, id_catcamp, puntos 
                    FROM PAREJA
                    WHERE id_catcamp = '$id'
                    ORDER BY puntos DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;

        }

        function getCampeonatoByCategoria($catcamp){

            $id = $catcamp->getId();

            $sql = "SELECT id_campeonato FROM CAMPEONATO_CATEGORIA WHERE id_catcamp = '$id'";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                return 'La categoría no existe';
            else{
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                
                return $tupla['0'];
            }

        }

        function getDatosCampeonatoYCategoria($catcamp){

            $id = $catcamp->getId();

            $sql = "SELECT id_campeonato, sexonivel 
                    FROM CAMPEONATO_CATEGORIA 
                    INNER JOIN categoria 
                                ON categoria.id_categoria=campeonato_categoria.id_categoria 
                    WHERE id_catcamp = '$id'";
            
            $resultado = $this->mysqli->query($sql);
            
            if ($resultado->num_rows == 0)
                return 'La categoría no existe';
            else{
                return $resultado->fetch_array(MYSQLI_NUM);
            }
        }


        function getCategorias($campeonato){

            $id = $campeonato->getId();

            $sql = "SELECT id_catcamp, id_campeonato, id_categoria, n_plazas FROM campeonato_categoria WHERE ID_CAMPEONATO = '$id'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            } else{
                $categorias = array();
                $fila = array('id_catcamp', 'id_campeonato', 'id_categoria', 'n_plazas');

                while($fila = ($resultado)->fetch_assoc()){

                        $categoria = new CampeonatoCategoriaModel($fila['id_catcamp'], $fila['id_campeonato'], $fila['id_categoria'], $fila['n_plazas']);
                        $categorias[] = $categoria;
                }

                    return $categorias;

            }
        }

    }

?>