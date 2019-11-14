<?php

    class EnfrentamientoMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($enfrentamiento){

            $fecha = $enfrentamiento->getFecha();
            $hora = $enfrentamiento->getHora();
            $pareja1 = $enfrentamiento->getPareja1();
            $pareja2 = $enfrentamiento->getPareja2();
            $id_reserva = $enfrentamiento->getIdReserva();
            $id_grupo = $enfrentamiento->getIdGrupo();

            $sql = "INSERT INTO ENFRENTAMIENTO (fecha, hora, pareja1, pareja2, id_reserva, id_grupo)
                    VALUES ('$fecha', '$hora', '$pareja1', '$pareja2', '$id_reserva', $id_grupo)";
    
            if (!$this->mysqli->query($sql)) 
                return 'Error en la inserción';
            else 
                return 'Inserción realizada con éxito';   
        } 
    
    
        function mostrarTodos() {
            
            $sql = "SELECT id_enfrentamiento, resultado, fecha, hora, set1, set2, set3, pareja1, pareja2, id_reserva, id_grupo 
                    FROM ENFRENTAMIENTO";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }
    
    
        function consultarDatos($enfrentamiento) {	

            $id = $enfrentamiento->getId();
    
            $sql = "SELECT * FROM ENFRENTAMIENTO WHERE (id_enfrentamiento = '$id')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }
        

    }

?>