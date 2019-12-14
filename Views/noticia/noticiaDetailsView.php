<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');
    require_once('Models/noticiaModel.php');

    class NoticiaDetailsView extends baseView {

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
            <h1><?php echo $this->datos['1'];?></h1><br>
            
            <div class="row justify-content-md-center">
                <div class="col-2" style="align-self: center;">
                    <?php
                    if(Utils::nivelPermiso(2)){
                    ?>
                        <a class="bg-ligth text-dark" href='/index.php?controller=adminNoticias'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </div>
                <div class="col-2" style="align-self: center;">
                    <a role="button" class="btn btn-link text-dark" data-toggle="modal" data-target="#confirmDelete"><i class="fas fa-trash-alt fa-2x"></i></a><br>
                </div>
                <div class="col-2" style="align-self: center;">  
                    <a class="bg-ligth text-dark" href='/index.php?controller=adminNoticias&action=EDIT&idnoticia=<?php echo $this->datos['0'];?>'><i class="fas fa-edit fa-2x"></i></a>
                </div>
                <?php
                }
                else{
                ?>
                    <a class="bg-ligth text-dark" href='/index.php'><i class="fas fa-arrow-circle-left fa-2x"></i></a>
                </div>
            <?php
            }
            ?>
            <div class="col-6">
                <p style="text-align: right";><strong>Fecha de creación:</strong> <?php echo date('d/m',strtotime($this->datos['3'])); ?></p>
            </div>
            </div>
            

        <!-- Noticia -->
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
                    <p>¿Estás seguro de querer eliminar esta noticia?</p>
                </div>
                <div class="modal-footer">
                    <?php
                        $id = $this->datos['0'];          
                        $url = "/index.php?controller=adminNoticias&action=DELETE&idnoticia=". $id;
                    ?>
                    <a href="<?php echo $url ?>" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Eliminar noticia</a>
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