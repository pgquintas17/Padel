<?php

require_once('Views/baseView.php');
require_once('Views/mensajeView.php');
require_once('Models/parejaModel.php');
require_once('Mappers/parejaMapper.php');
require_once('Mappers/usuarioMapper.php');
require_once('Services/Utils.php');

class GrupoDetailsView extends baseView {

    private $usuario;
    private $msg;
    private $errs;
    private $enfrentamientos;
    private $parejas;
    private $datos;

    function __construct($msg=null, $errs=null, $usuario=null, $filaE=null, $enfrentamientos=null, $filaP=null, $parejas=null, $datos=null) {
        $this->msg = $msg;
        $this->errs = $errs;
        parent::__construct($this->usuario);
        $this->filaE = array('id_enfrentamiento','resultado','fecha','hora','set1','set2','set3','pareja1','pareja2','id_reserva','id_grupo','propuesta1','propuesta2');
        $this->enfrentamientos = $enfrentamientos;
        $this->filaP = array('id_pareja','nombre_pareja','capitan','miembro','fecha_inscrip','id_grupo','id_catcamp','puntos');
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
            <h1> <?php echo $this->datos['4']; ?></h1>
            <h1>Grupo <?php echo $this->datos['0']; ?>, <?php 
                                if($this->datos['2'] == 'M1'){
                                    echo "1ª masculina";
                                }
                                    
                                if($this->datos['2'] == 'M2'){
                                    echo "2ª masculina";
                                }
                                
                                if($this->datos['2'] == 'M3'){
                                    echo "3ª masculina";
                                }
                                
                                if($this->datos['2'] == 'F1'){
                                    echo "1ª femenina";
                                }
                                    
                                if($this->datos['2'] == 'F2'){
                                    echo "2ª femenina";
                                }
                                
                                if($this->datos['2'] == 'F3'){
                                    echo "3ª femenina";
                                }

                                if($this->datos['2'] == 'MX1'){
                                    echo "1ª mixta";
                                }
                                    
                                if($this->datos['2'] == 'MX2'){
                                    echo "2ª mixta";
                                }
                                
                                if($this->datos['2'] == 'MX3'){
                                    echo "3ª mixta";
                                }
                                ?>:</h1>

            <div class="row">
                <div class="col-2" style="align-self: center;"><p>
                    <?php
                    if(Utils::nivelPermiso(2)){
                    ?>
                        <a class="bg-ligth text-dark" href='/index.php?controller=adminCampeonatos&action=DETAILS&idcampeonato=<?php echo $this->datos['1']; ?>'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </p></div>
                    <?php
                    }
                    else{
                    ?>
                        <a class="bg-ligth text-dark" href='/index.php?controller=campeonatos&action=DETAILS&idcampeonato=<?php echo $this->datos['1']; ?>'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </p></div>
                    <?php
                    }
                    ?>
            </div>
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
                            <li class="list-group-item" style="background-color: #99ebff";>
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
                <h5>Enfrentamientos</h5>
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
                            if(Utils::nivelPermiso(2)){
                                $url = '/index.php?controller=adminGrupos&action=DETAILS&idenfrentamiento=' .$id;
                            }
                            else{
                                $url = '/index.php?controller=campeonatos&action=enfDETAILS&idenfrentamiento=' .$id;
                            }
                                      
                        ?>
                            <tr class='table-light clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                                <td><?php $pareja1 = new ParejaModel(); $pareja1->setId($this->filaE['pareja1']); $parejaMapper1 = new ParejaMapper(); echo $parejaMapper1->getNombreById($pareja1); ?></td>
                                <td><?php $pareja2 = new ParejaModel(); $pareja2->setId($this->filaE['pareja2']); $parejaMapper2 = new ParejaMapper(); echo $parejaMapper2->getNombreById($pareja2); ?></td>
                                <td><?php 
                                            if($this->filaE['fecha'] != null){
                                                echo $this->filaE['fecha'];
                                            } 
                                            else{ 
                                                $hoy = date('Y-m-d');
                                                $usuarioM = new UsuarioMapper(); 
                                                $capi = $usuarioM->capitanPareja($_SESSION['Usuario'],$pareja1,$pareja2);
                                                if($capi && $this->datos['3'] > $hoy){
                                    ?>
                                                    <a class="btn btn-dark" href='/index.php?controller=enfrentamientos&idenfrentamiento=<?php echo $this->filaE['id_enfrentamiento'];?>' role="button">Proponer fecha</a>
                                    <?php
                                                } 
                                                else{
                                                    echo "Pendiente de acordar";
                                                }
                                            } 
                                    ?>
                                </td>
                                <td><?php if($this->filaE['resultado'] != null){echo $this->filaE['resultado'];} else{ echo "Pendiente de jugar";} ?></td>
                        <?php
                            $hoy = date('Y-m-d');
                            if(Utils::nivelPermiso(2)){
                                if($this->filaE['id_reserva'] != null && $this->filaE['fecha'] < $hoy && $this->datos['3'] > $hoy){
                        ?>
                                    <td><a class="bg-ligth text-dark" href='/index.php?controller=adminGrupos&action=addResultado&idenfrentamiento=<?php echo $this->filaE['id_enfrentamiento']; ?>'><i class="fas fa-trophy"></i></a></td>
                        <?php
                                } else{
                                    ?>
                                    <td></td>
                                    <?php
                                }
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