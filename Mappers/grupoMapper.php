<?php

require_once('Models/horaModel.php');

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
        

    }

?>