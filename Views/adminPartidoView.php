<?php

    require_once('Views/baseView.php');
    require_once('Models/partidoModel.php');
    require_once('Views/mensajeView.php');

    class AdminPartidoView extends baseView {

        private $usuario;
        private $msg;
        private $errs;
        private $filaPartidos;
        private $listaPartidos;
        private $filaHoras;
        private $listaHoras;

        function __construct($msg=null, $errs=null, $usuario=null, $filaPartidos=null, $listaPartidos=null, $filaHoras=null, $listaHoras=null) {
            $this->msg = $msg;
            $this->errs = $errs;
            parent::__construct($this->usuario);
            $this->filaPartidos = array('id_partido','hora','fecha','promocion','login1','login2','login3','login4','id_reserva');
            $this->listaPartidos = $listaPartidos;
            $this->filaHoras = array('id','hora');
            $this->listaHoras = $listaHoras;
        }

        function _render() { 
?>

        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->

        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Partidos</h1><br>
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#addPartido"><i class="fas fa-plus-circle fa-2x"></i></button><br><br>

        

        <!-- Tabla partidos -->
        <div id="tablas">
        <table class="table table-hover table-bordered" style="border-radius: 25px;">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Plazas libres</th>
                    <th scope="col">Promoción</th>
                </tr>
            </thead>
            <tbody>
        <?php

                while($this->filaPartidos = ($this->listaPartidos)->fetch_assoc()) {
                    $fecha = date('Y-m-d');
                    $id_partido = $this->filaPartidos['id_partido'];          
                    $url = "/index.php?controller=adminPartidos&action=DETAILS&idpartido=". $id_partido;
                    $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id_partido);
                    
                    if($this->filaPartidos['fecha'] >= $fecha){
        ?>
                    
                        <?php
                        if($this->filaPartidos['promocion'] == 1){
                            ?>
                            <tr class="table-light clickeable-row" onclick="window.location.assign('<?php echo $url ?>');">
                            <td><?php echo date('d-m-Y',strtotime($this->filaPartidos['fecha'])); ?></td>
                            <td><?php echo date('H:i',strtotime($this->filaPartidos['hora']));?></td>
                            <td><?php echo $numPlazas; ?></td>
                            <td><a class="bg-ligth text-dark" href='/index.php?controller=adminPartidos&action=PROMOCION&idpartido=<?php echo $this->filaPartidos['id_partido']; ?>'><i class="fas fa-toggle-on fa-2x"></i></a></td>
                            <?php
                            }
                            else{
                            ?>
                            <tr class="table-danger clickeable-row" onclick="window.location.assign('<?php echo $url ?>');">
                            <td><?php echo date('d-m-Y',strtotime($this->filaPartidos['fecha'])); ?></td>
                            <td><?php echo date('H:i',strtotime($this->filaPartidos['hora']));?></td>
                            <td><?php echo $numPlazas; ?></td>
                            <td><a class="bg-ligth text-dark" href='/index.php?controller=adminPartidos&action=PROMOCION&idpartido=<?php echo $this->filaPartidos['id_partido']; ?>'><i class="fas fa-toggle-off fa-2x"></i></a></td>
                            <?php
                            }
                        }
                        else{
                        ?>
                        <tr class='clickeable-row' onclick="window.location.assign('<?php echo $url ?>');" style="cursor:pointer;">
                        <td class="table-secondary"><?php echo date('d-m-Y',strtotime($this->filaPartidos['fecha'])); ?></td>
                        <td class="table-secondary"><?php echo date('H:i',strtotime($this->filaPartidos['hora'])); ?></td>
                        <td class="table-secondary"></td>
                        <td class="table-secondary"></td>
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

    <!--modal addPartido-->
    <div class="modal fade bd-example-modal-lg" id="addPartido" tabindex="-1" role="dialog" aria-labelledby="borrarLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Partido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="/" method="POST" name="addPartido">
                        <input type="hidden" name="controller" value="adminPartidos">
                        <input type="hidden" name="action" value="ADD">

                        <div class="row justify-content-md-center">
                        <div class="col-md-auto">
                        <div class="form-group">
                        <label><strong>Día</strong></label>
                        <input type="date" class="form-control" name="inputFecha">
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label><strong>Hora</strong></label>
                            <table class="table table-hover table-bordered">
                                <tbody>
                                    <tr>
                                        <?php
                                        while($this->filaHoras = ($this->listaHoras)->fetch_assoc()) {
                                            $hora = $this->filaHoras['hora'];
                                        ?>
                                        <td class="table-light" style="text-align: -webkit-center";><input class="form-check-input" type="radio" name="inputHora" value="<?php echo $hora;?>"><?php echo date('H:i',strtotime($this->filaHoras['hora'])); ?></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="submit" class="btn btn-dark" value="Login">Añadir partido</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            </div>
            <!--modal addPartidos-->

<?php
        }
    }
    
?>