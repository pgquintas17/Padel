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

        function comprobarDisponibilidadPropuestaUsuario($reserva){

            $hora = $reserva->getHora();
            $fecha = $reserva->getFecha();
            $propuesta = $fecha . ' ' . $hora;
            $login = $reserva->getLogin();   

            $sql = "SELECT * FROM  ENFRENTAMIENTO 
                        INNER JOIN PAREJA pareja1 on pareja1.ID_PAREJA = enfrentamiento.PAREJA1 
                    WHERE (propuesta1 = '$propuesta' 
                        AND (pareja1.capitan = '$login' OR pareja1.miembro = '$login'))";

            if (!($resultado = $this->mysqli->query($sql))){
                return false;
            }
            else{
                if ($resultado->num_rows == 0) {
                    
                    $sql2 = "SELECT * FROM  ENFRENTAMIENTO 
                                INNER JOIN PAREJA pareja2 on pareja2.ID_PAREJA = enfrentamiento.PAREJA2 
                            WHERE (propuesta2 = '$propuesta' 
                                AND (pareja2.capitan = '$login' OR pareja2.miembro = '$login'))";
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
                else{
                    return false;
                }
            }
        }


        function getDatosEnfrentamiento($enfrentamiento){

            $id = $enfrentamiento->getId();

            $sql = "SELECT id_enfrentamiento, propuesta1, propuesta2, pareja1, pareja2, campeonato.nombre, categoria.sexonivel, grupo.numero, grupo.id_grupo
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


        function getFechaFinCampeonato($enfrentamiento){

            $id = $enfrentamiento->getId();

            $sql = "SELECT campeonato.fecha_fin
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
                return $result['0'];
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


        function borrarPropuesta1($enfrentamiento){

            $id = $enfrentamiento->getId();
            $propuesta = $enfrentamiento->getPropuesta1(); 
            
            
            $sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$id')";
            $result = $this->mysqli->query($sql);
        
            if ($result->num_rows == 1) {	
    
                $sql = "UPDATE ENFRENTAMIENTO  SET propuesta1 = NULL
                        WHERE ( id_enfrentamiento = '$id')";
    
                if (!($resultado = $this->mysqli->query($sql)))
                    return 'Error en la modificación';
                else
                    return 'Propuesta añadida correctamente.';
            }
            else 
                return 'No existe en la base de datos';
        }


        function borrarPropuesta2($enfrentamiento){

            $id = $enfrentamiento->getId();
            $propuesta = $enfrentamiento->getPropuesta2(); 
            
            
            $sql = "SELECT * FROM ENFRENTAMIENTO  WHERE (id_enfrentamiento = '$id')";
            $result = $this->mysqli->query($sql);
        
            if ($result->num_rows == 1) {	
    
                $sql = "UPDATE ENFRENTAMIENTO  SET propuesta2 = NULL
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

            if ($resultado->num_rows != 0){
                return 1;
            }
            else{
                return 2;
            }
        }


        function getNumPareja($enfrentamiento,$pareja){

            $id = $enfrentamiento->getId();
            $capi = $pareja->getCapitan();

            $sql= "SELECT pareja1, pareja2 
                   FROM enfrentamiento 
                   WHERE id_enfrentamiento = '$id'";

            $resultado = $this->mysqli->query($sql);
            $tupla = $resultado->fetch_array(MYSQLI_NUM);

            $pareja1 = $tupla['0'];
            $pareja2 = $tupla['1'];

            $sql2 = "SELECT *
                     FROM pareja
                     WHERE capitan = '$capi' AND id_pareja = '$pareja1'";

            $resultado = $this->mysqli->query($sql2);

            if ($resultado->num_rows != 0){
                return 1;
            }

            $sql2 = "SELECT *
                     FROM pareja
                     WHERE capitan = '$capi' AND id_pareja = '$pareja2'";

            $resultado = $this->mysqli->query($sql2);
            
            if ($resultado->num_rows != 0){
                return 2;
            }
        }


        function getParejasById($enfrentamiento){

            $id = $enfrentamiento->getId();
    
            $sql = "SELECT pareja1, pareja2 FROM ENFRENTAMIENTO WHERE (id_enfrentamiento = '$id')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }


        function añadirReserva($enfrentamiento){

            $id_reserva = $enfrentamiento->getIdReserva();
            $id_enfrentamiento = $enfrentamiento->getId();

            $sql = "UPDATE ENFRENTAMIENTO  SET id_reserva = '$id_reserva' 
                    WHERE ( id_enfrentamiento = '$id_enfrentamiento' )";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la modificación';
            }      
            else{
                return true;
            }      
        }


        function añadirFechaHora($enfrentamiento){

            $fecha = $enfrentamiento->getFecha();
            $hora = $enfrentamiento->getHora();
            $id_enfrentamiento = $enfrentamiento->getId();

            $sql = "UPDATE ENFRENTAMIENTO  SET fecha = '$fecha', hora = '$hora' 
                    WHERE ( id_enfrentamiento = '$id_enfrentamiento' )";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la modificación';
            }      
            else{
                return true;
            }      
        }


        function getEmails($enfrentamiento){

            $id = $enfrentamiento->getId();

            $sql= "SELECT usuario1.email as email1, usuario2.email as email2, usuario3.email as email3, usuario4.email as email4
                   FROM enfrentamiento
                        INNER JOIN (pareja pareja1 
                                INNER JOIN usuario usuario1 ON usuario1.login = pareja1.capitan
                                INNER JOIN usuario usuario2 ON usuario2.login = pareja1.miembro) 
                        ON pareja1.id_pareja = enfrentamiento.pareja1

                        INNER JOIN (pareja pareja2 
                                INNER JOIN usuario usuario3 ON usuario3.login = pareja2.capitan
                                INNER JOIN usuario usuario4 ON usuario4.login = pareja2.miembro) 
                        ON pareja2.id_pareja = enfrentamiento.pareja2
                   WHERE id_enfrentamiento = '$id'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            }
            else{

                $tupla = $resultado->fetch_array(MYSQLI_NUM);
                $emails = array();
                $emails[] = $tupla['0'];
                $emails[] = $tupla['1'];
                $emails[] = $tupla['2'];
                $emails[] = $tupla['3'];

                return $emails;
            }


        }

    }

?>