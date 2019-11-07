<?php

require_once('Views/baseView.php');
require_once('Views/mensajeView.php');
require_once('Mappers/partidoMapper.php');
require_once('Models/usuarioModel.php');
require_once('Services/Utils.php');

class IndexView extends baseView {

    private $usuario;
    private $msg;
    private $errs;
    private $partidos;

    function __construct($msg=null, $errs=null, $usuario=null, $fila=null, $partidos=null) {
        $this->msg = $msg;
        $this->errs = $errs;
        parent::__construct($this->usuario);
        $this->fila = array('id_partido','resultado','hora','fecha','promocion','login1','login2','login3','login4','id_reserva');
        $this->partidos = $partidos;
    }

    function _render() { 
        ?>
        <!-- ESTA ES LA VISTA DEL MENSAJE Y DE LOS ERRORES -->
        <?php (new MSGView($this->msg, $this->errs))->render(); ?>
        <!-- ///////////////////////////////////////////// -->
         
         
        <!-- Jumbotron -->
        <div  id="espacio_info" class="jumbotron">
            <h1>Noticias</h1><br>
            <!-- Example row of columns -->
            <div class="row">
                <div id="partidos" class="col-lg-4">
                    <?php
                         if($this->partidos != null) {
                             if(Utils::conectado()){
                            if(($_SESSION['Usuario'])->getPermiso() == 0){
                            ?>
                            <h5>¡Apúntate a nuestros partidos!</h5>
                            <p id="justificar">
                            <?php
                            while($this->fila = ($this->partidos)->fetch_assoc()) {
                                $id = $this->fila['id_partido'];
                                $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id);
                                $url = "index.php?controller=partidos&action=APUNTARSE&idpartido=" . $id;
                                if($numPlazas != 0){
                                ?>
                                <li class="list-group-item">
                                    <strong><?php echo date('d-m-Y',strtotime($this->fila['fecha'])); ?></strong><br>
                                    <p>Se jugará a las <?php echo date('H:i',strtotime($this->fila['hora'])); ?><br>
                                    ¡Quedan <?php echo $numPlazas; ?> plazas libres!</p>
                                    <p><a class="btn btn-dark" href="<?php echo $url; ?>" role="button">Apuntarse</a></p>
                                </li>
                                <?php
                                }
                            }
                            ?>
                            </p>
                            <?php
                            }
                            else{
                                ?>
                            <h5>Partidos abiertos</h5>
                            <p id="justificar">
                            <?php
                            while($this->fila = ($this->partidos)->fetch_assoc()) {
                                $id = $this->fila['id_partido'];
                                $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id);
                                ?>
                                <li class="list-group-item">
                                    <strong><?php echo date('d-m-Y',strtotime($this->fila['fecha'])); ?></strong><br>
                                    <p>Se jugará a las <?php echo date('H:i',strtotime($this->fila['hora'])); ?><br>
                                    Quedan <?php echo $numPlazas; ?> plazas libres</p>
                                    <?php
                                    if($numPlazas == 0){
                                        ?>
                                    <p><a class="btn btn-dark" href="#" role="button">Cerrar partido</a></p>
                                </li>
                                <?php
                                }
                            }
                            ?>
                            </p>
                            <?php
                            }
                    }
                    else{
                        ?>
                        <h5>¡Únete al club para poder apuntarte a los partidos!</h5>
                            <p id="justificar">
                            <?php
                            while($this->fila = ($this->partidos)->fetch_assoc()) {
                                $id = $this->fila['id_partido'];
                                $numPlazas = (new PartidoMapper())->getNumPlazasLibres($id);
                                if($numPlazas != 0){
                                ?>
                                <li class="list-group-item">
                                    <strong><?php echo date('d-m-Y',strtotime($this->fila['fecha'])); ?></strong><br>
                                    <p>Se jugará a las <?php echo date('H:i',strtotime($this->fila['hora'])); ?><br>
                                    ¡Quedan <?php echo $numPlazas; ?> plazas libres!</p>
                                </li>
                                <?php
                                }
                            }
                            ?>
                            </p>
                    <?php
                    }
                }
                else{
                    ?>
                    <h5>No hay partidos disponibles en este momento.</h5>
                <?php
                }
                    ?>
                </div>
                <div class="col-lg-4">
                    <h2>Nuevos campeonatos</h2>
                    <p id="justificar">Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                </div>
                <div class="col-lg-4">
                    <h2>Nuevas reglas</h2>
                    <p id="justificar">Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
                    <p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
                </div>
            </div>
        </div>
        <?php
    }
}
?>