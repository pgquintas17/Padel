<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/parejaModel.php');
    require_once('Mappers/parejaMapper.php');
    require_once('Mappers/pistaMapper.php');
    
    class EnfrentamientoPropuestaView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $filaHoras;
        private $listaHoras;
        private $fecha;
        private $datos;

        function __construct($msg=null, $errs=null, $usuario=null, $filaHoras=null, $listaHoras=null, $fecha=null, $datos=null) {
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
            $this->datos = $datos;
        }

        function _render() { 
            ?>

            <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
            <?php (new MSGView($this->msg, $this->errs))->render(); ?>
            <!-- ///////////////////////////////////////////// -->
            
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
            <br><h3>Proponer fecha</h3><br>

            <div class="row justify-content-md-center">
                <div class="col-2" style="align-self: center;">
                    <a class="bg-ligth text-dark" href='/index.php?controller=campeonatos&action=grupo&idgrupo=<?php echo $this->datos['8']; ?>'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </div>
            <div class="col-6">
                <p style="text-align: right";><strong><?php echo $this->datos['5'] . ", "; if($this->datos['6'] == 'M1'){
                                                                                                echo "1ª masculina";
                                                                                            }
                                                                                                
                                                                                            if($this->datos['6'] == 'M2'){
                                                                                                echo "2ª masculina";
                                                                                            }
                                                                                            
                                                                                            if($this->datos['6'] == 'M3'){
                                                                                                echo "3ª masculina";
                                                                                            }
                                                                                            
                                                                                            if($this->datos['6'] == 'F1'){
                                                                                                echo "1ª femenina";
                                                                                            }
                                                                                                
                                                                                            if($this->datos['6'] == 'F2'){
                                                                                                echo "2ª femenina";
                                                                                            }
                                                                                            
                                                                                            if($this->datos['6'] == 'F3'){
                                                                                                echo "3ª femenina";
                                                                                            }

                                                                                            if($this->datos['6'] == 'MX1'){
                                                                                                echo "1ª mixta";
                                                                                            }
                                                                                                
                                                                                            if($this->datos['6'] == 'MX2'){
                                                                                                echo "2ª mixta";
                                                                                            }
                                                                                            
                                                                                            if($this->datos['6'] == 'MX3'){
                                                                                                echo "3ª mixta";
                                                                                            }; echo ", grupo nº " . $this->datos['7'] ;?></strong><br>
                <strong>Parejas: </strong><?php echo (new ParejaMapper())->getNombreById((new ParejaModel($this->datos['3']))) . " vs. " . (new ParejaMapper())->getNombreById((new ParejaModel($this->datos['4'])))  ;?><br>
                <?php 
                    if($this->datos['1'] != null){echo "<strong>Propuesta actual: </strong>" . date('d/m H:i',strtotime($this->datos['1']));}
                    if($this->datos['2'] != null){echo "<strong>Propuesta actual: </strong>" . date('d/m H:i',strtotime($this->datos['2']));}
                ?>
                <div class="text-danger" style="text-align: right";>No se pueden proponer fechas con menos de cinco días de antelación.</div></p>
            </div>
            </div>

                <div class="row">

                    <div class="col-lg-2"></div>
                    <div class="bg-dark text-white rounded p-3 col-md-8" id="perfilform">

                        <!-- Formulario datos propuesta -->
                        <form action="/" method="POST" name="formPropuestaEnfrentamiento">

                        <input type="hidden" name="controller" value="enfrentamientos">
                        <input type="hidden" name="idenfrentamiento" value="<?php echo $this->datos['0']; ?>">
                        
                        <?php
                            $pareja = new ParejaModel();
                            $pareja->setId($this->datos['3']);
                            $pareja->setCapitan($_SESSION['Usuario']->getLogin());
                            if((new ParejaMapper())->esCapiDe($pareja)){
                        ?>
                                <input type="hidden" name="pareja" value="<?php echo $this->datos['3']; ?>">
                        <?php
                            }
                            else{
                        ?>
                                <input type="hidden" name="pareja" value="<?php echo $this->datos['4']; ?>">
                        <?php
                            }

                            if($this->datos['1'] != null){?> <input type="hidden" name="propuesta1" value="<?php echo $this->datos['1']; ?>"> <?php }
                            if($this->datos['2'] != null){?> <input type="hidden" name="propuesta2" value="<?php echo $this->datos['2']; ?>"> <?php }

                        ?>

                            <div class="justify-content-md-center">
                                <div class="form-group col-md-6">
                                    <label for="fecha"><strong>Día</strong></label>
                                    <input type="date" class="form-control" name="fecha" value="<?php echo $this->fecha; ?>">
                                </div>
                            </div>
                                <button type="submit" class="btn btn-light" name="action" value="cambiarFecha" id="submit">Elegir día</button><br><br>
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

                                                    if($reservasEnFecha == $pistasActivas){
                                                    ?>
                                                        <td class="table-danger text-dark" style="text-align: -webkit-center";><?php echo date('H:i',strtotime($this->filaHoras['hora'])); ?></td>
                                                    <?php
                                                    }
                                                    else{
                                                    ?>
                                                        <td class="table-light text-dark" style="text-align: -webkit-center";><label><input class="form-check-input" type="radio" name="hora" value="<?php echo $hora;?>"><?php echo date('H:i',strtotime($this->filaHoras['hora'])); ?></label></td>
                                                    <?php
                                                    }
                                                
                                                }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                    <button type="submit" class="btn btn-light" name="action" value="addPropuesta" id="submit">Proponer fecha</button>
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