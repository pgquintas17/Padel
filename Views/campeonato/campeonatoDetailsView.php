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

        function __construct($msg=null, $errs=null, $usuario=null, $datos=null,$filaC=null, $categorias=null, $filaG=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->datos = $datos;
            $this->filaC = array('sexonivel','id_catcamp');
            $this->categorias = $categorias;
            $this->filaG = array('id_grupo','id_catcamp','numero');
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Campeonato: <?php echo $this->datos['1'];?></h1><br>
            
            <div class="row justify-content-md-center">
                <div class="col-2" style="align-self: center;">
                    <?php
                    if(Utils::nivelPermiso(2)){
                    ?>
                        <a class="bg-ligth text-dark" href='/index.php?controller=adminCampeonatos'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </div>
                <div class="col-2" style="align-self: center;">
                    <a role="button" class="btn btn-link text-dark" data-toggle="modal" data-target="#confirmDelete"><i class="fas fa-trash-alt fa-2x"></i></a><br>
                </div>
                <?php
                    $hoy = date('Y-m-d');
                    if($this->datos['5'] > $hoy){
                ?>
                <div class="col-2" style="align-self: center;">  
                    <a class="bg-ligth text-dark" href='/index.php?controller=adminCampeonatos&action=EDIT&idcampeonato=<?php echo $this->datos['0'];?>'><i class="fas fa-edit fa-2x"></i></a>
                </div>
                <?php
                    }
                }
                else{
                ?>
                    <a class="bg-ligth text-dark" href='/index.php?controller=campeonatos'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </div>
            <?php
            }
            ?>
            <div class="col-6">
                <p style="text-align: right";><strong>Periodo inscripción:</strong> <?php echo date('d/m',strtotime($this->datos['4'])); ?> - <?php echo date('d/m',strtotime($this->datos['5'])); ?><br>
                <strong>Periodo de juego:</strong> <?php echo date('d/m',strtotime($this->datos['2'])); ?> - <?php echo date('d/m',strtotime($this->datos['3'])); ?></p>
            </div>
            </div>
            

        <!-- Panel categorías y grupos -->
            <div id="tablas" class="accordion">

            <?php
            while($this->filaC = ($this->categorias)->fetch_assoc()) {
            ?>
                <div class="card">
                    <div class="card-header" style="text-align: -webkit-left;">
                        <h5 class="mb-0">
                        <button class="btn btn-link text-dark font-weight-bold" data-toggle="collapse" data-target="#<?php echo $this->filaC['id_catcamp']; ?>">Categoría <?php 
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
                                                                <?php
                                                                    if(Utils::nivelPermiso(2)){
                                                                        $url = "/index.php?controller=adminCampeonatos&action=clasificacionCategoria&idcatcamp=".$this->filaC['id_catcamp'];
                                                                    }
                                                                    else{
                                                                        $url = "/index.php?controller=campeonatos&action=clasificacionCategoria&idcatcamp=".$this->filaC['id_catcamp'];

                                                                    }
                                                                ?>
                                                                <a class="text-dark" href='<?php echo $url; ?>'><i class="fas fa-list-alt"></i></a></h5>
                    </div>
                    <div id="<?php echo $this->filaC['id_catcamp']; ?>" class="collapse" data-parent="#accordion">
                        <div class="card-body">
                            <ul class="list-group">
                        <?php

                        require_once('Models/CampeonatoCategoriaModel.php');
                        $catcamp = new CampeonatoCategoriaModel();
                        $catcamp->setId($this->filaC['id_catcamp']);
                        require_once('Mappers/CampeonatoCategoriaMapper.php');
                        $catcampMapper = new CampeonatoCategoriaMapper();
                        $grupos = $catcampMapper->getGruposByCatCamp($catcamp);
                        if($grupos != null){

                            while($this->filaG = $grupos->fetch_assoc()) {
                                $idgrupo = $this->filaG['id_grupo'];
                                if(Utils::nivelPermiso(2)){
                                    $url = "/index.php?controller=adminGrupos&idgrupo=".$idgrupo;
                                }else{
                                    $url = "/index.php?controller=campeonatos&action=grupo&idgrupo=".$idgrupo;
                                }
                                
                            ?>
                                <a class="text-dark" href="<?php echo $url; ?>"><li class="list-group-item">Grupo número <?php echo $this->filaG['numero']; ?></li></a>
                            <?php
                            }
                                
                        }
                        else{
                            ?>
                                <li class="list-group-item text-dark">No existen grupos para la categoría seleccionada.</li>
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
            <!----->
    </div>



    <!--modal borrado campeonato-->
        <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="borrarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmación de borrado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de querer eliminar este campeonato? Se eleminirán todas las categorías, grupos, parejas y enfrentamientos del mismo.</p>
                </div>
                <div class="modal-footer">
                    <?php
                        $id_campeonato = $this->datos['0'];          
                        $url = "/index.php?controller=adminCampeonatos&action=DELETE&idcampeonato=". $id_campeonato;
                    ?>
                    <a href="<?php echo $url ?>" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Eliminar campeonato</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
                </div>
            </div>
        </div>
            <!--modal confirmación-->

<?php
        }
    }
    
?>