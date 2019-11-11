<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    
    class InscripcionCampeonatoView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $fila;
        private $categorias;
        private $camp;

        function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $categorias=null,$camp=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->fila = array('sexonivel','id_catcamp');
            $this->categorias = $categorias;
            $this->camp = $camp;
        }

        function _render() { 
            ?>

            <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
            <?php (new MSGView($this->msg, $this->errs))->render(); ?>
            <!-- ///////////////////////////////////////////// -->
            
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
            <br><h3>Inscripción para <strong><?php echo $this->camp['0']; ?></strong></h3><br>
                <div class="row">

                    <div class="col-lg-2"></div>
                    <div class="bg-dark text-white rounded p-3 col-md-8" id="perfilform">

                        <!-- Formulario datos usuario -->
                        <form action="/" method="POST" name="formADDCampeonato">

                        <input type="hidden" name="controller" value="campeonatos">
                        <input type="hidden" name="action" value="inscripcion">
                        <input type="hidden" name="idcampeonato" value="<?php echo $this->camp['1']; ?>">

                            <div class="form-group col-md-6">
                                <label for="fecha"><strong>Nombre pareja</strong></label>
                                <input type="text" class="form-control" name="nombre">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                <?php $capitan = $_SESSION['Usuario']->getLogin(); ?>
                                    <label for="fecha"><strong>Capitán</strong></label>
                                    <input type="text" class="form-control" name="capitan" readonly value="<?php echo $capitan; ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fecha"><strong>Miembro</strong></label>
                                    <input type="text" class="form-control" name="miembro">
                                </div>
                            </div>
                            <div class="form-row col-md-4">
                                <label><strong>Categoría</strong></label><br><br>
                            </div>
                            <div class="form-row col-md-3">
                                <?php
                                while($this->fila = ($this->categorias)->fetch_assoc()) {
                                    ?>
                                    <div class="form-check row">
                                        <div class="col-md-2">
                                        <input class="form-check-input" type="radio" name="categoria" value="<?php echo $this->fila['id_catcamp']; ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <label><?php 
                                                                if($this->fila['sexonivel'] == 'M1'){
                                                                    echo "1ª masculina";
                                                                }
                                                                    
                                                                if($this->fila['sexonivel'] == 'M2'){
                                                                    echo "2ª masculina";
                                                                }
                                                                
                                                                if($this->fila['sexonivel'] == 'M3'){
                                                                    echo "3ª masculina";
                                                                }
                                                                
                                                                if($this->fila['sexonivel'] == 'F1'){
                                                                    echo "1ª femenina";
                                                                }
                                                                    
                                                                if($this->fila['sexonivel'] == 'F2'){
                                                                    echo "2ª femenina";
                                                                }
                                                                
                                                                if($this->fila['sexonivel'] == 'F3'){
                                                                    echo "3ª femenina";
                                                                }

                                                                if($this->fila['sexonivel'] == 'MX1'){
                                                                    echo "1ª mixta";
                                                                }
                                                                    
                                                                if($this->fila['sexonivel'] == 'MX2'){
                                                                    echo "2ª mixta";
                                                                }
                                                                
                                                                if($this->fila['sexonivel'] == 'MX3'){
                                                                    echo "3ª mixta";
                                                                }
                                
                                                                ?></label>
                                        </div>
                                    </div>
                                    <?php
                                
                                }
                                ?>
                            </div>
                            <button type="submit" class="btn btn-light" id="submit">Crear</button>
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