<?php

    require_once('Views/baseView.php');
    require_once('Models/partidoModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/parejaModel.php');
    require_once('Mappers/parejaMapper.php');
    require_once('Models/reservaModel.php');
    require_once('Mappers/reservaMapper.php');

    class EnfrentamientoDetailsView extends baseView {

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
            <?php
            if(Utils::nivelPermiso(2)){
                $url = "/index.php?controller=adminGrupos&idgrupo=".$this->datos['10'];
            }else{
                $url = "/index.php?controller=campeonatos&action=grupo&idgrupo=".$this->datos['10'];
            }
            ?>
                <a class="bg-ligth text-dark" href="<?php echo $url; ?>"><i class="fas fa-arrow-circle-left fa-2x"></i></a><br>
            </div>  
                <div class="row justify-content-md-center">
                    <div class="col-md-auto"> 

                        <!-- Tabla datos enfrentamiento -->
                        <table class="table table-hover table-bordered" style="border-radius: 25px;">
                            <tr>
                            <th class="bg-dark text-white">Resultado</th>
                                <td class="table-light"><?php if($this->datos['1'] != null){echo $this->datos['1'];}else{echo "Pendiente de jugarse";} ?></td>
                            </tr>
                            <tr>
                            <th class="bg-dark text-white">Fecha</th>
                                <td class="table-light"><?php echo date('d/m',strtotime($this->datos['2'])); ?></td>
                            </tr>
                            <tr>    
                                <th class="bg-dark text-white">Hora</th>
                                <td class="table-light"><?php echo date('H:i',strtotime($this->datos['3'])); ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Pareja 1</th>
                                <td class="table-light"><?php $pareja1 = new ParejaModel(); $pareja1->setId($this->datos['7']); $parejaMapper = new ParejaMapper(); echo $parejaMapper->getNombreById($pareja1); ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Pareja 2</th>
                                <td class="table-light"><?php $pareja2 = new ParejaModel(); $pareja2->setId($this->datos['8']); echo $parejaMapper->getNombreById($pareja2); ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Set 1</th>
                                <td class="table-light"><?php if($this->datos['4'] != null){echo $this->datos['4'];} ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Set 2</th>
                                <td class="table-light"><?php if($this->datos['5'] != null){echo $this->datos['5'];} ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Set 3</th>
                                <td class="table-light"><?php if($this->datos['6'] != null){echo $this->datos['6'];} ?></td>
                            </tr>
                            <tr>    
                                <th class="bg-dark text-white">Pista reservada</th>
                                <td class="table-light"><?php 
                                $reserva = new ReservaModel();
                                $reserva->setId($this->datos['9']);
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