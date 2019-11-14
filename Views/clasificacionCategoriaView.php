<?php

require_once('Views/baseView.php');
require_once('Views/mensajeView.php');
require_once('Models/parejaModel.php');
require_once('Mappers/parejaMapper.php');
require_once('Services/Utils.php');

class ClasificacionCategoriaView extends baseView {

    private $usuario;
    private $msg;
    private $errs;
    private $parejas;

    function __construct($msg=null, $errs=null, $usuario=null, $filaP=null, $parejas=null) {
        $this->msg = $msg;
        $this->errs = $errs;
        parent::__construct($this->usuario);
        $this->filaP = array('id_pareja','nombre_pareja','capitan','miembro','fecha_inscrip','id_grupo','id_catcamp','puntos');
        $this->parejas = $parejas;
    }

    function _render() { 
        ?>
        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->
         
         
        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Parejas: </h1><br>
            <!-- Example row of columns -->
            <div class="row justify-content-md-center">

                <!--PAREJAS-->
                <div id="seccion" class="col-lg-4">
                    <p id="justificar">
                    <?php
                    while($this->filaP = ($this->parejas)->fetch_assoc()) {

                        if($_SESSION['Usuario']->getLogin() == $this->filaP['capitan'] || $_SESSION['Usuario']->getLogin() == $this->filaP['miembro']){
                        ?>
                            <li class="list-group-item bg-info">
                                <strong><?php echo $this->filaP['nombre_pareja']; ?></strong><br>
                                <p style="text-align:left";>-Capitán: <?php echo $this->filaP['capitan']; ?><br>
                                -Miembro: <?php echo $this->filaP['miembro']; ?></p>
                                <p style="text-align:left";><strong>Puntos: <?php echo $this->filaP['puntos']; ?></strong></p>
                            </li>
                        <?php
                        }
                        else{
                        ?>
                            <li class="list-group-item">
                                <strong><?php echo $this->filaP['nombre_pareja']; ?></strong><br>
                                <p style="text-align:left";>-Capitán: <?php echo $this->filaP['capitan']; ?><br>
                                -Miembro: <?php echo $this->filaP['miembro']; ?></p>
                                <p style="text-align:left";><strong>Puntos: <?php echo $this->filaP['puntos']; ?></strong></p>
                            </li>
                        <?php
                        }       
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
}
?>