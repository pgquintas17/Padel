<?php

require_once('Views/baseView.php');
require_once('Views/mensajeView.php');
require_once('Models/parejaModel.php');
require_once('Mappers/parejaMapper.php');
require_once('Services/Utils.php');

class GrupoDetailsView extends baseView {

    private $usuario;
    private $msg;
    private $errs;
    private $enfrentamientos;
    private $parejas;

    function __construct($msg=null, $errs=null, $usuario=null, $filaE=null, $enfrentamientos=null, $filaP=null, $parejas=null) {
        $this->msg = $msg;
        $this->errs = $errs;
        parent::__construct($this->usuario);
        $this->filaE = array('id_enfrentamiento','resultado','fecha','hora','set1','set2','set3','pareja1','pareja2','id_reserva','id_grupo');
        $this->enfrentamientos = $enfrentamientos;
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
            <h1>Grupo: </h1><br>
            <!-- Example row of columns -->
            <div class="row">

                <!--PAREJAS-->
                <div id="seccion" class="col-lg-4">
                    <h5>Parejas inscritas</h5>
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

                <!--ENFRENTAMIENTOS-->
                <div id="tablas" class="col">
                    <table class="table table-hover table-bordered" style="border-radius: 25px;">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Pareja 1</th>
                            <th scope="col">Pareja 2</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Resultado</th>
                            <?php
                                if(Utils::nivelPermiso(2)){
                            ?>
                                <th scope="col"></th>
                            <?php
                                }
                            ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while($this->filaE = ($this->enfrentamientos)->fetch_assoc()) {
                            $id = $this->filaE['id_enfrentamiento'];
                            $url = '#url para entrar en detalles y ver sets, hora, pista, etc.'          
                        ?>
                            <tr class='table-light clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                                <td><?php $pareja = new ParejaModel(); $pareja->setId($this->filaE['pareja1']); $parejaMapper = new ParejaMapper(); echo $parejaMapper->getNombreById($pareja); ?></td>
                                <td><?php $pareja = new ParejaModel(); $pareja->setId($this->filaE['pareja2']); $parejaMapper = new ParejaMapper(); echo $parejaMapper->getNombreById($pareja); ?></td>
                                <td><?php if($this->filaE['fecha'] != null){echo $this->filaE['fecha'];} else{ echo "Pendiente de acordar";} ?></td>
                                <td><?php if($this->filaE['resultado'] != null){echo $this->filaE['resultado'];} else{ echo "Pendiente de jugar";} ?></td>
                        <?php
                            if(Utils::nivelPermiso(2)){
                        ?>
                                <td>Gestionar resultado</td>
                        <?php
                            }
                        ?>
                            </tr>
                        
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>

                    
                </div>
            </div>
        </div>
        <?php
    }
}
?>