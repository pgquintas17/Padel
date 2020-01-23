<?php

require_once('Models/noticiaModel.php');

    class NoticiaMapper{

        var $bd;

        function __construct(){
            include_once 'Models/BdAdmin.php'; 
		    $this->mysqli = ConectarBD();
        }


        function ADD($noticia){

            $titulo = $noticia->getTitulo();
            $cuerpo = $noticia->getCuerpo();
            $fecha_creacion = $noticia->getFechaCreacion();
    
            $sql = "SELECT * FROM NOTICIA";

            if (!$result = $this->mysqli->query($sql)) 
                return 'No se ha podido conectar con la base de datos'; 
            else { 
                
                $sql = "INSERT INTO NOTICIA (
                        titulo,
                        cuerpo,
                        fecha_creacion
                    )
                    VALUES (
                        '$titulo',
                        '$cuerpo',
                        '$fecha_creacion'
                    )";

                if (!$this->mysqli->query($sql)){
                    return $sql;
                } 
                else {
                    return 'Noticia añadida con éxito al sistema.';
                } 
            }

        }


        function EDIT($noticia) {

            $id = $noticia->getId();
            $titulo = $noticia->getTitulo();
            $cuerpo = $noticia->getCuerpo();
            
	
            $sql = "SELECT * FROM NOTICIA  WHERE (id_noticia = '$id')";
            $result = $this->mysqli->query($sql);
        
            if ($result->num_rows == 1) {	
    
                $sql = "UPDATE NOTICIA  SET
                            titulo = '$titulo',
                            cuerpo = '$cuerpo'
    
                        WHERE ( id_noticia = '$id')";
    
                if (!($resultado = $this->mysqli->query($sql)))
                    return 'Error en la modificación';
                else
                    return 'Noticia modificada correctamente';
            }
            else 
                return 'No existe en la base de datos';
        }


        function DELETE($noticia) {	

            $id_noticia = $noticia->getId();
		
            $sql = "SELECT * FROM NOTICIA  WHERE (id_noticia = '$id_noticia') ";    
            $result = $this->mysqli->query($sql);
    
            if (!$result)
                return 'No se ha podido conectar con la base de datos';
                
            if ($result->num_rows == 1) {
                    
                $sql = "DELETE FROM  NOTICIA WHERE (id_noticia = '$id_noticia')";   
                $this->mysqli->query($sql);
                
                return "Noticia eliminada";
            } 
            else
                return "No existe";
        }


        function mostrarTodos() {
		
            $sql = "SELECT 
                        id_noticia,
                        titulo,
                        cuerpo,
                        fecha_creacion

                    FROM NOTICIA
                    ORDER BY fecha_creacion DESC";
    
            if (!($resultado = $this->mysqli->query($sql)))
                return 'Error en la consulta sobre la base de datos';
            else
                return $resultado;
        }


        function consultarDatos($noticia) {	

            $id_noticia = $noticia->getId();

            $sql = "SELECT * FROM NOTICIA WHERE (id_noticia = '$id_noticia')";
                
            if (!($resultado = $this->mysqli->query($sql)))
                return 'No existe en la base de datos'; 
            else{ 
                $result = $resultado->fetch_array(MYSQLI_NUM);
                return $result;
            }
        }


        function getNoticiasRecientes($fecha) {

            $sql = "SELECT id_noticia,
                           titulo,
                           fecha_creacion
                             
                    FROM NOTICIA 
                    ORDER BY fecha_creacion
                    LIMIT 10";
    
            if (!($resultado = $this->mysqli->query($sql))){
                return null;
            }else{
                if($resultado->num_rows == 0){
                    return null;
                }
                else{
                    return $resultado;
                }
            }
        }
    }

?>