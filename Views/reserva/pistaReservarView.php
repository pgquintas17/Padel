<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/reservaModel.php');
    require_once('Mappers/reservaMapper.php');
    require_once('Mappers/pistaMapper.php');
    
    class PistaReservarView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $filaHoras;
        private $listaHoras;
        private $fecha;

        function __construct($msg=null, $errs=null, $usuario=null, $filaHoras=null, $listaHoras=null, $fecha=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->filaHoras = array('id','hora');
            $this->listaHoras = $listaHoras;
            if($fecha == null){
                $hoy = date('Y-m-d');
                $this->fecha = $hoy;
            }
            else{
                $this->fecha = $fecha;
            }
        }

        function _render() { 
            ?>

            <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
            <?php (new MSGView($this->msg, $this->errs))->render(); ?>
            <!-- ///////////////////////////////////////////// -->
            
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
            <br><h3>Añadir reserva</h3><br>
                <div class="row">

                    <div class="col-lg-2"></div>
                    <div class="bg-dark text-white rounded p-3 col-md-8" id="perfilform">

                        <!-- Formulario datos usuario -->
                        <form action="/" method="POST" name="formReservaPista">

                        <input type="hidden" name="controller" value="reservas">

                            <div class="justify-content-md-center">
                                <div class="form-group col-md-6">
                                    <label for="fecha"><strong>Día</strong></label>
                                    <input type="date" class="form-control" name="fecha" value="<?php echo $this->fecha; ?>">
                                </div>
                            </div>
                                <button type="submit" class="btn btn-light" name="action" value="reservar" id="submit">Elegir día</button><br><br>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label><strong>Hora</strong></label>
                                    <table class="table table-hover table-bordered">
                                        <tbody>
                                            <tr>
                                                <?php
                                                while($this->filaHoras = ($this->listaHoras)->fetch_assoc()) {
                                                    $hora = $this->filaHoras['hora'];
                                                    $reserva = new ReservaModel();
                                                    $reserva->setFecha($this->fecha);
                                                    $reserva->setHora($hora);
                                                    require_once('Mappers/reservaMapper.php');
                                                    $reservaMapper = new ReservaMapper();
                                                    $reservasEnFecha = $reservaMapper->getNumReservasByDiaYHora($reserva);
                                                    require_once('Mappers/pistaMapper.php');
                                                    $pistaMapper = new PistaMapper();
                                                    $pistasActivas = $pistaMapper->getNumPistasActivas();

                                                    if($reservasEnFecha >= $pistasActivas){
                                                    ?>
                                                        <td class="table-danger text-dark" style="text-align: -webkit-center";><?php echo date('H:i',strtotime($this->filaHoras['hora'])); ?></td>
                                                    <?php
                                                    }
                                                    else{
                                                    ?>
                                                        <td class="table-light text-dark" style="text-align: -webkit-center";><label><input class="form-check-input" type="radio" name="inputHora" value="<?php echo $hora;?>"><?php echo date('H:i',strtotime($this->filaHoras['hora'])); ?></label></td>
                                                    <?php
                                                    }
                                                
                                                }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: justify;">
                                <label><strong>Tipo de superficie</strong></label>
                                <div class="form-check row">
                                    <label><div class="col-md-2">
                                        <input class="form-check-input" type="radio" name="inputTipo" value="1">
                                    </div>
                                    <div class="col-md-12">
                                        Césped artificial
                                    </div></label>
                                </div>
                                <div class="form-check row">
                                    <label><div class="col-md-2">
                                        <input class="form-check-input" type="radio" name="inputTipo" value="2">
                                    </div>
                                    <div class="col-md-12">
                                        Resina sintética
                                    </div></label>
                                </div>
                                <div class="form-check row">
                                    <label><div class="col-md-2">
                                        <input class="form-check-input" type="radio" name="inputTipo" value="3">
                                    </div>
                                    <div class="col-md-12">
                                        Hormigón poroso
                                    </div></label>
                                </div>
                                <div class="form-check row">
                                    <label><div class="col-md-2">
                                        <input class="form-check-input" type="radio" name="inputTipo" value="4">
                                    </div>
                                    <div class="col-md-12">
                                        Cemento
                                    </div></label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-light" name="action" value="ADD" id="submit">Reservar</button>
                        </form>
                    </div>
                    <div class="col-lg-2"></div>
                </div>
                <div class="col-lg-3"></div>
            </div>

        <?php
        }
    }
    
?>