<?php

    require_once('Views/baseView.php');
    require_once('Models/usuarioModel.php');
    require_once('Views/mensajeView.php');

    class UsuarioDetailsView extends baseView {

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
            <br><h3>Usuario: <?php echo $this->datos['1']; ?></h3><br>
            <div class="row justify-content-around">
                <a class="bg-ligth text-dark" href="/index.php?controller=adminUsuarios"><i class="fas fa-arrow-circle-left fa-2x"></i></a><br>
            </div>  
                <div class="row justify-content-md-center">
                    <div class="col-md-auto"> 

                        <!-- Tabla datos usuario -->
                        <table class="table table-hover table-bordered" style="border-radius: 25px;">
                            <tr>
                            <th class="bg-dark text-white">Login</th>
                                <td class="table-light"><?php echo $this->datos['0']; ?></td>
                            </tr>
                            <tr>    
                                <th class="bg-dark text-white">Nombre</th>
                                <td class="table-light"><?php echo $this->datos['1']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Fecha de Nacimiento</th>
                                <td class="table-light"><?php echo date('d/m/Y',strtotime($this->datos['3'])); ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Teléfono</th>
                                <td class="table-light"><?php echo $this->datos['4']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Email</th>
                                <td class="table-light"><?php echo $this->datos['5']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Genero</th>
                                <td class="table-light"><?php echo $this->datos['6']; ?></td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Permiso</th>
                                <td class="table-light">
                                    <?php 
                                        if($this->datos['7'] == 0)
                                            echo "Deportista";
                                        if($this->datos['7'] == 1)
                                            echo "Entrenador";
                                        if($this->datos['7'] == 2)
                                            echo "Administrador"; 
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-dark text-white">Suscripción</th>
                                <td class="table-light">
                                    <?php 
                                        if($this->datos['8'] == 0)
                                            echo "No";
                                        if($this->datos['8'] == 1)
                                            echo "Sí";
                                    ?>
                                </td>
                            </tr>
                        </table>
                        <br><button type="button" class="btn btn-link text-dark" data-toggle="modal" data-target="#confirmDelete"><i class="fas fa-trash-alt fa-2x"></i></button>
                    </div>
                </div>
            </div>

            <!--modal confirmación-->
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
                    <p>¿Estás seguro de querer eliminar al usuario <strong><?php echo $this->datos['0']; ?></strong> y todos los datos relacionados con él? </p>
                </div>
                <div class="modal-footer">
                    <?php
                        $login = $this->datos['0'];          
                        $url = "/index.php?controller=adminUsuarios&action=DELETE&username=". $login;
                    ?>
                    <a href="<?php echo $url ?>" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Eliminar usuario</a>
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