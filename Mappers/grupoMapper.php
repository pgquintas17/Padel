<?php

    require_once('Mappers/CampeonatoCategoriaMapper.php');
    require_once('Models/GrupoModel.php');
    require_once('Models/ParejaModel.php');
    require_once('Mappers/ParejaMapper.php');
    require_once('Models/EnfrentamientoModel.php');
    require_once('Mappers/EnfrentamientoMapper.php');

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


        function getGrupos($categoria){

            $id = $categoria->getId();

            $sql = "SELECT id_grupo, id_catcamp, numero, n_parejas FROM grupo WHERE id_catcamp = '$id'";

            if (!($resultado = $this->mysqli->query($sql))){
                return 'Error en la consulta sobre la base de datos';
            } else{
                $grupos = array();
                $fila = array('id_grupo', 'id_catcamp', 'numero', 'n_parejas');

                while($fila = ($resultado)->fetch_assoc()){

                        $grupo = new GrupoModel($fila['id_grupo'], $fila['id_catcamp'], $fila['numero'], $fila['n_parejas']);
                        $grupos[] = $grupo;
                }

                    return $grupos;

            }
        }



        function generarGrupos($categoria){

            $id_categoria = $categoria->getId();
            $n_participantes = $categoria->getNumPlazas();

            if($n_participantes < 8){
                (new CampeonatoCategoriaMapper())->DELETE($categoria);
                echo "borrado";

            }else{

                $resto = 11;

                for ($i = 12; $i >= 8; $i--) {
                    $resto_aux = $n_participantes % $i;
                    
                    if($resto_aux == 0){
                        $n_grupos = $n_participantes / $i;
                        $nParejasGrupo = $i;
                    }else{
                        if ($resto_aux < $resto){
                            $resto = $resto_aux;
                            $n_grupos = round($n_participantes / $i, 0, PHP_ROUND_HALF_DOWN);
                            $nParejasGrupo = $i;
                        }
                    }  
                }

                for($i = 0; $i < $n_grupos; $i++){

                    $grupo = new GrupoModel();
                    $grupo->setIdCatCamp($id_categoria);
                    $grupo->setNumero($i+1);
                    $grupo->setNumParejas($nParejasGrupo);

                    (new GrupoMapper())->ADD($grupo);
                }

                $grupos = (new GrupoMapper())->getGrupos($categoria);

                foreach($grupos as $grupo){

                    $limit = $grupo->getNumParejas();
                    $id_grupo = $grupo->getId();

                    $sql = "UPDATE PAREJA 
                            SET id_grupo = '$id_grupo' 
                            WHERE id_catcamp = '$id_categoria'
                            ORDER BY fecha_inscrip 
                            LIMIT $limit";

                    $this->mysqli->query($sql);

                    $sql = "DELETE 
                        FROM PAREJA 
                        WHERE id_catcamp = '$id_categoria' 
                            AND id_grupo IS NULL";

                    $this->mysqli->query($sql);

                    $parejas = (new ParejaMapper())->getParejas($grupo);

                    $numParejas = $grupo->getNumParejas();

                    for($i = 0; $i < $numParejas-1; $i++){
                        for($j = $i + 1; $j < $numParejas; $j++){
                            if($i != $j){
                                $enfrentamiento = new EnfrentamientoModel();
                                $enfrentamiento->setPareja1($parejas[$i]->getId());
                                $enfrentamiento->setPareja2($parejas[$j]->getId());
                                $enfrentamiento->setIdGrupo($grupo->getId());

                                (new EnfrentamientoMapper())->ADD($enfrentamiento);
                            }
                        }
                    }
                }
            }
        }
        

    }

?>