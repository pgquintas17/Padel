<?php

    class EnfrentamientoMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($enfrentamiento){

            $pareja1 = $enfrentamiento->getPareja1();
            $pareja2 = $enfrentamiento->getPareja2();
            $id_grupo = $enfrentamiento->getIdGrupo();

            $sql = "INSERT INTO ENFRENTAMIENTO (pareja1, pareja2, id_grupo)
                    VALUES ('$pareja1', '$pareja2', '$id_grupo')";
    
            if (!$this->mysqli->query($sql)) 
                return 'Error con la base de datos';
            else 
                return 'Inserción realizada con éxito';   
        } 
    
    
        function mostrarTodos() {
            
            $sql = "SELECT id_enfrentamiento, resultado, fecha, hora, set1, set2, set3, pareja1, pareja2, id_reserva, id_grupo, propuesta1, propuesta2 
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


        function addResultado($enfrentamiento){

            $id = $enfrentamiento->getId();
            $set1 = $enfrentamiento->getSet1();                   
            $set2 = $enfrentamiento->getSet2();                   
            $set3 = $enfrentamiento->getSet3();
            $resultado = $enfrentamiento->getResultado(); 
            
            
            $sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$id')";
            $result = $this->mysqli->query($sql);
        
            if ($result->num_rows == 1) {	
    
                $sql = "UPDATE ENFRENTAMIENTO  SET
                            resultado = '$resultado',
                            set1 = '$set1',
                            set2 = '$set2',
                            set3 = '$set3'
    
                        WHERE ( id_enfrentamiento = '$id')";
    
                if (!($resultado = $this->mysqli->query($sql)))
                    return 'Error en la modificación';
                else
                    return 'Resultado añadido correctamente.';
            }
            else 
                return 'No existe en la base de datos';
        }


        function comprobarDisponibilidadUsuario($reserva){

            $hora = $reserva->getHora();
            $fecha = $reserva->getFecha();
            $login = $reserva->getLogin();   

            $sql2 = "SELECT * FROM  ENFRENTAMIENTO 
                        INNER JOIN PAREJA pareja1 on pareja1.ID_PAREJA = enfrentamiento.PAREJA1 
                        INNER JOIN PAREJA pareja2 on pareja2.ID_PAREJA = enfrentamiento.PAREJA1
                    WHERE (hora = '$hora' AND fecha = '$fecha' 
                        AND (pareja1.capitan = '$login' OR pareja2.capitan = '$login' 
                            OR pareja1.miembro = '$login' OR pareja2.miembro = '$login'))";

            if (!($resultado = $this->mysqli->query($sql2))){
                return false;
            }
            else{
                if ($resultado->num_rows == 0) {
                    return true;
                }
                else{
                    return false;
                }
            }
        }


        function getDatosEnfrentamiento($enfrentamiento){

            $id = $enfrentamiento->getId();

            $sql = "SELECT id_enfrentamiento, propuesta1, propuesta2, pareja1, pareja2, campeonato.nombre, categoria.sexonivel, grupo.numero
                    FROM enfrentamiento
                        INNER JOIN (grupo 
                                INNER JOIN (campeonato_categoria 
                                        INNER JOIN categoria ON categoria.id_categoria = campeonato_categoria.id_categoria INNER JOIN campeonato ON campeonato.id_campeonato = campeonato_categoria.id_campeonato ) 
                                ON campeonato_categoria.id_catcamp = grupo.id_catcamp) 
                        ON enfrentamiento.id_grupo = grupo.id_grupo
                    WHERE id_enfrentamiento = '$id'";

            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }


        function addPropuesta1($enfrentamiento){

            $id = $enfrentamiento->getId();
            $propuesta = $enfrentamiento->getPropuesta1(); 
            
            
            $sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$id')";
            $result = $this->mysqli->query($sql);
        
            if ($result->num_rows == 1) {	
    
                $sql = "UPDATE ENFRENTAMIENTO  SET propuesta1 = '$propuesta'
                        WHERE ( id_enfrentamiento = '$id')";
    
                if (!($resultado = $this->mysqli->query($sql)))
                    return 'Error en la modificación';
                else
                    return 'Propuesta añadida correctamente.';
            }
            else 
                return 'No existe en la base de datos';
        }


        function addPropuesta2($enfrentamiento){

            $id = $enfrentamiento->getId();
            $propuesta = $enfrentamiento->getPropuesta2(); 
            
            
            $sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$id')";
            $result = $this->mysqli->query($sql);
        
            if ($result->num_rows == 1) {	
    
                $sql = "UPDATE ENFRENTAMIENTO  SET propuesta2 = '$propuesta'
                        WHERE ( id_enfrentamiento = '$id')";
    
                if (!($resultado = $this->mysqli->query($sql)))
                    return 'Error en la modificación';
                else
                    return 'Propuesta añadida correctamente.';
            }
            else 
                return 'No existe en la base de datos';
        }


        function getNumParejaCapi($enfrentamiento,$pareja){

            $id = $enfrentamiento->getId();
            $idpareja = $pareja->getId();
            $capi = $pareja->getCapitan();

            $sql= "SELECT * 
                   FROM enfrentamiento
                        INNER JOIN pareja ON pareja.id_pareja = enfrentamiento.pareja1 
                   WHERE id_enfrentamiento = '$id' AND pareja1 = '$idpareja' AND capitan = '$capi'";

            $resultado = $this->mysqli->query($sql);

            var_dump($sql);

            if ($resultado->num_rows != 0){
                return 1;
            }
            else{
                return 2;
            }
        }
        

    }

?>