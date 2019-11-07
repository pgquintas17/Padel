<?php

    require_once('Views/baseView.php');
    require_once('Models/partidoModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/reservaModel.php');
    require_once('Mappers/reservaMapper.php');

    class PartidoDetailsView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $datos;

        function __construct($msg=null, $errs=null, $usuario=null, $datos=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->datos = $datos;
        }

        function _render() { 
            ?>

            <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
            <?php (new MSGView($this->msg, $this->errs))->render(); ?>
            <!-- ///////////////////////////////////////////// -->
            
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
            <br><br>
            <div class="row justify-content-around">
                <a class="bg-ligth text-dark" href="/index.php?controller=adminPartidos"><i class="fas fa-arrow-circle-left fa-2x"></i></a><br>
            </div>  
                <div class="row justify-content-md-center">
                    <div class="col-md-auto"> 

                        <!-- Tabla datos usuario -->
                        <table class="table table-hover table-bordered" style="border-radius: 25px;">
                            <tr>
                            <th class="bg-dark text-white">Fecha</th>
                                <td class="table-light"><?php echo date('d-m-Y',strtotime($this->datos['2'])); ?></td>
                            </tr>
                            <tr>    
                                <th class="bg-dark text-white">Hora</th>
                                <td class="table-light"><?php echo date('H:i',strtotime($this->datos['1'])); ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Participantes</th>
                                <td class="table-light">
                                    <?php 
                                        if($this->datos['4'] != NULL){
                                            echo $this->datos['4'];
                                        ?>
                                            <br>
                                        <?php
                                        }
                                        if($this->datos['5'] != NULL){
                                            echo $this->datos['5'];
                                        ?>
                                            <br>
                                        <?php
                                        }
                                        if($this->datos['6'] != NULL){
                                            echo $this->datos['6'];
                                        ?>
                                            <br>
                                        <?php
                                        }
                                        if($this->datos['7'] != NULL){
                                            echo $this->datos['7'];
                                        ?>
                                            <br>
                                        <?php
                                        }
                                         
                                    ?>
                                </td>
                            </tr>
                            <tr>    
                                <th class="bg-dark text-white">Pista reservada</th>
                                <td class="table-light"><?php 
                                $reserva = new ReservaModel();
                                $reserva->setId($this->datos['8']);
                                $reservaMapper = new ReservaMapper();
                                $idpista = $reservaMapper->getPistaById($reserva);
                                
                                echo $idpista['0']; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        <?php
        }
    }
    
?>