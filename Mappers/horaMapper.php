<?php

require_once('Models/horaModel.php');

    class HoraMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function mostrarTodos() {
		
            $sql = "SELECT id, hora FROM HORAS";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return null;
            else
                return $resultado;
        }



    }

?>