<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    
    class CampeonatoEditView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $filaA;
        private $catActuales;
        private $filaF;
        private $catFaltan;
        private $datos;

        function __construct($msg=null, $errs=null, $usuario=null, $filaA=null, $catActuales=null, $filaF=null, $catFaltan=null, $datos=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->filaA = array('sexonivel','id_catcamp');
            $this->catActuales = $catActuales;
            $this->filaF = array('id_categoria','sexonivel');
            $this->catFaltan = $catFaltan;
            $this->datos = $datos;
        }

        function _render() { 
            ?>

            <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
            <?php (new MSGView($this->msg, $this->errs))->render(); ?>
            <!-- ///////////////////////////////////////////// -->
            
            <!-- Jumbotron -->
            <div  id="espacio_info" class="jumbotron">
            <br><h3>Editar campeonato: <?php echo $this->datos['1']; ?></h3><br>

            <div class="row justify-content-md-center">
                <div class="col-2" style="align-self: center;">
                    <a class="bg-ligth text-dark" href='/index.php?controller=adminCampeonatos&action=DETAILS&idcampeonato=<?php echo $this->datos['0']; ?>'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </div>
            <div class="col">
                <p class="text-danger" style="text-align: right";>Recuerda que si eliminas todas las categorías del campeonato también se borrará el campeoanto</p>
            </div>
            </div>

                <div class="row">

                    <div class="bg-dark text-white rounded p-3 col" id="perfilform">

                        <!-- Formulario borrar categorías -->
                        <form action="/" method="POST" name="formEDITCampeonato">

                        <input type="hidden" name="controller" value="adminCampeonatos">
                        <input type="hidden" name="action" value="borrarCategorias">
                        <input type="hidden" name="idcampeonato" value="<?php echo $this->datos['0']; ?>">

                            <div class="form-row col justify-content-md-center">
                                <label><strong>Borrar categorías</strong></label><br><br>
                            </div>
                            <div class="form-row">
                                <?php
                                while($this->filaA = ($this->catActuales)->fetch_assoc()) {
                                    ?>
                                    <div class="form-check row">
                                    <label><div class="col-md-4">
                                            <input type="checkbox" name="categoria[]" value="<?php echo $this->filaA['id_catcamp']; ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <?php 
                                                                if($this->filaA['sexonivel'] == 'M1'){
                                                                    echo "1ª masculina";
                                                                }
                                                                    
                                                                if($this->filaA['sexonivel'] == 'M2'){
                                                                    echo "2ª masculina";
                                                                }
                                                                
                                                                if($this->filaA['sexonivel'] == 'M3'){
                                                                    echo "3ª masculina";
                                                                }
                                                                
                                                                if($this->filaA['sexonivel'] == 'F1'){
                                                                    echo "1ª femenina";
                                                                }
                                                                    
                                                                if($this->filaA['sexonivel'] == 'F2'){
                                                                    echo "2ª femenina";
                                                                }
                                                                
                                                                if($this->filaA['sexonivel'] == 'F3'){
                                                                    echo "3ª femenina";
                                                                }

                                                                if($this->filaA['sexonivel'] == 'MX1'){
                                                                    echo "1ª mixta";
                                                                }
                                                                    
                                                                if($this->filaA['sexonivel'] == 'MX2'){
                                                                    echo "2ª mixta";
                                                                }
                                                                
                                                                if($this->filaA['sexonivel'] == 'MX3'){
                                                                    echo "3ª mixta";
                                                                }
                                
                                                                ?>
                                        </div></label>
                                    </div>
                                    <?php
                                
                                }
                                ?>
                            </div>
                            <br><button type="submit" class="btn btn-light" id="submit">Borrar</button><br><br>
                        </form>
                    </div>

                    

                    <div class="bg-dark text-white rounded p-3 col" id="perfilform">

                        <!-- Formulario añadir categorías -->
                        <form action="/" method="POST" name="formEDITCampeonato">

                        <input type="hidden" name="controller" value="adminCampeonatos">
                        <input type="hidden" name="action" value="addCategorias">
                        <input type="hidden" name="idcampeonato" value="<?php echo $this->datos['0']; ?>">

                            <div class="form-row col justify-content-md-center">
                                <label><strong>Añadir categorías</strong></label><br><br>
                            </div>
                            <div class="form-row">
                                <?php
                                if($this->catFaltan != null){
                                while($this->filaF = ($this->catFaltan)->fetch_assoc()) {
                                    ?>
                                    <div class="form-check row">
                                    <label><div class="col-md-4">
                                            <input type="checkbox" name="categoria[]" value="<?php echo $this->filaF['id_categoria']; ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <?php 
                                                                if($this->filaF['sexonivel'] == 'M1'){
                                                                    echo "1ª masculina";
                                                                }
                                                                    
                                                                if($this->filaF['sexonivel'] == 'M2'){
                                                                    echo "2ª masculina";
                                                                }
                                                                
                                                                if($this->filaF['sexonivel'] == 'M3'){
                                                                    echo "3ª masculina";
                                                                }
                                                                
                                                                if($this->filaF['sexonivel'] == 'F1'){
                                                                    echo "1ª femenina";
                                                                }
                                                                    
                                                                if($this->filaF['sexonivel'] == 'F2'){
                                                                    echo "2ª femenina";
                                                                }
                                                                
                                                                if($this->filaF['sexonivel'] == 'F3'){
                                                                    echo "3ª femenina";
                                                                }

                                                                if($this->filaF['sexonivel'] == 'MX1'){
                                                                    echo "1ª mixta";
                                                                }
                                                                    
                                                                if($this->filaF['sexonivel'] == 'MX2'){
                                                                    echo "2ª mixta";
                                                                }
                                                                
                                                                if($this->filaF['sexonivel'] == 'MX3'){
                                                                    echo "3ª mixta";
                                                                }
                                
                                                                ?>
                                        </div></label>
                                    </div>
                                    <?php
                                
                                }
                                ?>
                            </div>
                            <br><button type="submit" class="btn btn-light" id="submit">Añadir</button><br><br>
                            <?php
                            }
                            else{
                                ?>
                                <p>No falta ninguna categoría en el campeonato seleccionado.</p>
                                <?php
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>

        <?php
        }
    }
    
?>