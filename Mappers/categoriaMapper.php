<?php

require_once('Models/horaModel.php');

    class CategoriaMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function mostrarTodos() {
		
            $sql = "SELECT id_categoria, sexonivel FROM CATEGORIA";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }


    }

?>