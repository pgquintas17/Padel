<?php

require_once('Models/horaModel.php');

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
                return 'Inserción realizada con éxito';  
    
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
            
            $sql = "SELECT * FROM  CAMPEONATO_CATEGORIA  WHERE  (id_catcamp = '$id_catcamp') ";
            
            if (!$result = $this->mysqli->query($sql))
                return 'No se ha podido conectar con la base de datos'; 
        
            if ($result->num_rows == 1){
                
                $sql = "DELETE FROM  CAMPEONATO_CATEGORIA  WHERE (id_camtcamp = '$id_catcamp')";
                $this->mysqli->query($sql);
                
                return "Borrado correctamente";
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

                return 'Pareja añadida';
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

                $sql2 = "SELECT * FROM CATEGORIA WHERE id_categoria = '$id_cat'";
            
                $resultado = $this->mysqli->query($sql2);
                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                
                return $tupla['1'];
            }
        }

    }

?>