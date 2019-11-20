<?php

require_once('Views/baseView.php');
require_once('Views/mensajeView.php');
require_once('Models/parejaModel.php');
require_once('Mappers/parejaMapper.php');
require_once('Services/Utils.php');

class ClasificacionCampeonatoView extends baseView {

    private $usuario;
    private $msg;
    private $errs;
    private $parejas;
    private $datos;

    function __construct($msg=null, $errs=null, $usuario=null, $filaP=null, $parejas=null, $datos=null) {
        $this->msg = $msg;
        $this->errs = $errs;
        parent::__construct($this->usuario);
        $this->filaP = array('id_pareja', 'nombre_pareja', 'capitan', 'miembro', 'fecha_inscrip', 'id_grupo', 'pareja.id_catcamp', 'puntos', 'sexonivel');
        $this->parejas = $parejas;
        $this->datos = $datos;
    }

    function _render() { 
        ?>
        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->
         
         
        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Parejas en <?php echo $this->datos['1']; ?>: </h1><br>

            <div class="row">
                <div class="col-2" style="align-self: center;">
                    <?php
                    if(Utils::nivelPermiso(2)){
                    ?>
                        <a class="bg-ligth text-dark" href='/index.php?controller=adminCampeonatos'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </div>
                    <?php
                    }
                    else{
                    ?>
                        <a class="bg-ligth text-dark" href='/index.php?controller=campeonatos'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </div>
                    <?php
                    }
                    ?>
            </div>
            
            <!-- Example row of columns -->
            <div class="row justify-content-md-center">

                <!--PAREJAS-->
                <div id="seccion" class="col-lg-4">
                    <p id="justificar">
                    <?php
                    if(($this->parejas)->num_rows != 0){
                    while($this->filaP = ($this->parejas)->fetch_assoc()) {

                        if($_SESSION['Usuario']->getLogin() == $this->filaP['capitan'] || $_SESSION['Usuario']->getLogin() == $this->filaP['miembro']){
                        ?>
                            <li class="list-group-item" style="background-color: #99ebff";>
                                <strong><?php echo $this->filaP['nombre_pareja']; ?></strong><br>
                                <p style="text-align:left";>Categoría: <?php 
                                                                if($this->filaP['sexonivel'] == 'M1'){
                                                                    echo "1ª masculina";
                                                                }
                                                                    
                                                                if($this->filaP['sexonivel'] == 'M2'){
                                                                    echo "2ª masculina";
                                                                }
                                                                
                                                                if($this->filaP['sexonivel'] == 'M3'){
                                                                    echo "3ª masculina";
                                                                }
                                                                
                                                                if($this->filaP['sexonivel'] == 'F1'){
                                                                    echo "1ª femenina";
                                                                }
                                                                    
                                                                if($this->filaP['sexonivel'] == 'F2'){
                                                                    echo "2ª femenina";
                                                                }
                                                                
                                                                if($this->filaP['sexonivel'] == 'F3'){
                                                                    echo "3ª femenina";
                                                                }

                                                                if($this->filaP['sexonivel'] == 'MX1'){
                                                                    echo "1ª mixta";
                                                                }
                                                                    
                                                                if($this->filaP['sexonivel'] == 'MX2'){
                                                                    echo "2ª mixta";
                                                                }
                                                                
                                                                if($this->filaP['sexonivel'] == 'MX3'){
                                                                    echo "3ª mixta";
                                                                }
                                                                ?></p>
                            </li>
                        <?php
                        }
                        else{
                        ?>
                            <li class="list-group-item">
                                <strong><?php echo $this->filaP['nombre_pareja']; ?></strong><br>
                                <p style="text-align:left";>Categoría: <?php 
                                                                if($this->filaP['sexonivel'] == 'M1'){
                                                                    echo "1ª masculina";
                                                                }
                                                                    
                                                                if($this->filaP['sexonivel'] == 'M2'){
                                                                    echo "2ª masculina";
                                                                }
                                                                
                                                                if($this->filaP['sexonivel'] == 'M3'){
                                                                    echo "3ª masculina";
                                                                }
                                                                
                                                                if($this->filaP['sexonivel'] == 'F1'){
                                                                    echo "1ª femenina";
                                                                }
                                                                    
                                                                if($this->filaP['sexonivel'] == 'F2'){
                                                                    echo "2ª femenina";
                                                                }
                                                                
                                                                if($this->filaP['sexonivel'] == 'F3'){
                                                                    echo "3ª femenina";
                                                                }

                                                                if($this->filaP['sexonivel'] == 'MX1'){
                                                                    echo "1ª mixta";
                                                                }
                                                                    
                                                                if($this->filaP['sexonivel'] == 'MX2'){
                                                                    echo "2ª mixta";
                                                                }
                                                                
                                                                if($this->filaP['sexonivel'] == 'MX3'){
                                                                    echo "3ª mixta";
                                                                }
                                                                ?></p>
                            </li>
                        <?php
                        }       
                    }
                }
                else{
                    ?>
                        <h5>No hay parejas apuntadas en este campeonato.</h5>
                    <?php
                }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>