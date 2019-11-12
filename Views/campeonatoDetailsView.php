<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/campeonatoModel.php');

    class CampeonatoDetailsView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $datos;
        private $filaC;
        private $categorias;
        private $filaG;
        private $grupos;

        function __construct($msg=null, $errs=null, $usuario=null, $datos=null,$filaC=null, $categorias=null, $filaG=null, $grupos=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->datos = $datos;
            $this->filaC = array('sexonivel','id_catcamp');
            $this->categorias = $categorias;
            $this->filaG = array('id_catcamp','numero');
            $this->grupos = $grupos;
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Campeonato: <?php echo $this->datos['1'];?></h1><br>

            <p style="text-align: right";><strong>Periodo inscripción:</strong> <?php echo date('d-m-Y',strtotime($this->datos['4'])); ?> hasta el <?php echo date('d-m-Y',strtotime($this->datos['5'])); ?><br>
            <strong>Periodo de juego:</strong> <?php echo date('d-m-Y',strtotime($this->datos['2'])); ?> hasta el <?php echo date('d-m-Y',strtotime($this->datos['3'])); ?></p>
            
            <div class="col-2">
            <?php
            if(Utils::nivelPermiso(2)){
            ?>
                <a class="bg-ligth text-dark" href='/index.php?controller=adminCampeonatos'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
            <?php
            }
            else{
            ?>
                <a class="bg-ligth text-dark" href='/index.php?controller=adminCampeonatos'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
            <?php
            }
            ?>
            </div><br>

        <!-- Panel categorías y grupos -->
            <div class="accordion">

            <?php
            while($this->filaC = ($this->categorias)->fetch_assoc()) {
            ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                        <button class="btn btn-link text-dark" data-toggle="collapse" data-target="#<?php echo $this->filaC['id_catcamp']; ?>">Categoría <?php 
                                                                if($this->filaC['sexonivel'] == 'M1'){
                                                                    echo "1ª masculina";
                                                                }
                                                                    
                                                                if($this->filaC['sexonivel'] == 'M2'){
                                                                    echo "2ª masculina";
                                                                }
                                                                
                                                                if($this->filaC['sexonivel'] == 'M3'){
                                                                    echo "3ª masculina";
                                                                }
                                                                
                                                                if($this->filaC['sexonivel'] == 'F1'){
                                                                    echo "1ª femenina";
                                                                }
                                                                    
                                                                if($this->filaC['sexonivel'] == 'F2'){
                                                                    echo "2ª femenina";
                                                                }
                                                                
                                                                if($this->filaC['sexonivel'] == 'F3'){
                                                                    echo "3ª femenina";
                                                                }

                                                                if($this->filaC['sexonivel'] == 'MX1'){
                                                                    echo "1ª mixta";
                                                                }
                                                                    
                                                                if($this->filaC['sexonivel'] == 'MX2'){
                                                                    echo "2ª mixta";
                                                                }
                                                                
                                                                if($this->filaC['sexonivel'] == 'MX3'){
                                                                    echo "3ª mixta";
                                                                }
                                
                                                                ?></button>
                                                                </h5>
                    </div>
                    <div id="<?php echo $this->filaC['id_catcamp']; ?>" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <ul class="list-group">
                        <?php
                        while($this->filaG = ($this->grupos)->fetch_assoc()) {
                        ?>
                                <li class="list-group-item"><a class="text-dark" href="#enfrentamientos">Grupo número <?php echo $this->filaG['numero']; ?></a></li>
                        <?php
                        }
                        ?>
                            </ul>
                        </div>
                    </div>
                </div>
                    
                <?php
                }
                ?>
            </div>
    </div>

<?php
        }
    }
    
?>