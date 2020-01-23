<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/parejaModel.php');
    require_once('Mappers/parejaMapper.php');
    require_once('Mappers/pistaMapper.php');
    
    class EnfPropuestaView extends baseView {

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
                <strong>Parejas: </strong><?php echo (new ParejaMapper())->getNombreById((new ParejaModel($this->datos['3']))) . " vs. " . (new ParejaMapper())->getNombreById((new ParejaModel($this->datos['4'])))  ;?></p>
            </div>
            </div>

                <div class="row">

                    <div class="col"></div>
                    <div class="bg-light text-black rounded p-3 col-md-6" id="perfilform">

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

                        if($this->datos['1'] != null){?> <input type="hidden" name="propuesta" value="<?php echo $this->datos['1']; ?>"> <?php }
                        if($this->datos['2'] != null){?> <input type="hidden" name="propuesta" value="<?php echo $this->datos['2']; ?>"> <?php }

                    ?>

                            <div class="justify-content-md-center">
                            <div class="form-group col"></div>
                                <div class="form-group col" style="text-align: -webkit-center";>
                                    <p style="text-align: justify; width: 200px";>La propuesta actual para este partido es 
                                    <?php
                                        if($this->datos['1'] != null){echo "<strong>". date('d/m H:i',strtotime($this->datos['1'])) ."</strong>";}
                                        if($this->datos['2'] != null){echo "<strong>". date('d/m H:i',strtotime($this->datos['2'])) ."</strong>";} 
                                    ?>
                                </div>
                                <div class="form-group col"></div>
                            </div>
                                <button type="submit" class="btn btn-dark" name="action" value="aceptar" id="submit">Aceptar</button> <button type="submit" class="btn btn-secondary" name="action" value="rechazar" id="submit">Rechazar</button><br><br>
                        </form>
                    </div>
                    <div class="col"></div>
                </div>
                <div class="col-lg-3"></div>
            </div>

        <?php
        }
    }
    
?>