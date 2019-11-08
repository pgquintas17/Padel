<?php

    require_once('Views/baseView.php');
    require_once('Models/pistaModel.php');
    require_once('Views/mensajeView.php');

    class AdminPistaView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $fila;
        private $listaPistas;

        function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $listaPistas=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->fila = array('idpista','estado');
            $this->listaPistas = $listaPistas;
        }

        function _render() { 
?>


        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        
        <!-- ///////////////////////////////////////////// -->
          <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Pistas</h1><br>
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addPista"><i class="fas fa-plus-circle fa-2x"></i></button><br><br>
            <div class="row justify-content-md-center">
                <!-- Tabla pistas -->
                <div class="col-md-4">
                    <table class="table table-hover table-bordered" id="tablas" style="border-radius: 25px; text-align: center;">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Número de pista</th>
                                <th scope="col">Abrir/cerrar</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php

                            while($this->fila = ($this->listaPistas)->fetch_assoc()) {
                                $id_pista = $this->fila['id_pista'];          
                                $url = "/index.php?controller=adminPistas&action=RESERVAS&idpista=". $id_pista;
                    ?>
                                <?php
                                    if($this->fila['estado'] == 1){
                                ?>
                                <tr class="table-light clickeable-row" onclick="window.location.assign('<?php echo $url ?>');">
                                    <td><?php echo $this->fila['id_pista']; ?></td>
                                    <td><a class="bg-ligth text-dark" href='/index.php?controller=adminPistas&action=ESTADO&idpista=<?php echo $this->fila['id_pista']; ?>'><i class="fas fa-toggle-on fa-2x"></i></a></td>
                                <?php
                                    }
                                    else{
                                ?>
                                <tr class="table-danger clickeable-row" onclick="window.location.assign('<?php echo $url ?>');">
                                    <td><?php echo $this->fila['id_pista']; ?></td>
                                    <td><a class="bg-ligth text-dark" href='/index.php?controller=adminPistas&action=ESTADO&idpista=<?php echo $this->fila['id_pista']; ?>'><i class="fas fa-toggle-off fa-2x"></i></a></td>
                                <?php    
                                    }
                                ?>
                                </tr>
                            
                    <?php
                    
                            }
                    
                    ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <!--modal addPista-->
    <div class="modal fade" id="addPista" tabindex="-1" role="dialog" aria-labelledby="borrarLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Pista</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="/" method="POST" name="addPistas">
                        <input type="hidden" name="controller" value="adminPistas">
                        <input type="hidden" name="action" value="ADD">

                        <div class="form-group">
                        <label>Número de pista</label>
                        <input type="text" class="form-control" name="inputID">
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark" value="Login">Añadir pista</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
            <!--modal addPista-->

<?php
        }
    }
    
?>