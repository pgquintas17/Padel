<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    
    class CampeonatoADDView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $fila;
        private $categorias;

        function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $categorias=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->fila = array('id_categoria','sexonivel');
            $this->categorias = $categorias;
        }

        function _render() { 
            ?>

            <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
            <?php (new MSGView($this->msg, $this->errs))->render(); ?>
            <!-- ///////////////////////////////////////////// -->
            
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
            <br><h3>Crear campeonato</h3><br>
                <div class="row">

                    <div class="col-lg-2"></div>
                    <div class="bg-dark text-white rounded p-3 col-md-8" id="perfilform">

                        <!-- Formulario datos usuario -->
                        <form action="/" method="POST" name="formADDCampeonato">

                        <input type="hidden" name="controller" value="adminCampeonatos">
                        <input type="hidden" name="action" value="ADD">

                            <div class="form-group col-md-6">
                                <label for="fecha"><strong>Nombre</strong></label>
                                <input type="text" class="form-control" name="nombre">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fechainicio">Fecha de inicio</label>
                                    <input type="date" class="form-control" name="fechainicio">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fechafin">Fecha de fin</label>
                                    <input type="date" class="form-control" name="fechafin">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fechainicioins">Fecha de Inicio inscripciones</label>
                                    <input type="date" class="form-control" name="fechainicioins">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="fechafinins">Fecha de Fin inscripciones</label>
                                    <input type="date" class="form-control" name="fechafinins">
                                </div>
                            </div>
                            <div class="form-row col-md-6 justify-content-md-center">
                                <label><strong>Categorías</strong></label><br><br>
                            </div>
                            <div class="form-row col-md-6">
                                <?php
                                while($this->fila = ($this->categorias)->fetch_assoc()) {
                                    ?>
                                    <div class="form-check row">
                                    <label><div class="col-md-2">
                                            <input type="checkbox" name="categoria[]" value="<?php echo $this->fila['id_categoria']; ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <?php 
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
                                
                                                                ?>
                                        </div></label>
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